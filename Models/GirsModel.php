<?php

class GirsModel extends Mysql
{
    //Propiedades
    private $strUsuario;
    private $intIdGir;
    private $strClasificacion;
    private $strCompensacion;
    private $strFecha;
    private $strApellidos;
    private $strVilla;
    private $strEntrada;
    private $strSalida;
    private $intIdDepartamento;
    private $intIdLugar;
    private $intIdQueja;
    private $strDescripcion;
    private $strAccion;
    private $strSeguimiento;
    private $strEstadoGir;
    private $strNivelGir;
    private $strCategoriaGir;
    private $strTipoGir;
    private $strImagen;
    private $strFechaInicio;
    private $strFechaFinal;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los departamentos
    public function selectDepartamentos()
    {
        $sql = "SELECT * FROM departamento WHERE status != 0 ORDER BY nombre ASC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer los lugares de las quejas
    public function selectLugares()
    {
        $sql = "SELECT * FROM lugarqueja WHERE status != 0 ORDER BY nombre ASC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer las opciones en el select
    public function selectQuejas()
    {
        $sql = "SELECT * FROM quejas WHERE status != 0 ORDER BY nombre ASC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer los registros para la table 
    public function selectRegistros($tipoHuesped, $categoria, $villa, $prioridad, $departamento, $oportunidad, $creacion_start, $creacion_end, $entrada, $salida)
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion,g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar INNER JOIN quejas q ON g.quejaid = q.idQueja WHERE (g.status = 1) AND ((g.estadoGir = 'Open') OR (DATE(g.fecha) < CURDATE() AND g.status = 0))";
        //aplicar filtros a la consulta, declaramos un Arreglo 
        $filtros = [
            'g.TipoGir' => $tipoHuesped,
            'g.clasificacion' => $categoria,
            'g.villa' => $villa,
            'g.nivel' => $prioridad,
            'g.departamentoid' => $departamento,
            'g.quejaid' => $oportunidad,
            'Date(g.entrada)' => $entrada,
            'Date(g.salida)' => $salida,
        ];

        //Iteramos sobre el arreglo de filtros
        foreach ($filtros as $columna => $valor) {
            if (!empty($valor)) {
                $sql .= " AND $columna = '$valor'";
            }
        }
        
         if(!empty($creacion_start) && !empty($creacion_end)){
                $sql .= "AND Date(g.fecha) BETWEEN '$creacion_start' AND '$creacion_end'";
            }elseif(!empty($creacion_start)){
                $sql .= "AND Date(g.fecha) >= '$creacion_start'";
            }elseif(!empty($creacion_end)){
                $sql .= "AND Date(g.fecha) <= '$creacion_end";
            }


        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar registros a la bd 
    public function insertGirs(string $usuario, string $clasificacion, string $compensacion, string $fecha, string $apellidos, string $villa, string $entrada, string $salida, string $estado, string $nivel, string $categoria, string $tipo, int $queja, int $lugar, int $departamento, string $descripcion, string $accion, string $seguimiento, string $imagen)
    {
        // Asignamos valores de los parámetros a las propiedades
        $this->strUsuario = $usuario;
        $this->strClasificacion = $clasificacion;
        $this->strCompensacion = $compensacion;
        $this->strFecha = $fecha;
        $this->strApellidos = $apellidos;
        $this->strVilla = $villa;
        $this->strEntrada = $entrada;
        $this->strSalida = $salida;
        $this->strEstadoGir = $estado;
        $this->strNivelGir = $nivel;
        $this->strCategoriaGir = $categoria;
        $this->strTipoGir = $tipo;
        $this->intIdQueja = $queja;
        $this->intIdLugar = $lugar;
        $this->intIdDepartamento = $departamento;
        $this->strDescripcion = $descripcion;
        $this->strAccion = $accion;
        $this->strSeguimiento = $seguimiento;
        $this->strImagen = $imagen;
        $dateUpdate = null;
        $dateDelete = null;
        $descripcionNotificacion = "ha creado un GIR";

        // Creamos la consulta para insertar en la tabla girs
        $sql = "INSERT INTO girs(clasificacion,compensacion,fecha,apellidos,villa,entrada,salida,departamentoid,lugarQuejaid,quejaid,descripcion,accionTomada,seguimiento,estadoGir,TipoGir,nivel,categoria,imagen,userCreate,dateCreate,dateUpdate,dateDelete) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR),?,?)";
        $arrData = array($this->strClasificacion, $this->strCompensacion, $this->strFecha, $this->strApellidos, $this->strVilla, $this->strEntrada, $this->strSalida, $this->intIdDepartamento, $this->intIdLugar, $this->intIdQueja, $this->strDescripcion, $this->strAccion, $this->strSeguimiento, $this->strEstadoGir, $this->strTipoGir, $this->strNivelGir, $this->strCategoriaGir, $this->strImagen, $this->strUsuario, $dateUpdate, $dateDelete);

        // Ejecutamos la inserción en la tabla girs y obtenemos el ID del último registro insertado
        $request_insert = $this->insert($sql, $arrData);

        // Creamos la consulta para insertar en la tabla notificaciones
        $sqlNotificacion = "INSERT INTO notificaciones(user,descripcion,gir_id,dateCreate) VALUES (?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
        $arrDataNotificacion = array($this->strUsuario, $descripcionNotificacion, $request_insert);

        // Ejecutamos la inserción en la tabla notificaciones
        $request_insertNoti = $this->insert($sqlNotificacion, $arrDataNotificacion);

        // Creamos la consulta para insertar en la tabla comentarios
        $sqlHistorial = "INSERT INTO comentarios(gir_id, user, descripcion_gir, accion_gir, seguimiento_gir,dateCreate) VALUES (?,?,?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
        $arrDataHistorial = array($request_insert, $this->strUsuario, $this->strDescripcion, $this->strAccion, $this->strSeguimiento);

        //Ejecutamos la insercion en la tabla comentarios
        $request_Historial = $this->insert($sqlHistorial, $arrDataHistorial);

        // Devolvemos los resultados de las inserciones
        $resultados = array(
            "request_insert" => $request_insert,
            "request_insertNoti" => $request_insertNoti,
            "request_insertHistorial" => $request_Historial
        );

        return $resultados;
    }


    //Metodo para extraer la informacion del gir
    public function selectGir(int $idGir)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intIdGir = $idGir;
        //Creamos una variable y almacenamos la consulta
        $sql = "SELECT g.idGir,g.clasificacion,g.compensacion,g.fecha as fechaFinal, g.entrada as fechaEntrada, g.apellidos,g.villa,g.salida as fechaSalida,g.departamentoid,g.lugarQuejaid,g.quejaid,g.descripcion,g.accionTomada,g.seguimiento,g.estadoGir,g.TipoGir,g.nivel,g.categoria,g.imagen, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada, DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS hora, DATE_FORMAT(g.dateCreate, '%d/%m/%Y' ' ' '%h:%i:%s %p') as dateCreate,g.userCreate,DATE_FORMAT(g.dateUpdate, '%d/%m/%Y' ' ' '%h:%i:%s %p') as dateUpdate,g.userUpdate,d.idDepartamento,d.nombre as nombreDepartamento,l.idLugar, l.nombre as nombreLugar, q.idQueja,q.nombre as nombreQueja FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar INNER JOIN quejas q ON g.quejaid = q.idQueja WHERE idGir = $this->intIdGir";
        $request = $this->select($sql);

        // Verificar si $request es un array
        if (is_array($request)) {
            return $request;
        } else {
            // Si no es un array, devuelve un array vacío o un mensaje de error, según tu lógica de manejo de errores
            return [];
        }
    }

    public function UpdateGirs(int $idgir, string $usuario, string $clasificacion, string $compensacion, string $fecha, string $apellidos, string $villa, string $entrada, string $salida, string $estado, string $nivel, string $categoria, string $tipo, int $queja, int $lugar, int $departamento, string $descripcion, string $accion, string $seguimiento, string $imagen)
    {
        $this->intIdGir = $idgir;
        $this->strUsuario = $usuario;
        $this->strClasificacion = $clasificacion;
        $this->strCompensacion = $compensacion;
        $this->strFecha = $fecha;
        $this->strApellidos = $apellidos;
        $this->strVilla = $villa;
        $this->strEntrada = $entrada;
        $this->strSalida = $salida;
        $this->strEstadoGir = $estado;
        $this->strNivelGir = $nivel;
        $this->strCategoriaGir = $categoria;
        $this->strTipoGir = $tipo;
        $this->intIdQueja = $queja;
        $this->intIdLugar = $lugar;
        $this->intIdDepartamento = $departamento;
        $this->strDescripcion = $descripcion;
        $this->strAccion = $accion;
        $this->strSeguimiento = $seguimiento;
        $this->strImagen = $imagen;

        // Obtener los valores actuales de descripcion, accionTomada y seguimiento
        $sqlSelect = "SELECT descripcion, accionTomada, seguimiento FROM girs WHERE idGir = $this->intIdGir";
        $arrSelect = array($this->intIdGir);
        $currentValues = $this->select($sqlSelect, $arrSelect);

        // Comprobar si hay cambios en descripcion, accionTomada o seguimiento
        $insertComment = (
            $currentValues['descripcion'] !== $this->strDescripcion ||
            $currentValues['accionTomada'] !== $this->strAccion ||
            $currentValues['seguimiento'] !== $this->strSeguimiento
        );

        // Actualizar la tabla girs
        $sqlUpdate = "UPDATE girs SET clasificacion = ?, compensacion = ?, fecha = ?, apellidos = ?, villa = ?, entrada = ?, salida = ?, departamentoid = ?, lugarQuejaid = ?, quejaid = ?, descripcion = ?, accionTomada = ?, seguimiento = ?, estadoGir = ?, TipoGir = ?, nivel = ?, categoria = ?, imagen = ?, userUpdate = ?, dateUpdate = DATE_SUB(NOW(), INTERVAL 5 HOUR) WHERE idGir = $this->intIdGir";
        $arrDataUpdate = array(
            $this->strClasificacion,
            $this->strCompensacion,
            $this->strFecha,
            $this->strApellidos,
            $this->strVilla,
            $this->strEntrada,
            $this->strSalida,
            $this->intIdDepartamento,
            $this->intIdLugar,
            $this->intIdQueja,
            $this->strDescripcion,
            $this->strAccion,
            $this->strSeguimiento,
            $this->strEstadoGir,
            $this->strTipoGir,
            $this->strNivelGir,
            $this->strCategoriaGir,
            $this->strImagen,
            $this->strUsuario,
        );
        $request_update = $this->update($sqlUpdate, $arrDataUpdate);

        // Si hay cambios en descripcion, accionTomada o seguimiento, insertar en la tabla comentarios
        if ($insertComment) {
            $sqlHistorial = "INSERT INTO comentarios(gir_id, user, descripcion_gir, accion_gir, seguimiento_gir, dateCreate) VALUES (?,?,?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            $arrDataHistorial = array($this->intIdGir, $this->strUsuario, $this->strDescripcion, $this->strAccion, $this->strSeguimiento);
            $request_Historial = $this->insert($sqlHistorial, $arrDataHistorial);
        } else {
            $request_Historial = null;
        }

        return array(
            "request_update" => $request_update,
            "request_insertHistorial" => $request_Historial
        );
    }



    //Metodo para eliminar girs
    public function deleteGirs(int $idGir)
    {
        //Asignamos el valor del parametro a la propiedad
        $this->intIdGir = $idGir;
        $sql = "UPDATE girs SET status = ? WHERE idGir = ?";
        $arrData = array(0, $this->intIdGir);
        $request = $this->update($sql, $arrData);
        // Verificar si la consulta fue exitosa y devolver el resultado
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    //Metodo para exportar el reporte diario 
    public function girReporte($TipoGir)
    {
        // Obtener la fecha y hora actual en la zona horaria del servidor
        $fecha_actual_servidor = date('Y-m-d H:i:s');

        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual_servidor)));

        // Separar la fecha y la hora ajustada
        $fecha_actual = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $hora_actual = date('H:i:s', strtotime($fecha_actual_ajustada));

        $this->strTipoGir = $TipoGir;

        $sql = "SELECT 
    g.idGir, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion,
    g.accionTomada, g.seguimiento, g.estadoGir, g.TipoGir, g.imagen, g.status, g.nivel,
    d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar,
    q.idQueja, q.nombre as nombreQueja, 
    DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
    DATE_FORMAT(g.salida, '%Y/%m/%d') as salida, 
    DATE_FORMAT(g.fecha, '%h:%i %p') AS horaGir 
FROM girs g 
INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
INNER JOIN quejas q ON g.quejaid = q.idQueja 
WHERE 
    (
        (
            -- Condición 1: Los registros del día anterior a partir de las 7 de la mañana
            (DATE(g.fecha) = DATE_SUB('$fecha_actual', INTERVAL 1 DAY) AND TIME(g.fecha) >= '07:00:00')
        )
        OR
        (
            -- Condición 2: Los registros del día actual dentro del rango de 12:00 am a 6:59 am
            DATE(g.fecha) = '$fecha_actual' AND TIME(g.fecha) >= '00:00:00' AND TIME(g.fecha) <= '06:59:59'
        )
        OR
        (
            -- Condición 3: Registros de días anteriores con salida igual a la fecha actual
            DATE(g.fecha) < '$fecha_actual' AND DATE(g.salida) = '$fecha_actual'
        )
    )
    AND 
    ( 
        (g.status != 0 AND (g.estadoGir = 'Open' OR g.estadoGir = 'Closed'))
    )
    AND 
    ( 
        -- Condición adicional: TipoGir igual a una variable especificada
        g.TipoGir = '$this->strTipoGir'
    )
    AND 
    (
        -- Condición adicional: Excluir la queja 'Allergies/ Food Restrictions'
        q.nombre != 'Allergies/ Food Restrictions'
    )
ORDER BY 
    g.villa ASC";

        $request = $this->select_All($sql);
        return $request;
    }



    //Metodo para exportar el reporte por rango de fecha
    public function girReporteFiltro($TipoGir, $inicio, $final)
    {
        //Asignamos los valores de los parametros a las propiedades
        $this->strTipoGir = $TipoGir;
        $this->strFechaInicio = $inicio;
        $this->strFechaFinal = $final;

        //Creamos la variable para almacenar la consulta
        $sql = "SELECT g.idGir, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.TipoGir, g.imagen, g.status, g.nivel, d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar, q.idQueja, q.nombre as nombreQueja, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, DATE_FORMAT(g.fecha, '%h:%i %p') AS horaGir 
        FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar INNER JOIN quejas q ON g.quejaid = q.idQueja WHERE g.TipoGir = '$this->strTipoGir' AND DATE(g.fecha) BETWEEN '$this->strFechaInicio' AND '$this->strFechaFinal' 
        AND (g.status != 0 AND (g.estadoGir = 'Open' OR g.estadoGir = 'Closed')) ORDER BY g.fecha ASC, horaGir ASC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para exportar el reporte de alergias
    public function girReporteAlergias($TipoGir)
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        $this->strTipoGir = $TipoGir;

        $sql = "SELECT 
    g.idGir, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.TipoGir, g.imagen, g.status, g.nivel,
    d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar, q.idQueja, q.nombre as nombreQueja, 
    DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
    DATE_FORMAT(g.salida, '%Y/%m/%d') as salida, 
    DATE_FORMAT(g.fecha, '%h:%i %p') AS horaGir 
FROM girs g 
INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
INNER JOIN quejas q ON g.quejaid = q.idQueja 
WHERE (
    (g.TipoGir = '$this->strTipoGir') AND 
    (
        (DATE(g.salida) = DATE('$fecha_actual_ajustada') AND TIME(g.salida) > TIME('$fecha_actual_ajustada')) OR 
        (DATE(g.salida) > DATE('$fecha_actual_ajustada')) OR 
        (DATE(g.salida) = DATE('$fecha_actual_ajustada'))
    )
) AND (
    (g.status != 0 AND g.estadoGir = 'Open') OR 
    (g.status != 0 AND g.estadoGir = 'Closed')
) AND (
    q.nombre = 'Allergies/ Food Restrictions'
)
ORDER BY g.fecha DESC, horaGir ASC;";

        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para fultrar quejas por huesped
    public function filterHuesped(string $apellidos)
    {
        $this->strApellidos = $apellidos;

        $sql = "SELECT g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion,g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar INNER JOIN quejas q ON g.quejaid = q.idQueja WHERE g.apellidos = '$this->strApellidos' AND g.status =! 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para historial
    public function selectHistorial(int $id)
    {
        $this->intIdGir = $id;

        // Consulta SQL usando un parámetro
        $sql = "SELECT gir_id, user, descripcion_gir, accion_gir, seguimiento_gir, DATE_FORMAT(dateCreate, '%d/%m/%Y') AS fechaFormateada, DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaFormateada FROM comentarios WHERE gir_id = $this->intIdGir ORDER BY dateCreate DESC";
        $request = $this->select_All($sql);
        return $request;
    }



    // SEPARACION, METODOS PARA LOS REGISTROS PASADOS //
    public function selectRegistrosPasados($tipoHuesped, $categoria, $villa, $prioridad, $departamento, $oportunidad, $creacion, $entrada, $salida)
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.TipoGir, g.imagen, g.status, g.nivel, d.idDepartamento, d.nombre as nombreDepartamento, l.idLugar, l.nombre as nombreLugar, q.idQueja, q.nombre as nombreQueja, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada, DATE_FORMAT(g.salida, '%d/%m/%Y') as salida,  DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar INNER JOIN 
        quejas q ON g.quejaid = q.idQueja WHERE g.status != 0 AND g.estadoGir = 'Closed'";

        //aplicar filtros a la consulta
        if (!empty($tipoHuesped)) {
            $sql .= " AND g.TipoGir = '$tipoHuesped'"; //filtro por tipo de huesped
        }
        if (!empty($categoria)) {
            $sql .= " AND g.categoria = '$categoria'"; //filtro por categoria
        }
        if (!empty($villa)) {
            $sql .= " AND g.villa = '$villa'";
        }
        if (!empty($prioridad)) {
            $sql .= " AND g.nivel = '$prioridad'";
        }
        if (!empty($departamento)) {
            $sql .= " AND g.departamentoid = '$departamento'";
        }
        if (!empty($oportunidad)) {
            $sql .= " AND g.quejaid = '$oportunidad'";
        }
        if (!empty($creacion)) {
            $sql .= " AND DATE(g.fecha) = '$creacion'";
        }

        if (!empty($entrada)) {
            $sql .= " AND DATE(g.entrada) = '$entrada'";
        }

        if (!empty($salida)) {
            $sql .= " AND DATE(g.salida) = '$salida'";
        }

        $request = $this->select_All($sql);
        return $request;
    }
}
