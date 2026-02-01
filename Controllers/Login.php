<?php

class Login extends Controllers
{
    public function __construct()
    {
        //validar la variable de sesion esta creada, es decir que un usuario ya inicio sesion no permita regresar al login hasta que cierre sesion
        session_start();
        $url = $_GET['url'] ?? '';
        // Métodos públicos (NO redirigir)
        $publicRoutes = [
            'Login',
            'Login/loginUser',
            'Login/ResetPassword',
            'Login/requestResetPassword',
            'Login/resetPasswordForm',
            'Login/updatePassword'
        ];
        if (isset($_SESSION['login']) && !in_array($url, $publicRoutes)) {
            header('location: ' . Base_URL() . '/Dashboard');
            die();
        }
        parent::__construct();
    }

    public function Login()
    {
        $data['page_title'] = "Login";
        $data['page_main'] = "Login";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "Function_Login.js";
        $this->views->getView($this, "login", $data);
    }

    //Metodo para realizar la validacion
    public function loginUser()
    {
        if ($_POST) {
            if (empty($_POST['txtUser']) || empty($_POST['txtPassword'])) {
                $arrResponse = ['status' => false, 'msg' => 'Error de datos'];
            } else {
                $strUsuario = strClean($_POST['txtUser']);
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);

                if (empty($requestUser)) {
                    $arrResponse = ['status' => false, 'msg' => 'The user or password is incorrect'];
                } else {
                    $arrData = $requestUser;

                    if ($arrData['status'] != 1) {
                        $arrResponse = ['status' => false, 'msg' => 'The user is inactive'];
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        return;
                    }

                    if ($arrData['email_verified'] != 1) {
                        // Obtener el ID del usuario
                        $userId = $arrData['idUsuario'];

                        // Declaramos el token
                        $token = token();
                        $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
                        $type = 'email_verify';

                        // Crear variable y pasar los parámetros a la BD
                        $insertToken = $this->model->insertTokenValidation($userId, $token, $type, $expires_at);

                        // Validamos la respuesta
                        if ($insertToken) {
                            // Enviar correo con el token
                            $strCorreo = $arrData['email'];
                            $strNombres = $arrData['nombres'];
                            $enviado = sendEmailVerification($strCorreo, $token, $strNombres);

                            if ($enviado) {
                                $arrResponse = ['status' => false, 'msg' => 'Cuenta no verificada, Revisa tu correo para activarla'];
                                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                                return;
                            } else {
                                $arrResponse = array(
                                    'status' => false,
                                    'msg' => 'Usuario encontrado, pero no se pudo enviar el correo de verificación.'
                                );
                            }
                        } else {
                            $arrResponse = array(
                                'status' => false,
                                'msg' => 'Usuario encontrado, pero no se pudo guardar el token de verificación.'
                            );
                        }

                        // Retornar respuesta JSON
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        return;
                    }

                    $_SESSION['idUsuario'] = $arrData['idUsuario'];
                    $_SESSION['login'] = true;
                    $_SESSION['timeout'] = true;
                    $_SESSION['inicio'] = time();
                    $_SESSION['UserData'] = $this->model->sessionLogin($_SESSION['idUsuario']); // datos completos desde modelo

                    $arrResponse = ['status' => true, 'msg' => 'ok'];
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
    }


    //SEPARACION PARA CAMBIO DE CONTRASEÑA
    public function ResetPassword()
    {
        $data['page_title'] = "Reset Password";
        $data['page_main'] = "Reset Password";
        $data['page_name'] = "Reset Password";
        $data['page_functions_js'] = "function_reset_password.js";
        $this->views->getView($this, "password", $data);
    }

    //Metodo para capturar el correo, enviar token y correo
    public function requestResetPassword()
    {
        if ($_POST) {
            //Validar que venga el email
            if (empty($_POST['txtEmail'])) {
                $arrResponse = array('status' => true, 'msg' => 'Hemos enviado instrucciones a tu correo, por favor de verificar.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            }

            //Limipar el email
            $email = strClean($_POST['txtEmail']);
            //Enviamos al modelo
            $user = $this->model->getUserByEmail($email);
            //Si existe, generamos token y enviar correo
            if (!empty($user)) {
                $token = token();
                $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
                $type = "password_reset";
                $this->model->insertTokenValidation($user['idUsuario'], $token, $type, $expires_at);

                //Enviar correo
                sendEmailResetPassword($email, $token, $user['nombres']);
            }
            $arrResponse = array('status' => true, 'msg' => 'Hemos enviado instrucciones a tu correo, por favor de verificar.');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            return;
        }
    }

    //Metodo para validar Token desde correo
    public function resetPasswordForm()
    {
        if (empty($_GET['token'])) {
            $this->views->getView($this, "token_error");
            die();
        }

        $token = strClean($_GET['token']);

        // Buscar token válido
        $tokenData = $this->model->getTokenData($token, 'password_reset');

        //No existe
        if (empty($tokenData)) {
            $this->views->getView($this, "token_error");
            die();
        }

        //Expirado
        if (strtotime($tokenData['expires_at']) < time()) {
            $this->views->getView($this, "token_error");
            die();
        }
        // ✅ Token válido → mostrar formulario
        $data['page_title'] = "Reset Password";
        $data['token'] = $token;
        $data['page_functions_js'] = "function_reset_password.js";
        $this->views->getView($this, "reset_form", $data);
    }

    //Metodo para cambiar contraseña
    public function updatePassword()
    {
        if ($_POST) {
            if (empty($_POST['password']) || empty($_POST['token'])) {
                $arrResponse = array('status' => false, 'msg' => 'Missing data');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            }
            $password = $_POST['password'];
            $token = strClean($_POST['token']);
            //Validar token
            $tokenData = $this->model->getTokenData($token, 'password_reset');
            if (empty($tokenData)) {
                $arrResponse = array('status' => false, 'msg' => 'Token invalid or expired');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            }
            if (strtotime($tokenData['expires_at']) < time()) {
                $arrResponse = array('status' => false, 'msg' => 'Token expired');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            }
            //Hashear contraseña
            $passwordHash = hash("SHA256", $password);
            //Actualiza password
            $update = $this->model->updateUserPassword($tokenData['user_id'], $passwordHash);
            if ($update) {
                //Eliminar token
                $this->model->deleteToken($token);
                $arrResponse = array('status' => true, 'msg' => 'Your password has been updated succesfully');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Password could not be updated');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                return;
            }
        }
        die();
    }

}
?>