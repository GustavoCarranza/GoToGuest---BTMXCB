<?php
class Compensations extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        sessionStart();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        //getPermisos(4);
    }

    public function Compensations()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Compensations";
        $data['page_main'] = "Compensations";
        $data['page_name'] = "Compensations";
        $data['page_functions_js'] = "Functions_Compensation.js";
        $this->views->getView($this, "compensations", $data);
    }

    //Metodo para extraer los registros
    public function getCompensations()
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
                        '<button class="btn btn-sm" style="background: #464646; color:#fff;" onclick="btnUpdateDepa(this,' . $arrData[$i]['id_compensation'] . ')" title = "Actualizar Departamento"><i class="fas fa-edit"></i></button>';
                }
                if ($_SESSION['permisosModulo']['d']) {
                    $btnDelete =
                        '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedDepa(' . $arrData[$i]['id_compensation'] . ')" title = "Eliminar Departamento"><i class="fas fa-trash"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'
                    . $btnUpdate . ' ' . $btnDelete . ' </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para insertar registros
    public function setCompensation()
    {
        if ($_SESSION['permisosModulo']['w']) {
            if ($_POST) {
                if (empty($_POST['txtName']) || empty($_POST['txtDescription']) || empty(['listStatus'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Incorrect Data');
                } else {
                    $strName = ucwords(strClean($_POST['txtName']));
                    $strDescription = ucwords(strClean($_POST['txtDescription']));
                    $intStatus = intval(strClean($_POST['listStatus']));
                    $request_compensation = $this->model->insertCompensation($strName, $strDescription, $intStatus);
                    if ($request_compensation > 0) {
                        $arrResponse = array('status' => true, 'msg' => 'Data saved correctly');
                    } else if ($request_compensation == 0) {
                        $arrResponse = array('status' => false, 'msg' => '!Attention¡ there is already a compensation with that name, try another one');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => '!Error¡ something has happened in the data transmission');
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}