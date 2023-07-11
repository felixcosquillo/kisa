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
        <div data-options="region:'center',title:'Asesores' ">
            <h2>Administración de Asesores</h2>
            <p>Haga clic en los botones de la barra de herramientaspara realizar acciones básicas.</p>

            <table id="dg" title="Mi Asesores" class="easyui-datagrid" style="width:100%;height:100%"
                url="php/asesor/select_asesor.php" toolbar="#toolbar" pagination="true" rownumbers="true"
                fitColumns="true" singleSelect="true">
                <thead>
                    <tr> 
                        <th field="ase_id" width="50">ID</th>
                        <th field="ase_cedula" width="50">Cédula </th>
                        <th field="ase_nombre" width="50">Nombre</th>
                        <th field="ase_telefono" width="50">Teléfono</th>
                        <th field="ase_direccion" width="50">Dirección</th>
                        <th field="sup_nombre" width="50">Supervisor</th>
                        <th field="usu_login" width="50">Usuario</th>

                    </tr>
                </thead>
            </table>
            <div id="toolbar">
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add2" plain="true"
                    onclick="newUser()">AGREGAR</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true"
                    onclick="editUser()">EDITAR</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true"
                    onclick="destroyUser()">ELIMINAR</a>
            </div>


            <div id="dlg" class="easyui-dialog" style="width:400px"
                data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
                <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
                    <h3>Información de asesores</h3>
                    <div style="margin-bottom:10px">
                        <input id="ase_id" name="ase_id" class="easyui-textbox" label="ID:" style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input name="ase_cedula" id="ase_cedula"  minlength="10" maxlength = "10" class="easyui-textbox" required="true" label="Cedula:"
                            style="width:100%">
                    </div>
                    <div style="margin-bottom:10px">
                        <input name="ase_nombre" class="easyui-textbox" required="true" label="Nombre:"
                            style="width:100%">
                    </div>

                    <div style="margin-bottom:10px">
                        <input name="ase_telefono" class="easyui-textbox" required="true" label="Teléfono:"
                            style="width:100%">
                    </div>

                    <div style="margin-bottom:10px">
                        <input name="ase_direccion" class="easyui-textbox" required="true" label="Dirección:"
                            style="width:100%">
                    </div>

                    <div style="margin-bottom:10px">
                        <select class="easyui-combobox" id="supervisor"  required="true"   name="supervisor" label="Supervisor:" style="width:100%;">
                        </select>
                    </div>

                    <div style="margin-bottom:10px">
                        <select class="easyui-combobox" id="usu_login"  required="true"  name="usu_login" label="Usuario:" style="width:100%;">
                        </select>
                    </div>

                </form>
            </div>
            <div id="dlg-buttons">
                <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()"
                    style="width:90px">Save</a>
                <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel"
                    onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
            </div>
            <script type="text/javascript">
            var url;
            $('#usu_login').combobox({
                url: 'php/supervisor/select_usuario.php',
                valueField: 'usu_login',
                textField: 'usu_login'
            });
            $('#supervisor').combobox({
                url: 'php/asesor/select_supervisor.php',
                valueField: 'sup_id',
                textField: 'sup_nombre'
            });
 
            function newUser() {
                $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Nuevo Asesor');
                $('#ase_id').textbox('readonly', true);
               
                $('#fm').form('clear');
                url = 'php/asesor/insert_asesor.php';
            }

            function editUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Modificar Usuario');
                    $('#fm').form('load', row);
                    $('#ase_id').textbox('readonly', true);
                    url = 'php/asesor/update_asesor.php?id=' + row.sup_id;
                }
            }

            function saveUser() {
                $('#fm').form('submit', {
                    url: url,
                    iframe: false,
                    onSubmit: function() {
                        if( validarCedula( $("#ase_cedula").val()) == false ){
                            $.messager.show({ // show error message
                                        title: 'Error',
                                        msg:'La cedula es INCORRECTA'
                                    });
                            return false;
                        }
                      

                        return $(this).form('validate');
                    },
                    success: function(result) {
                        var result = eval('(' + result + ')');
                        if (result.errorMsg) {
                            $.messager.show({
                                title: 'Error',
                                msg: result.errorMsg
                            });
                        } else {
                            $('#dlg').dialog('close'); // close the dialog
                            $('#dg').datagrid('reload'); // reload the user data
                        }
                    }
                });
            }

            function destroyUser() {
                var row = $('#dg').datagrid('getSelected');
                if (row) {
                    $.messager.confirm('Confirme', '¿Estás seguro de que quieres eliminar a este asesor?', function(
                    r) {
                        if (r) {
                            $.post('php/asesor/delete_asesor.php', {
                                id: row.usu_login
                            }, function(result) {
                                if (result.success) {
                                    $('#dg').datagrid('reload'); // reload the user data
                                } else {
                                    $.messager.show({ // show error message
                                        title: 'Error',
                                        msg: result.errorMsg
                                    });
                                }
                            }, 'json');
                        }
                    });
                }
            }

     function validarCedula(cedula) {
    // Validar longitud de la cédula
    if (cedula.length !== 10) {
        return false;
    }

    // Validar que la cédula solo contenga números
    if (!/^\d+$/.test(cedula)) {
        return false;
    }

    // Extraer los dígitos de la cédula
    const digitos = cedula.split('').map(Number);

    // Validar el primer dígito (tipo de cédula)
    if (digitos[0] < 1 || digitos[0] > 3) {
        return false;
    }

    // Validar el tercer dígito (dígito verificador)
    const coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
    let suma = 0;
    for (let i = 0; i < 9; i++) {
        let producto = digitos[i] * coeficientes[i];
        suma += producto >= 10 ? producto - 9 : producto;
    }
    let modulo = suma % 10;
    let digitoVerificador = modulo === 0 ? 0 : 10 - modulo;
    if (digitoVerificador !== digitos[9]) {
        return false;
    }

    // Si todas las validaciones pasan, la cédula es válida
    return true;
}
            </script>
        </div>
    </div>
</body>

</html>