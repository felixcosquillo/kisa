<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title> KISAPINCHA </title>
    <link rel="icon" href="uti.ico">
    <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="themes/icon.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/easyui-lang-es.js"></script>
</head>

<body>
    <div class="easyui-layout" fit="true">
        <?php include('encabezado.php') ?>

        <div data-options="region:'west',split:true" title="Opciones" style="  width:200px; ">
            <?php include('menu.php') ?>
        </div>
        <div data-options="region:'center' ">

            <h1>
                Bienvenido
            </h1>
        </div>
    </div>

</body>

</html>