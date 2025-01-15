<?php

class PermisosModel extends Mysql
{
    //propiedades
    public $intIdpermisos;
    public $intRolid;
    public $intModuloid;
    public $r;
    public $w;
    public $u;
    public $d;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los modulos de la bd 
    public function selectModulos()
    {
        $sql = "SELECT * FROM modulos WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer los permisos del rol 
    public function selectPermisosRol(int $idrol)
    {
        $this->intRolid = $idrol;
        $sql = "SELECT * FROM permisos WHERE rolid = $this->intRolid";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para quitar los permisos a los roles
    public function deletePermisos(int $idrol)
    {
         //Asignamos valor del parametro a la propiedad
         $this->intRolid = $idrol;
         //Creamos una variable para almacenar la consulta a la base de datos que permitira quitar los permisos del rol 
         $sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
         $request = $this->delete($sql);
         return $request;
    }

    //Metodo para asignar los permisos al rol
    public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d)
    {
        //Asignamos los valores de los parametros a las propiedades
        $this->intRolid = $idrol;
        $this->intModuloid = $idmodulo;
        $this->r = $r;
        $this->w = $w;
        $this->u = $u;
        $this->d = $d;
        //Creamos la variable para almacenar la consulta para insertar los permisos en la tabla 
        $query_insert = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";
        //Creamos el arreglo de datos pasando las propiedades igualadas con los parametros recibidos
        $arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
        $request_insert = $this->insert($query_insert,$arrData);
        return $request_insert;
    }

    //Metodo para extraer los modulos y los permisos del modulo segun el id del rol
    public function permisosModulo(int $idrol)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intRolid = $idrol;
        //Creamos la variable que tendra almacenada la consulta a la BD que lo que hace es capturar el id del rol y verificar que modulos estan activos junto con sus permisos 
        $sql = "SELECT p.idpermiso,p.rolid,p.moduloid,p.r,p.w,p.u,p.d,m.nombre as modulo FROM permisos p INNER JOIN modulos m ON p.moduloid = m.idmodulo WHERE p.rolid = $this->intRolid";
        $request = $this->select_All($sql);
        $arrPermisos = array();
        for($i = 0; $i < count($request); $i++)
        {
            $arrPermisos[$request[$i]['moduloid']] = $request[$i];
        }
        return $arrPermisos;
    }
}
