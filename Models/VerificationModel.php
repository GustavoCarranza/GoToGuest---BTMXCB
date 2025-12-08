<?php

class VerificationModel extends Mysql
{
    private $intIdUsuario;
    private $strToken;
    private $strType;
    private $strExpires;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para generar token
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

    //Metodo para obtener token de la tabla 
    public function getTokenData(string $token)
    {

        $sql = "SELECT * FROM token_validation WHERE token = ? AND used = 0 AND expires_at > NOW()";
        $request = $this->selectParam($sql, [$token]);
        return $request;
    }

    //Metodo para obtener usuario por el ID
    public function getUserById(int $id)
    {
        $this->intIdUsuario = $id;
        $sql = "SELECT * FROM usuarios WHERE idUsuario = $this->intIdUsuario";
        return $this->select($sql);
    }

    //Metodo para verificar la cuenta 
    public function verifyUser($id)
    {
        $sql = "UPDATE usuarios SET email_verified = 1 WHERE idUsuario = ?";
        return $this->update($sql, [$id]);
    }

    //Metodo para eliminar token
    public function deleteToken(string $token)
    {
        $sql = "DELETE FROM token_validation WHERE token = ?";
        return $this->deleteParam($sql, [$token]);
    }

}

?>