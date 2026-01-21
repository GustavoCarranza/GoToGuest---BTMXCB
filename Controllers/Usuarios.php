<?php

class Usuarios extends Controllers
{

    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        getPermisos(2);
    }

    public function Usuarios()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Users";
        $data['page_main'] = "Users";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "functions_user.js";
        $this->views->getView($this, "usuarios", $data);
    }

    //Metodo para extraer los registros a la tabla usuarios
    public function getUsuarios()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectUsuarios();
            for ($i = 0; $i < count($arrData); $i++) {
                //Creamos 3 variables para acceder a la invocacion del metodo a crear
                $btnView = "";
                $btnUpdate = "";
                $btnDelete = "";

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>';
                } else {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
                }

                if ($arrData[$i]['email_verified'] == 1) {
                    $arrData[$i]['email_verified'] = '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>';
                } else {
                    $arrData[$i]['email_verified'] = '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
                }

                //Creamos las validacion a los botones segun el permiso asignado
                if ($_SESSION['permisosModulo']['r']) {
                    $btnView =
                        '<button class="btn btn-sm" style="background-color:#686868; color:#fff" onclick="btnViewUsuario(' . $arrData[$i]['idUsuario'] . ')" title = "Ver usuario"><i class="fas fa-eye"></i></button>';
                }
                if ($_SESSION['permisosModulo']['u']) {
                    //Aqui validamos si el usuario es 1 o sea el super admin y aparte ese usuario tiene rol 1 es decir el administrador
                    if (
                        ($_SESSION['idUsuario'] == 1 and $_SESSION['UserData']['idRol'] == 1) ||
                        ($_SESSION['UserData']['idRol'] == 1 and $arrData[$i]['idRol'] != 1)
                    ) {
                        $btnUpdate =
                            '<button class="btn btn-sm" style="background-color:#686868; color:#fff" onclick="btnUpdatePass(' . $arrData[$i]['idUsuario'] . ')" title = "Cambiar password a usuario"><i class="fas fa-lock"></i></button>

                        <button class="btn btn-sm" style="background-color:#686868; color:#fff" onclick="btnUpdateUser(this,' . $arrData[$i]['idUsuario'] . ')" title = "Actualizar usuario"><i class="fas fa-edit"></i></button>';
                    } else {
                        $btnUpdate = '
                        
                        <button class="btn btn-sm" style="background-color:#686868; color:#fff" disabled><i class="fas fa-lock"></i></button>

                        <button class="btn btn-sm" style="background-color:#686868; color:#fff" disabled><i class="fas fa-edit"></i></button>';
                    }
                    if ($_SESSION['permisosModulo']['d']) {
                        if (
                            ($_SESSION['idUsuario'] == 1 and $_SESSION['UserData']['idRol'] == 1) ||
                            ($_SESSION['UserData']['idRol'] == 1 and $arrData[$i]['idRol'] != 1) and
                            ($_SESSION['UserData']['idUsuario'] != $arrData[$i]['idUsuario'])
                        ) {
                            $btnDelete = '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedUser(' . $arrData[$i]['idUsuario'] . ')" title = "Eliminar usuario"><i class="fas fa-trash"></i></button>';
                        } else {
                            $btnDelete = '<button class="btn btn-sm" style="background: #800000; color:#fff;" disabled><i class="fas fa-trash"></i></button>';
                        }
                    }
                }

                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para agregar usuarios a la bd 
    public function setUsuario()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos si existe una peticion POST
            if ($_POST) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['num_colaborador']) || empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtCorreo']) || empty($_POST['txtUsuario']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']) || empty($_POST['listDepartamento']) || empty($_POST['listTipoRol']) || empty(['listStatus'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect data');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strColaborador = ucwords((strClean($_POST['num_colaborador'])));
                    $strNombres = ucwords(strClean($_POST['txtNombres']));
                    $strApellidos = ucwords(strClean($_POST['txtApellidos']));
                    $strCorreo = strtolower(strClean($_POST['txtCorreo']));
                    $strUsuario = strClean($_POST['txtUsuario']);
                    $intDepartamento = intval(strClean($_POST['listDepartamento']));
                    $intTipoid = intval(strClean($_POST['listTipoRol']));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    $request_user = "";
                    //Creamos la variable para el password y lo encriptamos 
                    $strPassword = hash("SHA256", $_POST['txtPassword']);
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->insertUsuario($strColaborador, $strNombres, $strApellidos, $strCorreo, $strUsuario, $strPassword, $intDepartamento, $intTipoid, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        //Declaramos el token
                        $token = token();
                        $expires_at = date("Y-m-d H:i:s", strtotime("+24 hours"));
                        $type = 'email_verify';
                        //Crear variable y pasar los paramatros a la BD 
                        $insertToken = $this->model->insertTokenValidation($request_user, $token, $type, $expires_at);
                        //Validamos la respuesta
                        if ($insertToken) {
                            //Enviar correo con el token
                            $enviado = sendEmailVerification($strCorreo, $token, $strNombres);
                            if ($enviado) {
                                $arrReponse = array(
                                    'status' => true,
                                    'msg' => 'User Created, please check your email to verify your account.',
                                    'debug' => $enviado
                                );
                            } else {
                                $arrReponse = array('status' => false, 'msg' => "User saved but failed to send verification email");
                            }
                        } else {
                            $arrReponse = array('status' => false, 'msg' => 'User saved but failed to save verification token.');
                        }

                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ the user or the e-mail or No. Employee already exists, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmition');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del usuario
    public function getUsuario($idUsuario)
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $idusuario = intval($idUsuario);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
                //Si el arreglo esta vacio mostrara un msj de error
                if (empty($arrData)) {
                    $arrReponse = array('status' => false, 'msg' => 'Data not found');
                    //En caso contrario imprimira el arreglo de datos
                } else {
                    $arrReponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    //Metodo para cambiar la contraseña al usuario
    public function updatePass($idUsuario)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idusuario = intval($idUsuario);
            if ($_POST && $idusuario > 0) {
                // Verificar si los campos de contraseña no están vacíos
                if (empty($_POST['txtUpdatePassword']) || empty($_POST['txtUpdatePasswordConfirm'])) {
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect data');
                } else {
                    $strPassword = strClean($_POST['txtUpdatePassword']);
                    $request_user = "";
                    // Hash de la contraseña
                    $strPasswordHashed = hash("SHA256", $strPassword);
                    // Llamar al método updatePassword del modelo para cambiar la contraseña
                    $request_user = $this->model->updatePassword($idusuario, $strPasswordHashed);
                    if ($request_user) {
                        $arrReponse = array('status' => true, 'msg' => 'Password correctly updated');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => 'Unable to update password');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    //Metodo para editar informacion del usuario
    public function updateUsuario($idUsuario)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idusuario = intval($idUsuario);
            //Validamos que haya una repuesta de tipo POST
            if ($_POST && $idusuario > 0) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['num_colaboradorUpdate']) || empty($_POST['txtNombresUpdate']) || empty($_POST['txtApellidosUpdate']) || empty($_POST['txtCorreoUpdate']) || empty($_POST['txtUsuarioUpdate']) || empty($_POST['listDepartamentoUpdate']) || empty($_POST['listTipoRolUpdate']) || empty($_POST['listStatusUpdate'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect data');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strColaborador = ucwords(strClean($_POST['num_colaboradorUpdate']));
                    $strNombres = ucwords(strClean($_POST['txtNombresUpdate']));
                    $strApellidos = ucwords(strClean($_POST['txtApellidosUpdate']));
                    $strCorreo = strtolower(strClean($_POST['txtCorreoUpdate']));
                    $strUsuario = strClean($_POST['txtUsuarioUpdate']);
                    $intDepartamento = intval(strClean($_POST['listDepartamentoUpdate']));
                    $intRol = intval(strClean($_POST['listTipoRolUpdate']));
                    $intStatus = intval(strClean($_POST['listStatusUpdate']));
                    $request_user = "";
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->updateUsuario($idusuario, $strColaborador, $strNombres, $strApellidos, $strCorreo, $strUsuario, $intDepartamento, $intRol, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Correctly updated data');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ the user or the e-mail already exists, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    //Metodo para eliminar el usuario 
    public function deleteUsuario($idUsuario)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir $idUsuario en un entero
            $idusuario = intval($idUsuario);

            // Validar que $idUsuario sea un número entero positivo
            if ($idusuario <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid user ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de usuario es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteUsuarios($idusuario);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'The user has been deleted');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible to delete the user');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //SEPARACION PARA EL APARTADO DE PERFIL//
    public function Perfil()
    {
        $data['page_title'] = "Profile";
        $data['page_main'] = "Profile";
        $data['page_name'] = "Profile";
        $data['page_functions_js'] = "Functions_Perfil.js";
        $this->views->getView($this, "perfil", $data);
    }

    //Metodo para cambiar la contraseña del usuario
    public function updatePassPerfil()
    {
        if ($_POST) {
            if (empty($_POST['txtPasswordActual']) || empty($_POST['txtPasswordNew']) || empty($_POST['txtPasswordNewConfirm'])) {
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                $idUsuario = $_SESSION['idUsuario'];
                $strPasswordActual = strClean($_POST['txtPasswordActual']);
                $strPasswordHashed = hash("SHA256", $strPasswordActual);
                $strPasswordNew = strClean($_POST['txtPasswordNew']);
                $strPasswordHashedNew = hash("SHA256", $strPasswordNew);

                // Verificar si la contraseña actual coincide con la almacenada en la base de datos
                $request_user = $this->model->checkPasswordPerfil($idUsuario, $strPasswordHashed);

                if ($request_user > 0) {
                    // Llamar al método updatePassword del modelo solo si la contraseña actual es correcta
                    $request_update = $this->model->updatePasswordPerfil($idUsuario, $strPasswordHashed, $strPasswordHashedNew);

                    if ($request_update > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Password changed correctly');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ Something has happened in the password update process');
                    }
                } else {
                    $arrReponse = array('status' => false, 'msg' => '¡Attention! The current password is incorrect');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
