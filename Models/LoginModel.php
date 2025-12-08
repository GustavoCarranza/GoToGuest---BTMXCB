<?php

class LoginModel extends Mysql
{

    //Propiedades
    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;
    private $strToken;
    private $strType;
    private $strExpires;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para el funcionamiento del login
    public function loginUser(string $usuario, string $password)
    {
        $sql = "SELECT idUsuario, usuario, nombres, email, password, status, email_verified 
            FROM usuarios 
            WHERE usuario = ? AND password = ?";
        $arrData = array($usuario, $password);
        return $this->selectParam($sql, $arrData);
    }

    //Metodo para extraer la informacion del usuario logueado
    public function sessionLogin(int $iduser)
    {
        $sql = "SELECT u.idUsuario, u.nombres, u.apellidos, u.email, 
                   u.usuario, u.status, u.email_verified,
                   r.idRol, r.nombre 
            FROM usuarios u 
            INNER JOIN roles r ON u.rolid = r.idRol 
            WHERE u.idUsuario = ?";

        return $this->selectParam($sql, [$iduser]);
    }

    //Metodo para envio de correo electronico
    public function insertTokenValidation(int $request_user, string $token, string $type, string $expires_at)
    {
        $this->intIdUsuario = $request_user;
        $this->strToken = $token;
        $this->strType = $type;
        $this->strExpires = $expires_at;

        $sql = "INSERT INTO token_validation (user_id, token, type, expires_at, used) VALUES (?,?,?,?,0)";
        $arrData = array($this->intIdUsuario, $this->strToken, $this->strType, $this->strExpires);
        $request_insert = $this->insert($sql, $arrData);
        return $request_insert;
    }
}
