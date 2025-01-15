<?php

class Departamentos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        sessionStart();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        getPermisos(4);
    }

    public function Departamentos()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Departments";
        $data['page_main'] = "DQR - Departments";
        $data['page_name'] = "departamentos";
        $data['page_functions_js'] = "departamentos_funciones.js";
        $this->views->getView($this, "departamentos", $data);
    }

    //Metodo para extraer los departamentos de la bd
    public function getSelectDepartamentos()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectDepartamentos();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['idDepartamento'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para extraer los registros de la bd 
    public function getDepartamentos()
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
                        '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateDepa(this,' . $arrData[$i]['idDepartamento'] . ')" title = "Actualizar Departamento"><i class="fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete =
                        '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedDepa(' . $arrData[$i]['idDepartamento'] . ')" title = "Eliminar Departamento"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para agregar departamentos a la bd
    public function setDepartamentos()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos que haya una repuesta de tipo POST
            if ($_POST) {
                //Validamos que cada dato no se encuentre vacio 
                if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty(['listStatus'])) {
                    //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                    $arrReponse = array('status' => false, 'msg' => 'Incorrect Data');
                } else {
                    //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                    $strNombre = ucwords(strClean($_POST['txtNombre']));
                    $strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                    $request_user = $this->model->insertDepartamentos($strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ there is already a department with that name, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del departamento
    public function getDepartamento($idDepartamento)
    {
        if ($_SESSION['permisosModulo']['r']) {
            $intDepartamentoid = intval($idDepartamento);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($intDepartamentoid > 0) {
                $arrData = $this->model->selectDepartamento($intDepartamentoid);
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

    //Metodo para editar la informacion del departamento
    public function updateDepartamentos($idDepartamento)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $intDepartamentoid = intval($idDepartamento);
            //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
            if ($_POST && $intDepartamentoid > 0) {
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
                    $request_user = $this->model->updateDepartamento($intDepartamentoid, $strNombre, $strDescripcion, $intStatus);
                    //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                    if ($request_user > 0) {
                        $arrReponse = array('status' => true, 'msg' => 'Data updated correctly');
                    } else if ($request_user == 0) {
                        $arrReponse = array('status' => false, 'msg' => '!Attention¡ a department with this name already exists, try another one');
                    } else {
                        $arrReponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para eliminar departamentos
    public function deleteDepartamentos($idDepartamento)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir idQueja en un entero
            $idDepartamentos = intval($idDepartamento);

            // Validar que $idUsuario sea un número entero positivo
            if ($idDepartamentos <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid department ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de rol es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteDepartamento($idDepartamentos);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'The department has been eliminated');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible to elminate the department');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
