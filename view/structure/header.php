<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    <title><?= $titlePage ?></title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <?= \App\Factory::getInstance('Styles')->getStyles() ?>
    <meta property="og:image" content="<?= BASE . CAMINHO_LOGO ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= BASE ?>" />
    <base href="<?= URL_BASE ?>">
    <link rel="icon" type="image/x-icon" href="<?= CAMINHO_IMAGENS ?>favicon.ico">
    <?= \App\Factory::getInstance('Header')->getScripts() ?>
    <script type="text/javascript">
        WebFont.load({
            google: {
                families: ["Open Sans:300,300italic,400,400italic,600,600italic,700,700italic,800,800italic", "Great Vibes:400", "Lato:100,100italic,300,300italic,400,400italic,700,700italic,900,900italic", "Oswald:200,300,400,500,600,700", "Roboto:100,300,regular,500,700,900"]
            }
        });
    </script>
    <link href="<?= CAMINHO_IMAGENS ?>icon.png" rel="shortcut icon" type="image/x-icon">
  </head>
<body>