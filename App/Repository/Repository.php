<?php

namespace App\Repository;


trait Repository
{

    public function __construct()
    {
        $this->connection = \App\Repository\Connection::getMainInstance();
    }

    public function getConnectionDbClient()
    {
        return \App\Repository\Connection::getMainInstanceClient();
    }

    public function transformItem($register)
    {

        if (isset($register['0'])) {
            $register = $register['0'];
        }
        $class = $this->getMapperClassName();
        return new $class($register);
    }

    public function transformItemModule($register)
    {

        if (isset($register['0'])) {
            $register = $register['0'];
        }
        $class = '\App\Repository\Modules\ModuleMap';
        return new $class($register);
    }

    protected function getSqlBetween($campo, $de, $ate)
    {
        return $campo . ' BETWEEN "' . $de . '" AND "' . $ate . '"';
    }

    public function transformList($registers)
    {
        if (is_array($registers)) {
            $list = array();
            $class = $this->getMapperClassName();
            foreach ($registers as $register) {
                $list[] = new $class($register);
            }
            return $list;
        }
    }

    public function getMapperClassName()
    {
        $class = get_class($this) . 'Map';
        return $class;
    }

    public function existsTable($nameTable)
    {
        $db = $this->getConnectionDbClient();
        if ($db->tableExists($nameTable)) {
            return true;
        }
        return false;
    }

    public function getByTableWithoutMapper($nameTable)
    {
        $db = $this->getConnectionDbClient();
        $nameTable = $db->escape($nameTable);
        $content = $db->get($nameTable);
        if (!empty($content)) {
            return $content;
        }
    }

    public function existsRegisterInTable($nameTable, $columnVerify, $keyVerify)
    {
        $db = $this->getConnectionDbClient();
        $columnVerify = $db->escape($columnVerify);
        $keyVerify = $db->escape($keyVerify);
        $nameTable = $db->escape($nameTable);
        $field = $db->rawQuery('SELECT COUNT(*) FROM '  . $nameTable . ' WHERE ' . $columnVerify  . ' = ' . $keyVerify);
        if ($field > 0) {
            return true;
        }
        return false;
    }

    public function existsField($nameField, $table)
    {
        $db = $this->getConnectionDbClient();
        $nameField = $db->escape($nameField);
        $table = $db->escape($table);
        $field = $db->rawQuery(
            'SELECT * from information_schema.COLUMNS where TABLE_SCHEMA = ?
            AND COLUMN_NAME = ? AND TABLE_NAME = ?',
            array(\App\Factory::getInstance('Session')->get('clientDb'), $nameField, $table)
        );
        if (!empty($field)) {
            return true;
        }
        return false;
    }

    protected function treatToInsert($data)
    {
        $mapperClass = $this->getMapperClassName();
        $map = new $mapperClass();
        foreach ($data as $key => $value) {
            $newKey = $map::getFieldName($key);
            if (!empty($newKey)) {
                $data[$newKey] = $value;
            }
            unset($data[$key]);
        }
        return $data;
    }
}
