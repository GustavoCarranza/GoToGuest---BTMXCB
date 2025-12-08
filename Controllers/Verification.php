<?php

class Verification extends Controllers
{
    //SEPARACION PARA LA VERIFICACION DEL CORREO
    public function email_verified()
    {
        $data['page_title'] = "DQR - E-mail Verified";
        $data['page_main'] = "DQR - E-mail Verified";
        $data['page_name'] = "email_verified";
        $data['page_functions_js'] = "functions_verified.js";
        $this->views->getView($this, "email_verified", $data);
    }

    //metodo para activar la cuenta
    public function active_account()
    {
        //Leemos el json enviado desde el front a traves del fetch
        $data = json_decode(file_get_contents("php://input"), true);
        $token = $data['token'] ?? null;

        //Validamos que el token se recibió
        if (!$token) {
            $arrReponse = array('status' => false, 'msg' => 'Token no recibido');
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            return;
        }

        //Buscar el token en la BD
        $tokenData = $this->model->getTokenData($token);

        if (empty($tokenData)) {
            $arrReponse = array('status' => false, 'msg' => 'Token invalido o no existe');
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            return;
        }

        //Validar la expiracion del token
        $now = strtotime(date("Y-m-d H:i:s"));
        $expires = strtotime($tokenData['expires_at']);
        if ($expires < $now) {
            //Si ya expiro, borrarlo por seguridad
            $this->model->deleteToken($token);
            $arrReponse = array('status' => false, 'msg' => 'El enlace de verificacion ha expirado');
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            return;
        }

        //Obtener el ID del usuario
        $userId = $tokenData['user_id'];
        //Buscar al usuario
        $user = $this->model->getUserById($userId);
        if (empty($user)) {
            $arrReponse = array('status' => false, 'msg' => 'El usuario asociado a este token no existe');
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            return;
        }

        //Activar cuenta
        $this->model->verifyUser($userId);
        //Eliminar token por seguridad al activar la cuenta
        $this->model->deleteToken($token);
        //Respuesta al front
        $arrReponse = array('status' => true, 'msg' => 'Cuenta verificada');

        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
    }
}

?>