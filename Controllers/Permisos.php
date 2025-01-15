<?php

class Permisos extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los modulos desde la bd 
    public function getPermisosRol(int $idRol)
    {
        $rolid = intval($idRol);
        if ($rolid > 0) {
            //Creamos una variable para acceder a la invocacion del metodo en el modelo el cual nos va a servir para extraer los modulos de la tabla 
            $arrModulos = $this->model->selectModulos();
            //Crear una variable para acceder a la invocacion del metodo en el modelo y no va a servir para extraer los permisos que tenga el rol
            $arrPermisosRol = $this->model->selectPermisosRol($rolid);
            //Creamos un arreglo en donde le almacenamos las operaciones de los permisos que tenemos 
            $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
            //Creamos otro arreglo en donde le almacenamos el id del rol que estamos recibiendo a principio como parametro 
            $arrPermisoRol = array('idRol' => $rolid);
            //Validamos si el $arrPermisosRol que es la variable que tiene almenada los permisos de cada rol 
            if (empty($arrPermisosRol)) {
                //Creamos un ciclo for aqui lo que estamos haciendo es recorrer todo el $arrModulos que es donde tenemos el metodo al modelo para extraer los modulos
                for ($i = 0; $i < count($arrModulos); $i++) {
                    //Y lo que hacemos es crear otro arreglo para que cada modulo tenga los permisos correspondientes r,w,u,d 
                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            } else {
                //Creamos un ciclo for aqui lo que estamos haciendo es recorrer todo el $arrModulos que es donde tenemos el metodo al modelo para extraer los modulos
                for ($i = 0; $i < count($arrModulos); $i++) {
                    $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                    if (isset($arrPermisosRol[$i])) {
                        $arrPermisos = array(
                            'r' => $arrPermisosRol[$i]['r'],
                            'w' => $arrPermisosRol[$i]['w'],
                            'u' => $arrPermisosRol[$i]['u'],
                            'd' => $arrPermisosRol[$i]['d'],
                        );
                    }
                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            }
            $arrPermisoRol['modulos'] = $arrModulos;
            $html = getModal("modalPermisos", $arrPermisoRol);
            // dep($arrPermisoRol);
        }
        die();
    }

    //Metodo para guardar los permisos de los modulos 
    public function setPermisos()
    {
         //Hacemos una validacion para comprobar si hay una solicitud de tipo POST 
         if ($_POST) {
            //Vamos a crear 2 variables en una almacenamos el id del rol que estamos otorgando los permisos y en la otra variable el modulo correspondinte
            $intIdrol = intval($_POST['idRol']);
            $modulos = $_POST['modulos'];
            //Creamos una variable para acceder a la invocacion del metodo en el modelo pasandole el id del rol 
            $this->model->deletePermisos($intIdrol);
            //Creamos un foreach esto sirve de esta manera, de la variable creada modulos que estas capturando el modulo correspondiente vamos a recorrer todo ese array, entonces al crear una nueva variable $idModulo y almacenamos el modulo en la posicion correspondiente 
            foreach ($modulos as $modulo) {
                $idModulo = $modulo['idmodulo'];
                //Creamos variables de cada operacion y validamos si el modulo en su posicion de la operacion correspondiente esta vacia se pondra un 0 de caso contrario se cambiara a uno algo similar a un status
                $r = empty($modulo['r']) ? 0 : 1;
                $w = empty($modulo['w']) ? 0 : 1;
                $u = empty($modulo['u']) ? 0 : 1;
                $d = empty($modulo['d']) ? 0 : 1;
                //Aqui creamos la variable para acceder al metodo del modelo para insertar los permisos, es decir, de 0 lo cambiamos a 1 y le pasamos el id del rol el id del modulo y las operaciones corrspondientes
                $requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $r, $w, $u, $d);
            }
            //Validamos que la variable sea mayor a o y mostramos el msj de success
            if ($requestPermiso > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible asignar los permisos');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>