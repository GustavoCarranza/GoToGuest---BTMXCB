<?php
class Lugar extends Controllers
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
        getPermisos(5);
    }

    public function Lugar()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Place of oppportunity";
        $data['page_main'] = "Place of opportunity";
        $data['page_name'] = "lugar";
        $data['page_functions_js'] = "Functions_Area.js";
        $this->views->getView($this, "lugar", $data);
    }

    //Metodo para extraer los registros de la base de datos
    public function getLugares()
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
                        '<button class="btn btn-sm" style="background: #464646; color:#fff;" onclick="btnUpdateLugar(this,' . $arrData[$i]['idLugar'] . ')" title = "Actualizar Lugar"><i class="fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete =
                        '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedLugar(' . $arrData[$i]['idLugar'] . ')" title = "Eliminar Lugar"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para agregar lugares de queja 
    public function setLugar()
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
                    $request_user = $this->model->insertLugar($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there is already a place of complaint with that name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del lugar de queja
    public function getLugar($idLugar)
    {
        if ($_SESSION['permisosModulo']['r']) {
            $intLugarid = intval($idLugar);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($intLugarid > 0) {
                $arrData = $this->model->selectLugar($intLugarid);
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

    //Metodo para editar la informacion del lugar de queja 
    public function updateLugares($idLugar)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $intLugarid = intval($idLugar);
            //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
            if ($_POST && $intLugarid > 0) {
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
                    $request_user = $this->model->updateLugar($intLugarid, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data updated correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ something is already a palce of complaint with this name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar lugares de queja
    public function deleteLugar($idLugar)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir idQueja en un entero
            $idLugares = intval($idLugar);

            // Validar que $idUsuario sea un número entero positivo
            if ($idLugares <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid complaint location ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de rol es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteLugares($idLugares);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'The place of complaint has been removed');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible to eliminate the place of complaint');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
