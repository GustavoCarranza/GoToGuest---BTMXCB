<?php
class Registros extends Controllers
{
    public function __construct()
    {
        sessionStart();
        parent::__construct();
        //Validar la variable de sesion una vez logueados que esta creada en el controlador login
        if (empty($_SESSION['login'])) {
            header('location: ' . Base_URL() . '/Login');
        }
        //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
        getPermisos(6);
    }

    /** --- REGISTROS LOW ---  */

    //Metodo de vista para Registros de nivel bajo
    public function Low()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }

        $data['page_title'] = "DQR - Low";
        $data['page_main'] = "DQR - Low";
        $data['page_name'] = "Low";
        $data['page_functions_Registros'] = "Functions_Low.js";
        $this->views->getView($this, "Low/low", $data);
    }

    //Metodo para obtener los registros Low
    public function getRegistrosLow()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectLow();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS MEDIUM ---  */

    //Metodo de vista para Registros de nivel Medio
    public function Medium()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Medium";
        $data['page_main'] = "DQR - Medium";
        $data['page_name'] = "Medium";
        $data['page_functions_Registros'] = "Functions_Medium.js";
        $this->views->getView($this, "Medium/medium", $data);
    }

    //Metodo para obtener los registos Medium
    public function getRegistrosMedium()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectMedium();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';    

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS MEDIUM ---  */

    //Metodo de vista para Registros de nivel Alto
    public function High()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - High";
        $data['page_main'] = "DQR - High";
        $data['page_name'] = "High";
        $data['page_functions_Registros'] = "Functions_High.js";
        $this->views->getView($this, "High/high", $data);
    }

    //Metodo para obtener los registos Medium
    public function getRegistrosHigh()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectHigh();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS IN STAY ---  */

    //Metodo de vista para Registros en Espera
    public function InStay()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - In Stay";
        $data['page_main'] = "DQR - In Stay";
        $data['page_name'] = "In Stay";
        $data['page_functions_Registros'] = "Functions_InStay.js";
        $this->views->getView($this, "In Stay/InStay", $data);
    }

    //Metodo para obtener los registos Medium
    public function getRegistrosInStay()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectInStay();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';
                
                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : ''; 

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS Informative ---  */

    //Metodo de vista para Registros informativos
    public function Informative()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Informative";
        $data['page_main'] = "DQR - Informative";
        $data['page_name'] = "Informative";
        $data['page_functions_Registros'] = "Functions_Informative.js";
        $this->views->getView($this, "Informative/informative", $data);
    }

    //Metodo para obtener los registos Medium
    public function getRegistrosInformative()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectInformative();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : ''; 

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS Wow moment ---  */

    //Metodo de vista para Registros Wow Moment
    public function WowMoment()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Wow Moment";
        $data['page_main'] = "DQR - Wow Moment";
        $data['page_name'] = "Wow Moment";
        $data['page_functions_Registros'] = "Functions_WowMoment.js";
        $this->views->getView($this, "Wow Moment/WowMoment", $data);
    }

    //Metodo para obtener los registos Medium
    public function getRegistrosWowMoment()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectWowMoment();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';
                
                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : ''; 

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS IN HOUSE --- */

    //Metodo de vista para Registro In house
    public function InHouse()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - In House";
        $data['page_main'] = "DQR - In House";
        $data['page_name'] = "In house";
        $data['page_functions_Registros'] = "Funciones_InHouse.js";
        $this->views->getView($this, "InHouse/InHouse", $data);
    }

    //Metodo de vista para registros In house
    public function getRegistrosInhouse()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectInhouse();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS SPECIAL CARE GUEST */

    public function SpecialGuest()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Special Care Guest";
        $data['page_main'] = "DQR - Special Care Guest";
        $data['page_name'] = "Special Care Guest";
        $data['page_functions_Registros'] = "Funciones_SpecialGuest.js";
        $this->views->getView($this, "SpecialGuest/SpecialGuest", $data);
    }

    //Metodo de vista para registros Special Care Guest
    public function getRegistrosSpecialGuest()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectSpecialGuest();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** ---REGISTROS DUE OUT --- */

    public function DueOut()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Due Out";
        $data['page_main'] = "DQR - Due Out";
        $data['page_name'] = "Due Out";
        $data['page_functions_Registros'] = "Funciones_DueOut.js";
        $this->views->getView($this, "DueOut/DueOut", $data);
    }

    //Metodo de vista para registros Due Out
    public function getRegistrosDueOut()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectDueOut();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    /** --- REGISTROS POSSIBLE AUDITOR ---  */
    public function PossibleAuditor()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "DQR - Possible Auditor";
        $data['page_main'] = "DQR - Possible Auditor";
        $data['page_name'] = "Possible Auditor";
        $data['page_functions_Registros'] = "Funciones_PossibleAuditor.js";
        $this->views->getView($this, "PossibleAuditor/PossibleAuditor", $data);
    }

    //Metodo de vista de registros Possible Auditor
    public function getRegistrosPossibleAuditor()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los datos de la base
            $arrData = $this->model->selectPossibleAuditor();

            //Convertir el estado del gir antes del blucle
            foreach ($arrData as &$row) {
                switch ($row['nivel']) {
                    case "Low":
                        $row['nivel'] = '<span class="badge" style="background:#269D00; color:#FFF; font-weight: bolder; padding: 5px; border-radius: 10px;"> Low </span>';
                        $row['row_class'] = 'low-priority';
                        break;
                    case "Medium":
                        $row['nivel'] = '<span class="badge" style="background:#B9B700; color:#fff; font-weight: bold; padding: 5px; border-radius: 10px;"> Medium </span>';
                        $row['row_class'] = 'medium-priority';
                        break;
                    case "High":
                        $row['nivel'] = '<span class="badge" style="background:#800000; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> High </span>';
                        $row['row_class'] = 'high-priority';
                        break;
                    case "In stay":
                        $row['nivel'] = '<span class="badge" style="background:#ea6b00; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> In stay </span>';
                        $row['row_class'] = 'inStay-priority';
                        break;
                    case "Informative":
                        $row['nivel'] = '<span class="badge" style="background:#00accb; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Informative </span>';
                        $row['row_class'] = 'informative-priority';
                        break;
                    case "Wow moment":
                        $row['nivel'] = '<span class="badge" style="background:#3700c8; color:#fff; font-weight: bolder; padding: 5px; border-radius: 10px;"> Wow moment </span>';
                        $row['row_class'] = 'wowMoment-priority';
                        break;
                    default:
                        // Manejar cualquier otro estado si es necesario
                        break;
                }
            }
            // Iterar sobre los datos
            foreach ($arrData as &$row) {
                $row['imagen'] = '<img style="width:120px; height: 100px" src="' . media() . "/Imagenes_almacenadas/" . $row['imagen'] . '">';

                //Creamos las validaciones a los botones segun el permiso
                $btnView =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #454545 ; color:#fff;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm" style="background: #d59b03; color:#fff;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
