<?php

class Roles extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/Login');
        }
        getPermisos(2);
    }

    public function Roles()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Roles";
        $data['page_main'] = "Roles";
        $data['page_name'] = "roles";
        $data['page_functions_js'] = "funciones_roles.js";
        $this->views->getView($this, "roles", $data);
    }

    //Metodo para extraer los registros de la tabla roles
    public function getRoles()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectRegistros();
            for ($i = 0; $i < count($arrData); $i++) {

                //Creamos variables para los botones
                $btnView = "";
                $btnUpdate = "";
                $btnDelete = "";

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>';
                } else {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
                }

                //Creamos las validacion a los botones segun el permiso
                if ($_SESSION['permisosModulo']['u']) {

                    $btnView =
                        ' <button class="btn btn-sm" style="background: #464646; color:#fff;" onclick="btnPermisos(' . $arrData[$i]['idRol'] . ')" title = "Actualizar Rol"><i class="fas fa-key"></i></button>';

                    $btnUpdate =
                        '<button class="btn btn-sm" style="background: #464646; color:#fff;" onclick="btnUpdateRol(' . $arrData[$i]['idRol'] . ')" title = "Actualizar Rol"><i class="fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete =
                        '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedRol(' . $arrData[$i]['idRol'] . ')" title = "Eliminar Rol"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //metodo para extraer los roles de la bd 
    public function getSelectRoles()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectRoles();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['idRol'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para agregar roles
    public function setRol()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos que haya una repuesta de tipo POST
            if ($_POST) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty(['listStatus'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect data');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombre']));
                    $strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->insertRol($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there is already a role with that name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del rol
    public function getRol($idRol)
    {
        if ($_SESSION['permisosModulo']['r']) {
            $intRolid = intval($idRol);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($intRolid > 0) {
                $arrData = $this->model->selectRol($intRolid);
                //Si el arreglo esta vacio mostrara un msj de error
                if (empty($arrData)) {
                    $arrReponse = array('status' => false, 'msg' => 'Data not found');
                    //En caso contrario imprimira el arreglo de datos
                } else {
                    $arrReponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para actualizar roles
    public function updateRoles($idRol)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $intRolid = intval($idRol);
            //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
            if ($_POST && $intRolid > 0) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombreUpdate']) || empty($_POST['txtDescripcionUpdate']) || empty($_POST['listStatusUpdate'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect data');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombreUpdate']));
                    $strDescripcion = strClean($_POST['txtDescripcionUpdate']);
                    $intStatus = intval(strClean($_POST['listStatusUpdate']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->updateRol($intRolid, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there already exists a role with this name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar roles
    public function deleteRol($idRol)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir idrol en un entero
            $idroles = intval($idRol);

            // Validar que $idUsuario sea un número entero positivo
            if ($idroles <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid role ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de rol es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteRoles($idroles);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'The rol has been eliminated');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible to delete the Role');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
