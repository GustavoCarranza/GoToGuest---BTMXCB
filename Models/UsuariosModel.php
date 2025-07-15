<?php

class UsuariosModel extends Mysql
{
    //Propiedades
    private $intIdUsuario;
    private $strColaborador;
    private $strNombres;
    private $strApellidos;
    private $strEmail;
    private $strUsuario;
    private $strPassword;
    private $strPasswordNew;
    private $intIdDepartamento;
    private $intIdRol;
    private $intIdStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros a la tabla
    public function selectUsuarios()
    {
        $whereAdmin = "";
        // Si el usuario actual no es el super administrador, aplicamos la restricción
        if ($_SESSION['idUsuario'] != 1) {
            $whereAdmin = "AND u.idUsuario != 1";
        }

        $sql = "SELECT u.idUsuario,u.nombres,u.colaborador_num,u.apellidos,u.email,u.usuario,u.departamentoid,u.rolid,u.status,d.idDepartamento,d.nombre as nombreDepartamento,r.idRol,r.nombre as nombreRol,
        CONCAT(DAY(u.dateCreate), ' de ', 
        CASE MONTH(u.dateCreate)
            WHEN 1 THEN 'enero'
            WHEN 2 THEN 'febrero'
            WHEN 3 THEN 'marzo'
            WHEN 4 THEN 'abril'
            WHEN 5 THEN 'mayo'
            WHEN 6 THEN 'junio'
            WHEN 7 THEN 'julio'
            WHEN 8 THEN 'agosto'
            WHEN 9 THEN 'septiembre'
            WHEN 10 THEN 'octubre'
            WHEN 11 THEN 'noviembre'
            WHEN 12 THEN 'diciembre'
        END, ' del ', YEAR(u.dateCreate)) AS fechaCreacion,DATE_FORMAT(u.dateCreate, '%h:%i:%s %p') AS horaCreacion FROM usuarios u INNER JOIN departamento d ON u.departamentoid = d.idDepartamento INNER JOIN roles r ON u.rolid = r.idRol WHERE u.status != 0 $whereAdmin";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar usuarios a la base de datos 
    public function insertUsuario(string $colaborador, string $nombres, string $apellidos, string $correo, string $usuario, string $password, int $departamento, int $rol, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades
        $this->strColaborador = $colaborador;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strEmail = $correo;
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        $this->intIdDepartamento = $departamento;
        $this->intIdRol = $rol;
        $this->intIdStatus = $status;
        $return = 0;

        //Creamos la variable para la consulta a la bd
        $sql = "SELECT * FROM usuarios WHERE email = '{$this->strEmail}' or usuario = '{$this->strUsuario}' or colaborador_num = '{$this->strColaborador}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del usuario
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el usuario
            $query_insert = "INSERT INTO usuarios(colaborador_num,nombres,apellidos,email,usuario,password,departamentoid,rolid,status,dateCreate) VALUES (?,?,?,?,?,?,?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strColaborador, $this->strNombres, $this->strApellidos, $this->strEmail, $this->strUsuario, $this->strPassword, $this->intIdDepartamento, $this->intIdRol, $this->intIdStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer la informacion del usuario 
    public function selectUsuario(int $usuario)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intIdUsuario = $usuario;
        //Creamo la variable que tendran el script de la consulta a la BD 
        $sql = "SELECT u.idUsuario,u.colaborador_num,u.nombres,u.apellidos,u.email,u.usuario,u.departamentoid,u.rolid,u.status,d.idDepartamento,d.nombre as nombreDepartamento,r.idRol,r.nombre as nombreRol,
        CONCAT(DAY(u.dateCreate), ' de ', 
        CASE MONTH(u.dateCreate)
            WHEN 1 THEN 'enero'
            WHEN 2 THEN 'febrero'
            WHEN 3 THEN 'marzo'
            WHEN 4 THEN 'abril'
            WHEN 5 THEN 'mayo'
            WHEN 6 THEN 'junio'
            WHEN 7 THEN 'julio'
            WHEN 8 THEN 'agosto'
            WHEN 9 THEN 'septiembre'
            WHEN 10 THEN 'octubre'
            WHEN 11 THEN 'noviembre'
            WHEN 12 THEN 'diciembre'
        END, ' del ', YEAR(u.dateCreate)) AS fechaCreacion,DATE_FORMAT(u.dateCreate, '%h:%i:%s %p') AS horaCreacion FROM usuarios u INNER JOIN departamento d ON u.departamentoid = d.idDepartamento INNER JOIN roles r ON u.rolid = r.idRol WHERE u.idUsuario = $this->intIdUsuario";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para cambiar la contraseña 
    public function updatePassword(int $usuario, string $password)
    {
        $this->intIdUsuario = $usuario;
        $this->strPassword = $password;

        $sql = "UPDATE usuarios SET password = ? WHERE idUsuario = $this->intIdUsuario";
        $arrData = array($this->strPassword);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    //Metodo para eliminar usuario 
    public function deleteUsuarios(int $usuario)
    {
        // Asignamos el valor del parámetro a la propiedad
        $this->intIdUsuario = $usuario;

        // Consulta SQL para actualizar el estado del usuario
        $sql = "UPDATE usuarios SET status = ? WHERE idUsuario = ?";

        // Arreglo de datos para la consulta preparada
        $arrData = array(0, $this->intIdUsuario);

        // Ejecutar la consulta SQL
        $request = $this->update($sql, $arrData);

        // Verificar si la consulta fue exitosa y devolver el resultado
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    //Metodo para actualizar la informacion del usuario
    public function updateUsuario(int $idusuario, string $colaborador, string $nombres, string $apellidos, string $correo, string $usuario, int $departamento, int $rol, int $status)
    {
        //Asignamos los valores de los parametros a las propiedades 
        $this->intIdUsuario = $idusuario;
        $this->strColaborador = $colaborador;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strEmail = $correo;
        $this->strUsuario = $usuario;
        $this->intIdDepartamento = $departamento;
        $this->intIdRol = $rol;
        $this->intIdStatus = $status;
        //Creamos una variable para almacenar una consulta a la base para comprobar que el usuario y correo si los tiene un usuario que no es el mismo marque error pero si es el mismo id permita actualizar 
        $sql = "SELECT * FROM usuarios WHERE (email = '{$this->strEmail}' AND idUsuario != $this->intIdUsuario) OR (usuario = '{$this->strUsuario}' AND idUsuario != $this->intIdUsuario) OR (colaborador_num = '{$this->strColaborador}' AND idUsuario != $this->intIdUsuario)";
        $request = $this->select_All($sql);

        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE usuarios SET colaborador_num = ?, nombres = ?, apellidos = ?, email = ?, usuario = ?, departamentoid = ?, rolid = ?, status = ? WHERE idUsuario = $this->intIdUsuario";
            $arrData = array($this->strColaborador, $this->strNombres, $this->strApellidos, $this->strEmail, $this->strUsuario, $this->intIdDepartamento, $this->intIdRol, $this->intIdStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para actualizar informacion del perfil de usuario
    public function updatePerfil(int $idusuario, string $nombre, string $apellidos, string $correo, string $usuario)
    {
        //Asginamos los valores de los parametros a las propiedades 
        $this->intIdUsuario = $idusuario;
        $this->strNombres = $nombre;
        $this->strApellidos = $apellidos;
        $this->strEmail = $correo;
        $this->strUsuario = $usuario;
        //Creamos una variable para almacenar una consulta a la base para comprobar que el usuario y correo si los tiene un usuario que no es el mismo marque error pero si es el mismo id permita actualizar 
        $sql = "SELECT * FROM usuarios WHERE (email = '{$this->strEmail}' AND idUsuario != $this->intIdUsuario) OR (usuario = '{$this->strUsuario}' AND idUsuario != $this->intIdUsuario)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, email = ?, usuario = ? WHERE idUsuario = $this->intIdUsuario";
            $arrData = array($this->strNombres, $this->strApellidos, $this->strEmail, $this->strUsuario);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

     //Metodo para verificar que la contraseña actual coincida con la que se ingresa en el input
     public function checkPasswordPerfil(int $idUsuario, string $password)
     {
         $this->intIdUsuario = $idUsuario;
         $this->strPassword = $password;
 
         $sql = "SELECT * FROM usuarios WHERE idUsuario = '{$this->intIdUsuario}' AND password = '{$this->strPassword}'";
         $request = $this->select_All($sql);
         return $request ? 1 : 0;
     }

     //Metodo para cambiarla contraseña del perfil de usuario 
    public function updatePasswordPerfil(int $idUsuario, string $passActual, string $passNew)
    {
        $this->intIdUsuario = $idUsuario;
        $this->strPassword = $passActual;
        $this->strPasswordNew = $passNew;

        // Verificar si la contraseña actual coincide con la almacenada en la base de datos
        $sql = "SELECT * FROM usuarios WHERE idUsuario = $this->intIdUsuario AND password = '{$this->strPassword}'";
        $request = $this->select_All($sql);

        if ($request) {
            // La contraseña actual es correcta, entonces procedemos a actualizarla
            $sql = "UPDATE usuarios SET password = ? WHERE idUsuario = ?";
            $arrData = array($this->strPasswordNew, $this->intIdUsuario);
            $request = $this->update($sql, $arrData);
            return $request;
        } else {
            // La contraseña actual no coincide con la almacenada en la base de datos
            return 0;
        }
    }
    //Metodo para exportar
    public function usuariosReporte()
    {
        $sql = "SELECT u.idUsuario,u.nombres,u.apellidos,u.email,u.usuario,u.departamentoid,u.rolid,u.status,d.idDepartamento,d.nombre as nombreDepartamento,r.idRol,r.nombre as nombreRol,
        CONCAT(DAY(u.dateCreate), ' de ', 
        CASE MONTH(u.dateCreate)
            WHEN 1 THEN 'enero'
            WHEN 2 THEN 'febrero'
            WHEN 3 THEN 'marzo'
            WHEN 4 THEN 'abril'
            WHEN 5 THEN 'mayo'
            WHEN 6 THEN 'junio'
            WHEN 7 THEN 'julio'
            WHEN 8 THEN 'agosto'
            WHEN 9 THEN 'septiembre'
            WHEN 10 THEN 'octubre'
            WHEN 11 THEN 'noviembre'
            WHEN 12 THEN 'diciembre'
        END, ' del ', YEAR(u.dateCreate)) AS fechaCreacion,DATE_FORMAT(u.dateCreate, '%h:%i:%s %p') AS horaCreacion FROM usuarios u INNER JOIN departamento d ON u.departamentoid = d.idDepartamento INNER JOIN roles r ON u.rolid = r.idRol WHERE u.status != 0";
        $request = $this->select_All($sql);
        return $request;
    }
}
