<?php

class Quejas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        getPermisos(3);
    }

    public function Quejas()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Opportunity";
        $data['page_main'] = "DQR - Opportunity";
        $data['page_name'] = "quejas";
        $data['page_functions_js'] = "quejas_funcion.js";
        $this->views->getView($this, "quejas", $data);
    }

    //Metodo para extraer los registros a la tabla 
    public function getQuejas()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectRegistros();
            for ($i = 0; $i < count($arrData); $i++) {

                //Creamos variables para los botones
                $btnUpdate = "";
                $btnDelete = "";

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#269D00;"><i class="fas fa-check-circle fa-2x"></i></span>';
                } else {
                    $arrData[$i]['status'] = '<span class="bagde" style="color:#800000;"><i class="fas fa-times-circle fa-2x"></i></span>';
                }

                //Creamos las validacion a los botones segun el permiso
                if ($_SESSION['permisosModulo']['u']) {
                    $btnUpdate =
                        '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateQueja(this,' . $arrData[$i]['idQueja'] . ')" title = "Actualizar Queja"><i class="fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete =
                        '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedQueja(' . $arrData[$i]['idQueja'] . ')" title = "Eliminar Queja"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para insertar quejas ala bd 
    public function setQuejas()
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
                    $request_user = $this->model->insertQueja($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there is already a complaint with that name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion de la queja
    public function getQueja($idQueja)
    {
        if ($_SESSION['permisosModulo']['r']) {
            $intQuejaid = intval($idQueja);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($intQuejaid > 0) {
                $arrData = $this->model->selectQueja($intQuejaid);
                //Si el arreglo esta vacio mostrara un msj de error
                if (empty($arrData)) {
                    $arrReponse = array('status' => false, 'msg' => 'Data no found');
                    //En caso contrario imprimira el arreglo de datos
                } else {
                    $arrReponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para actualizar las quejas 
    public function updateQuejas($idQueja)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $intQuejaid = intval($idQueja);
            //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
            if ($_POST && $intQuejaid > 0) {
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
                    $request_user = $this->model->updateQueja($intQuejaid, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data updated correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there is already a complaint with this name, try another name');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar quejas
    public function deleteQueja($idQueja)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir idQueja en un entero
            $idquejas = intval($idQueja);

            // Validar que $idUsuario sea un número entero positivo
            if ($idquejas <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid role ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de rol es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteQuejas($idquejas);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'The complaint has been eliminated');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible eliminate complaint');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
