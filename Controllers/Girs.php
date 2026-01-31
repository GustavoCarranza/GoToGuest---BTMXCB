<?php
class Girs extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        getPermisos(6);
    }

    public function Girs()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Open GIR'S";
        $data['page_main'] = "Open GIR'S";
        $data['page_name'] = "Open GIR'S";
        $data['page_functions_js'] = "Functions_Girs.js";
        $this->views->getView($this, "girs", $data);
    }

    //Metodo para extraer las compensaciones
    public function getSelectCompensations()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectCompensations();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_compensation'] . '">' . $arrData[$i]['name'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }
    //Metodo para extraer los departamentos
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

    //Metodo para extraer los lugares de quejas
    public function getSelectLugares()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectLugares();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['idLugar'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para extraer las opciones en el select
    public function getSelectQuejas()
    {
        //creamos una variable como una cadena vacia, la utilizaremo para las opciones HMTL dinamicamente
        $htmlOptions = "";
        //Creamos una variable donde accedemos a la invocacion del modelo a crear que nos servira de consulta a la base de datos
        $arrData = $this->model->selectQuejas();
        //Realizmaos una validacion para comprobar si hay elementos en el arreglo 
        if (count($arrData) > 0) {
            //con el ciclo for y con la validacion if validamos si el estado "status" de cada rol es igual a 1, esto porque pueden estar inactivos dentro de la base 
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    //Aqui con la variables que creamos al principio que fue una cadena vacia cambiamos el valor con etiqueta HTML en los opcion y concatenamos el arreglo y la variable inicializada en el for para que recorra cada uno de los elementos junto con el id y el nombre del rol
                    $htmlOptions .= '<option value="' . $arrData[$i]['idQueja'] . '" data-clasificacion="' . $arrData[$i]['id_clasificacion'] . '" data-nombreclas="' . htmlspecialchars($arrData[$i]['nombreClasificacion']) . '">' . htmlspecialchars($arrData[$i]['nombre']) . '</option>';



                }
            }
        }
        //imprimimos la variable para invocarla
        echo $htmlOptions;
        die();
    }

    //Metodo para extraer departamentos para el filter
    public function getDepartamentosFilter()
    {
        $departamentos = $this->model->selectDepartamentos();
        if ($departamentos) {
            echo json_encode([
                'status' => true,
                'data' => $departamentos
            ]);
        } else {
            echo json_encode([]);
        }
    }

    //Metodo para extraer las quejas para el filter
    public function getQuejasFilter()
    {
        $quejas = $this->model->selectQuejas();
        if ($quejas) {
            echo json_encode([
                'status' => true,
                'data' => $quejas
            ]);
        } else {
            echo json_encode([]);
        }
    }

    //Metodo para extraer las clasificaciones para el filter
    public function getClasificacionesFilter()
    {
        $clasificaciones = $this->model->selectClasificaciones();
        if ($clasificaciones) {
            echo json_encode([
                'status' => true,
                'data' => $clasificaciones
            ]);
        } else {
            echo json_encode([]);
        }
    }

    //Metodo para extraer los registros a la tabla
    public function getGirs()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los filtros enviados desde el frontend
            $tipoHuesped = isset($_GET['tipoHuesped']) ? $_GET['tipoHuesped'] : '';
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
            $villa = isset($_GET['villa']) ? $_GET['villa'] : '';
            $prioridad = isset($_GET['prioridad']) ? $_GET['prioridad'] : '';
            $departamento = isset($_GET['departamentos']) ? $_GET['departamentos'] : '';
            $oportunidad = isset($_GET['oportunidad']) ? $_GET['oportunidad'] : '';
            $creacion_start = isset($_GET['creacion_start']) ? $_GET['creacion_start'] : '';
            $creacion_end = isset($_GET['creacion_end']) ? $_GET['creacion_end'] : '';
            $entrada = isset($_GET['entrada']) ? $_GET['entrada'] : '';
            $salida = isset($_GET['salida']) ? $_GET['salida'] : '';
            // Recuperar los datos de la base de datos
            $arrData = $this->model->selectRegistros($tipoHuesped, $categoria, $villa, $prioridad, $departamento, $oportunidad, $creacion_start, $creacion_end, $entrada, $salida);
            // Convertir el estado del Gir antes del bucle
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
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF ; color:#454545;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm fa-bold" style="background: #FFFFFF; color:#454545;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color:#454545;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die(); // Terminar el script después de enviar la respuesta
    }

    //Metodo para insertar girs a la bd 
    public function setGirs()
    {
        if ($_SESSION['permisosModulo']['w']) {
            //Validamos si existe una peticion de tipo post 
            if ($_POST) {
                //Creamos variables donde almacenamos en cada una el name del input
                $idusuario = $_SESSION['UserData']['usuario'];
                $strClasificacion = strClean($_POST['listClasificacion']);
                $intCompensation = strClean($_POST['listCompensation']);
                $strFecha = strClean($_POST['txtFecha']);
                $strApellidos = ucwords(strClean($_POST['txtApellidos']));
                $intVilla = strClean($_POST['listVilla']);
                $strEntrada = strClean($_POST['txtEntrada']);
                $strSalida = strClean($_POST['txtSalida']);
                $intEstado = strClean($_POST['listEstado']);
                $intNivel = strClean($_POST['listNivel']);
                $intCategoria = strClean($_POST['listCategoria']);
                $intTipo = strClean($_POST['listTipo']);
                $intQueja = intval(strClean($_POST['listQueja']));
                $intLugar = intval(strClean($_POST['listLugar']));
                $intDepartamento = intval(strClean($_POST['listDepartamento']));
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strAccion = strClean($_POST['txtAccion']);
                $strSeguimiento = strClean($_POST['txtSeguimiento']);

                $strImagen = $_FILES['imagen'];
                $name = $strImagen['name'];
                $tmpname = $strImagen['tmp_name'];
                $destino = "Assets/Imagenes_almacenadas/" . $name;

                //Creamos variable para almacenar la invocacion al metodo en el modelo 
                $request_rest = $this->model->insertGirs($idusuario, $strClasificacion, $intCompensation, $strFecha, $strApellidos, $intVilla, $strEntrada, $strSalida, $intEstado, $intNivel, $intCategoria, $intTipo, $intQueja, $intLugar, $intDepartamento, $strDescripcion, $strAccion, $strSeguimiento, $name);
                //Validamos la variable 
                if ($request_rest > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Gir created correctly');
                    move_uploaded_file($tmpname, $destino);
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'It is not possible to create the gir');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    //Metodo para extraer la informacion del gir 
    public function getGir($idGir)
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Creamos una variable en donde le alojamos el parametro que requerimos en este caso el id del usuario con la funcion intval convertimos ese valor en entero
            $id = intval($idGir);
            //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
            if ($id > 0) {
                $arrData = $this->model->selectGir($id);
                //Si el arreglo esta vacio mostrara un msj de error
                if (empty($arrData)) {
                    $arrReponse = array('status' => false, 'msg' => 'Data not found');
                    //En caso contrario imprimira el arreglo de datos
                } else {
                    $arrReponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    //Metodo para actualizar informacion de gir (Queda pendiente lograr que al actualizar imagen nueva se garde en la carpeta)
    public function updateGirs($idGir)
    {
        if ($_SESSION['permisosModulo']['u']) {
            $idgir = intval($idGir);

            // Validamos si existe una petición de tipo post 
            if ($_POST && $idgir > 0) {
                // Captura de datos
                $idusuario = $_SESSION['UserData']['usuario'];
                $strClasificacion = strClean($_POST['listClasificacionUpdate']);
                $strCompensacion = strClean($_POST['listCompensationUpdate']);
                $strFecha = strClean($_POST['txtFechaUpdate']);
                $strApellidos = ucwords(strClean($_POST['txtApellidosUpdate']));
                $intVilla = strClean($_POST['listVillaUpdate']);
                $strEntrada = strClean($_POST['txtEntradaUpdate']);
                $strSalida = strClean($_POST['txtSalidaUpdate']);
                $intEstado = strClean($_POST['listEstadoUpdate']);
                $intNivel = strClean($_POST['listNivelUpdate']);
                $intCategoria = strClean($_POST['listCategoriaUpdate']);
                $intTipo = strClean($_POST['listTipoUpdate']);
                $intQueja = intval(strClean($_POST['listQuejaUpdate']));
                $intLugar = intval(strClean($_POST['listLugarUpdate']));
                $intDepartamento = intval(strClean($_POST['listDepartamentoUpdate']));
                $strDescripcion = strClean($_POST['txtDescripcionUpdate']);
                $strAccion = strClean($_POST['txtAccionUpdate']);
                $strSeguimiento = strClean($_POST['txtSeguimientoUpdate']);

                // Imagen por defecto
                $nombreImagen = $_POST['foto_actual'] ?? '';

                if ($nombreImagen === '' || $nombreImagen === null) {
                    $nombreImagen = "No hay imagen que mostrar";
                }

                if (
                    isset($_FILES['imagen']) &&
                    $_FILES['imagen']['error'] === 0 &&
                    !empty($_FILES['imagen']['name'])
                ) {
                    $nombreOriginal = $_FILES['imagen']['name'];
                    $tmpname = $_FILES['imagen']['tmp_name'];

                    // Nombre único
                    $nombreImagen = time() . '_' . basename($nombreOriginal);
                    $destino = "Assets/Imagenes_almacenadas/" . $nombreImagen;

                    if (!move_uploaded_file($tmpname, $destino)) {
                        echo json_encode([
                            'status' => false,
                            'msg' => 'Error al subir la imagen'
                        ]);
                        die();
                    }
                }
                // Llamar al modelo para actualizar
                $request_rest = $this->model->UpdateGirs($idgir, $idusuario, $strClasificacion, $strCompensacion, $strFecha, $strApellidos, $intVilla, $strEntrada, $strSalida, $intEstado, $intNivel, $intCategoria, $intTipo, $intQueja, $intLugar, $intDepartamento, $strDescripcion, $strAccion, $strSeguimiento, $nombreImagen);

                // Validar la respuesta del modelo
                if ($request_rest > 0) {
                    echo json_encode(['status' => true, 'msg' => 'Gir actualizado correctamente']);
                } else {
                    echo json_encode(['status' => false, 'msg' => 'No se pudo actualizar el gir']);
                }
            }
        }
        die();
    }

    //Metodopara eliminar girs 
    public function deleteGir($idGir)
    {
        if ($_SESSION['permisosModulo']['d']) {
            // Convertir $idUsuario en un entero
            $idGirs = intval($idGir);

            // Validar que $idUsuario sea un número entero positivo
            if ($idGirs <= 0) {
                $arrReponse = array('status' => false, 'msg' => 'Invalid gir ID');
                echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Si llegamos aquí, el ID de usuario es válido, proceder con la eliminación
            $request_Delete = $this->model->deleteGirs($idGirs);
            if ($request_Delete == 'ok') {
                $arrReponse = array('status' => true, 'msg' => 'Gir has been removed');
            } else {
                $arrReponse = array('status' => false, 'msg' => 'It is not possible to remove the gir');
            }

            // Devolver una respuesta JSON al cliente
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para exportar el reporte diario 
    public function getReporte()
    {
        // Incluir el archivo de funciones auxiliares que contiene la función Celdas()
        Celdas();

        // Crear una nueva instancia de FPDF con orientación horizontal
        $pdf = new PDF('L', 'mm', 'Letter'); // 'L' indica orientación horizontal

        // Configurar fuente y tamaño de texto
        $pdf->SetFont('Arial', 'B', 5); // Tamaño de fuente 5 para el encabezado
        $pdf->AliasNbPages();

        // Definimos los encabezados de la tabla
        $encabezados = ['Date', 'Hour', 'Surnames', 'Villa', 'CheckOut', 'Status', 'Level', 'Opportunity', 'Location', 'Área', 'Description', 'Action', 'Follow-up', 'Compensation'];
        $encabezados_decodificados = array_map('utf8_decode', $encabezados);

        // Iteramos sobre los tipos de huéspedes
        $TipoGir = ["Due Out", "In house", "Special Care Guest", "Possible auditor"];

        // Agregamos una página al PDF
        $pdf->AddPage();
        $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', 10, 1, 25);
        $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', $pdf->GetPageWidth() - 40, 1, 25);

        foreach ($TipoGir as $Tipo) {
            // Invocamos al modelo para obtener la lista de registros del tipo actual
            $resultado = $this->model->girReporte($Tipo);

            // Configurar la fuente para cada tipo de categoría
            $pdf->SetFont('Arial', 'B', 5); // Tamaño de fuente para el encabezado

            // Verificamos si se recibió respuesta por parte del modelo
            if ($resultado) {
                // Configuramos el encabezado de la tabla en el PDF
                $pdf->CellHeader(0, 18, $Tipo, 0, 1, 'C'); // Mostramos el tipo de huésped como encabezado

                // Configuramos el ancho de las columnas para el formato horizontal
                $pdf->SetWidths([11, 10, 11, 6, 11, 9, 10, 15, 13, 12, 47, 47, 47, 14]);

                // Agregamos los encabezados al PDF con la función Row
                $pdf->Row($encabezados_decodificados);

                // Cambiar fuente para los registros
                $pdf->SetFont('Arial', '', 5); // Tamaño de fuente para los registros

                // Iteramos sobre los registros y los mostramos en el PDF
                foreach ($resultado as $row) {
                    $dat = [
                        utf8_decode($row['fecha']),
                        utf8_decode($row['horaGir']),
                        utf8_decode($row['apellidos']),
                        utf8_decode($row['villa']),
                        utf8_decode($row['salida']),
                        utf8_decode($row['estadoGir']),
                        utf8_decode($row['nivel']),
                        utf8_decode($row['nombreQueja']),
                        utf8_decode($row['nombreLugar']),
                        utf8_decode($row['nombreDepartamento']),
                        utf8_decode($row['descripcion']),
                        utf8_decode($row['accionTomada']),
                        utf8_decode($row['seguimiento']),
                        utf8_decode($row['compensation']),
                    ];
                    $pdf->RowCeldas($dat);
                }

                // Añadir un espacio adicional después de la sección con registros
                $pdf->Ln(5); // Espacio después de la sección con registros
            } else {
                // Cambiar la fuente para el mensaje de no registros
                $pdf->SetFont('Arial', '', 15); // Tamaño de fuente 5 para el mensaje
                // Agregamos un mensaje si no hay registros
                $pdf->Cell(0, 10, "There are no records for $Tipo", 0, 1, 'C'); // 'C' para centrado

                // Añadir un espaciado adecuado después del mensaje
                $pdf->Ln(5); // Espacio después del mensaje
            }
        }

        // Generamos la salida del PDF
        $pdf->Output();
    }

    //Metodo para exportar el reporte por rango de fecha
    public function getReporteFiltro()
    {
        // Incluir el archivo de funciones auxiliares que contiene la función Celdas()
        Celdas();

        if ($_POST) {
            if (empty($_POST['txtFechaInicial']) || empty($_POST['txtFechaFinal'])) {
                echo "Error: Data not found";
            } else {
                // Obtener las fechas del formulario es decir los names
                $inicio = strClean($_POST['txtFechaInicial']);
                $final = strClean($_POST['txtFechaFinal']);
                // Crear una nueva instancia de FPDF con orientación horizontal
                $pdf = new PDF('L', 'mm', 'Letter'); // 'L' indica orientación horizontal

                // Configurar fuente y tamaño de texto
                $pdf->SetFont('Arial', 'B', 5);
                $pdf->AliasNbPages();
                // Agregar una página al PDF
                $TipoGir = ["Due Out", "In house", "Special Care Guest", "Possible auditor"];

                foreach ($TipoGir as $Tipo) {
                    // Invocamos al modelo para obtener la lista de usuarios
                    $resultado = $this->model->girReporteFiltro($Tipo, $inicio, $final);

                    // Verificamos si se recibió respuesta por parte del modelo
                    if ($resultado) {
                        // Agregamos una página al PDF
                        $pdf->AddPage();

                        $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', 10, 1, 25);
                        $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', $pdf->GetPageWidth() - 40, 1, 25);
                        // Configuramos el encabezado de la tabla en el PDF
                        $pdf->CellHeader(0, 20, "$Tipo", 0, 1, 'C');

                        // Configuramos el ancho de las columnas para el formato horizontal
                        $pdf->SetWidths([11, 10, 11, 6, 11, 9, 10, 15, 13, 12, 47, 47, 47, 14]);

                        // Definimos los encabezados de la tabla
                        $encabezados = ['Date', 'Time', 'Surnames', 'Villa', 'CheckOut', 'Status', 'Level', 'Opportunity', 'Location', 'Área', 'Description', 'Action', 'Follow-up', 'Compensation'];
                        $encabezados_decodificados = array_map('utf8_decode', $encabezados);

                        // Agregamos los encabezados al PDF con la función Row
                        $pdf->Row($encabezados_decodificados);
                        // Iteramos sobre los resultados y agregamos filas al PDF
                        foreach ($resultado as $row) {
                            $dat = [
                                utf8_decode($row['fecha']),
                                utf8_decode($row['horaGir']),
                                utf8_decode($row['apellidos']),
                                utf8_decode($row['villa']),
                                utf8_decode($row['salida']),
                                utf8_decode($row['estadoGir']),
                                utf8_decode($row['nivel']),
                                utf8_decode($row['nombreQueja']),
                                utf8_decode($row['nombreLugar']),
                                utf8_decode($row['nombreDepartamento']),
                                utf8_decode($row['descripcion']),
                                utf8_decode($row['accionTomada']),
                                utf8_decode($row['seguimiento']),
                                utf8_decode($row['compensation']),
                            ];
                            $pdf->RowCeldas($dat);
                        }
                    } else {
                        // Imprimimos un mensaje si no hay usuarios registrados
                        $pdf->AddPage();
                        $pdf->CellHeader(0, 20, "There are no records for $Tipo", 0, 1, 'C');
                    }
                }
                // Generamos la salida del PDF
                $pdf->Output();
            }
        }
    }

    //Metodo para expotar el reporte por salida 
    public function getReporteAlergias()
    {
        // Incluir el archivo de funciones auxiliares que contiene la función Celdas()
        Celdas();

        // Crear una nueva instancia de FPDF con orientación horizontal
        $pdf = new PDF('L', 'mm', 'Letter'); // 'L' indica orientación horizontal

        // Configurar fuente y tamaño de texto
        $pdf->SetFont('Arial', 'B', 5);
        $pdf->AliasNbPages();
        // Agregar una página al PDF

        $TipoGir = ["In house", "Special Care Guest"];

        foreach ($TipoGir as $Tipo) {
            // Invocamos al modelo para obtener la lista de usuarios
            $resultado = $this->model->girReporteAlergias($Tipo);

            // Verificamos si se recibió respuesta por parte del modelo
            if ($resultado) {
                // Agregamos una página al PDF
                $pdf->AddPage();

                $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', 10, 1, 25);
                $pdf->Image(media() . '/images/Logo_BTMXCB.jpeg', $pdf->GetPageWidth() - 40, 1, 25);
                // Configuramos el encabezado de la tabla en el PDF
                $pdf->CellHeader(0, 18, "$Tipo", 0, 1, 'C');

                // Configuramos el ancho de las columnas para el formato horizontal
                $pdf->SetWidths([11, 10, 11, 6, 11, 9, 10, 15, 13, 12, 47, 47, 47, 14]);

                // Definimos los encabezados de la tabla
                $encabezados = ['Date', 'Hour', 'Surnames', 'Villa', 'CheckOut', 'Status', 'Level', 'Opportunity', 'Location', 'Área', 'Description', 'Action', 'Follow-up', 'Compensation'];
                $encabezados_decodificados = array_map('utf8_decode', $encabezados);

                // Agregamos los encabezados al PDF con la función Row
                $pdf->Row($encabezados_decodificados);
                // Iteramos sobre los resultados y agregamos filas al PDF
                foreach ($resultado as $row) {
                    $dat = [
                        utf8_decode($row['fecha']),
                        utf8_decode($row['horaGir']),
                        utf8_decode($row['apellidos']),
                        utf8_decode($row['villa']),
                        utf8_decode($row['salida']),
                        utf8_decode($row['estadoGir']),
                        utf8_decode($row['nivel']),
                        utf8_decode($row['nombreQueja']),
                        utf8_decode($row['nombreLugar']),
                        utf8_decode($row['nombreDepartamento']),
                        utf8_decode($row['descripcion']),
                        utf8_decode($row['accionTomada']),
                        utf8_decode($row['seguimiento']),
                        utf8_decode($row['compensation']),
                    ];
                    $pdf->RowCeldas($dat);
                }
            } else {
                // Imprimimos un mensaje si no hay usuarios registrados
                $pdf->AddPage();
                $pdf->CellHeader(0, 20, "There are no records for $Tipo", 0, 1, 'C');
            }
        }
        // Generamos la salida del PDF
        $pdf->Output();
    }

    //Metodo para historial
    public function getHistorial($idGir)
    {
        $id = intval($idGir);

        if ($id) {
            $arrData = $this->model->selectHistorial($id);

            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'No results found');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //S E P A R A C I O N //

    //GIRS PASADOS
    public function GirsPasados()
    {
        if (empty($_SESSION['permisosModulo']['r'])) {
            header("Location:" . Base_URL() . '/Dashboard');
        }
        $data['page_title'] = "Closed Gir's";
        $data['page_main'] = "Closed Gir's";
        $data['page_name'] = "Closed Gir's";
        $data['page_functions_js'] = "Function_Girs_Pasados.js";
        $this->views->getView($this, "girsPasados", $data);
    }

    //Metodo para obtener los registros en la tabla de girs pasados
    public function getGirsPasados()
    {
        if ($_SESSION['permisosModulo']['r']) {
            //Recuperar los filtros enviados desde el frontend
            $tipoHuesped = isset($_GET['tipoHuesped']) ? $_GET['tipoHuesped'] : '';
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
            $villa = isset($_GET['villa']) ? $_GET['villa'] : '';
            $prioridad = isset($_GET['prioridad']) ? $_GET['prioridad'] : '';
            $departamento = isset($_GET['departamentos']) ? $_GET['departamentos'] : '';
            $oportunidad = isset($_GET['oportunidad']) ? $_GET['oportunidad'] : '';
            $creacion_start = isset($_GET['creacion_start']) ? $_GET['creacion_start'] : '';
            $creacion_end = isset($_GET['creacion_end']) ? $_GET['creacion_end'] : '';
            $entrada = isset($_GET['entrada']) ? $_GET['entrada'] : '';
            $salida = isset($_GET['salida']) ? $_GET['salida'] : '';

            // Recuperar los datos de la base de datos
            $arrData = $this->model->selectRegistrosPasados($tipoHuesped, $categoria, $villa, $prioridad, $departamento, $oportunidad, $creacion_start, $creacion_end, $entrada, $salida);
            // Convertir el estado del Gir antes del bucle
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
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF ; color:#454545;" onclick="btnViewGir(' . $row['idGir'] . ')" title = "Ver Gir"><i class="fas fa-eye"></i></button>' : '';

                $btnHistory =
                    ($_SESSION['permisosModulo']['r']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color: #454545;"
                    onclick="btnHistoryGir(' . $row['idGir'] . ' )"title = "Historia Gir"><i class="fas fa-book"></i></button>' : '';

                $btnUpdate =
                    ($_SESSION['permisosModulo']['u']) ? '<button class="btn btn-sm fa-bold" style="background: #FFFFFF; color:#454545;" onclick="btnUpdateGir(' . $row['idGir'] . ')" title = "Actualizar Gir"><i class="fas fa-edit"></i></button>' : '';

                $btnDelete =
                    ($_SESSION['permisosModulo']['d']) ? '<button class="btn btn-sm" style="background: #FFFFFF; color:#454545;" onclick="btnDeletedGir(' . $row['idGir'] . ')" title = "Eliminar Gir"><i class="fas fa-trash"></i></button>' : '';

                $row['options'] = '<div class="text-center">'
                    . $btnView . ' ' . $btnHistory . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die(); // Terminar el script después de enviar la respuesta
    }
}
