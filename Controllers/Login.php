<?php

class Login extends Controllers
{
    public function __construct()
    {
        //validar la variable de sesion esta creada, es decir que un usuario ya inicio sesion no permita regresar al login hasta que cierre sesion
        session_start();
        if (isset($_SESSION['login'])) {
            header('location: ' . Base_URL() . '/Dashboard');
        }
        parent::__construct();
    }

    public function Login()
    {
        $data['page_title'] = "DQR - Login";
        $data['page_main'] = "DQR - Login";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "functions_login.js";
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
                        $expires_at = date("Y-m-d H:i:s", strtotime("+24 hours"));
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

}
?>