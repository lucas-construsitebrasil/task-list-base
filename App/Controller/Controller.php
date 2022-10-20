<?php

namespace App\Controller;

class Controller
{

    protected $model, $data, $output = '', $nameTemplate, $internalOutput, $message, $additionalDataMsg, $justMiddle = false, $bussiness;
    protected static $dataStructure = array();

    static function setDataStructure($indice, $valor)
    {
        self::$dataStructure[$indice] = $valor;
    }

    function getMessage()
    {
        return $this->message;
    }

    function getAdditionalDataMsg()
    {
        return $this->additionalDataMsg;
    }

    protected function getFriendUrl()
    {
        return \App\Lib\FriendlyUrl::getInstance();
    }

    protected function verifyAccessLevel($userAuthorized = 5)
    {
        $session = \App\Lib\Session::getInstance();
        $userAccessLevel = $session->getAccessLevelUser();
        if ($userAccessLevel != $userAuthorized) {
            $this->forbidden();
        }
    }

    protected function verifyEditItemExists($data)
    {
        if (!empty($data)) {
            return true;
        }
        $this->notFound();
    }

    public function __construct()
    {
        $this->header = \App\Lib\HeaderAndFooter::getInstance();
        $this->data = array();
        $class = '\App\Business\\' . str_replace('App\Controller\\', '', get_class($this));
        if (class_exists($class)) {
            $this->business = new $class;
        }
    }

   

    protected function invalidParameters()
    {
        throw new \Exception('invalidParameters controller');
    }


    public function getOutput()
    {
        return $this->output;
    }

    function getHeader()
    {
        return $this->header;
    }

    
    /**
     * esse metodo deve ser chamado no final de TODO controle que tem que incluir o buffer processado na sa�da geral
     */
    protected function render($tipo = 'template', $removeEnter = false)
    {
        $templateWithRightPath = 'view/' . ($this->nameTemplate) . '.php';
        if (file_exists($templateWithRightPath)) {
            $this->data['titlePage'] = $this->header->getTitle();
            extract($this->data);
            extract(self::$dataStructure);
            ob_start();
            require($templateWithRightPath);
            $this->output = ob_get_clean();
            if (AMBIENTE == 'production' || $removeEnter == true) {
                $this->output = preg_replace("/\s\s+/", ' ', str_replace("\n", '', $this->output));
            }
            if ($tipo == 'internal') {
                $this->internalOutput = $this->output;
                $this->output = '';
            } else {
                return $this->output;
            }
        } else {
            trigger_error('Error: Could not load template ' . $templateWithRightPath . '!');
            exit();
        }
    }

    function getJustMiddle()
    {
        return $this->justMiddle;
    }

    public function getHtmlNaoTemPermissao()
    {
        $this->nameTemplate = 'notPermission';
        $this->render();
    }

    public function podeAcao($reg, $acao)
    {
        return true;
    }

    protected function setTitle($str)
    {
        \App\Factory::getInstance('Header')->setTitle($str);
    }

    protected function appendJs($str, $externalJs = false)
    {
        if ($externalJs) {
            return  \App\Factory::getInstance('Header')->addScriptExternal($str);
        }
        \App\Factory::getInstance('Header')->addScript($str);
    }

    protected function appendCss($str, $externalStyle = false)
    {
        \App\Factory::getInstance('Styles')->addStyle($str, $externalStyle);
    }

    public function appendBreadCrumb($title, $url)
    {
        $this->data['linksBreadCrumb'][] = array('title' => $title, 'url' => $url);
    }

    protected function getRoute()
    {
        return \App\Factory::getInstance('FriendlyUrl');
    }

    protected function getRouteParam($param)
    {
        return \App\Factory::getInstance('FriendlyUrl')->getParameter($param);
    }

    protected function notFound()
    {
        \App\Lib\Url::redirect('404');
    }

    public function ajaxFriendlyGetRedirect()
    {
        $parametersGet = $_POST['parametersGet'];
        $urlWithoutGet = explode("/get", $_POST['currentUrl'])[0];
        $parametersGetInString = '/get/';
        foreach ($parametersGet as $get) {
            $parametersGetInString .= $get . '|';
        }
        echo \App\Lib\Json::encode(array('url' => $urlWithoutGet . substr($parametersGetInString, 0, -1)));
    }

    public function semPermissao()
    {
        $this->setTitle('Sem permissão');
        $this->nameTemplate = 'sem-permissao';
        $this->render();
    }

    protected function forbidden()
    {
        \App\Lib\Url::redirect('403');
    }

    protected function treatPostByDataTable($post)
    {
        if ($post['order']['0']['column'] != '') {
            foreach ($post['columns'] as $column) {
                $post['fields'][$column['name']] = (utf8_decode($column['search']['value']));
            }
            $post['orderBy'] = $post['columns'][$post['order']['0']['column']]['name'];
            $post['orderByDirection'] = $post['order']['0']['dir'];
        }
        if ($post['search']['value'] != '') {
            $post['generalSearch'] = (utf8_decode($post['search']['value']));
        }
        return $post;
    }

    public function isCanActionPartner()
    {
        $user = \App\Factory::getInstance('Session')->get('user');
        if ($user->isInadimplente() || $user->isSuspense()) {
            \App\Lib\Url::redirect('meus-pagamentos/3');
        } elseif ($user->isCanceled()) {
            \App\Lib\Url::redirect('meus-pagamentos/5');
        }
    }

    protected function setDatabreadcrumb($data)
    {
        $this->data['breadcrumb']['page'] = $data['page'];
        $this->data['breadcrumb']['return'] = $data['return'];
        $this->data['breadcrumb']['retPage'] = $data['retPage'];
    }
}
