<?php

class NotificacionesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    //Método para seleccionar información de notificaciones
    public function selectInformacion()
    {
        try {
            $sql = "SELECT user as nombreCompleto, descripcion, gir_id as idRegistro, idNotificacion,
                CONCAT(DAY(dateCreate), ' of ', 
                CASE MONTH(dateCreate)
                    WHEN 1 THEN 'January'
                    WHEN 2 THEN 'February'
                    WHEN 3 THEN 'March'
                    WHEN 4 THEN 'April'
                    WHEN 5 THEN 'May'
                    WHEN 6 THEN 'June'
                    WHEN 7 THEN 'July'
                    WHEN 8 THEN 'August'
                    WHEN 9 THEN 'September'
                    WHEN 10 THEN 'October'
                    WHEN 11 THEN 'November'
                    WHEN 12 THEN 'December'
                END, ' of ', YEAR(dateCreate)) AS fechaMovimiento,
                DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaMovimiento 
            FROM notificaciones 
            WHERE status = 1 AND leerNotificacion = 0
            ORDER BY dateCreate DESC";
            $request = $this->select_All($sql);
            return $request;
        } catch (Exception $e) {
            error_log("Error en selectInformacion: " . $e->getMessage());
            return [];
        }
    }
    
    public function markNotification($id)
    {
        try {
            $sql = "UPDATE notificaciones SET leerNotificacion = 1 WHERE idNotificacion = ?";
            $arrData = array($id);
            $request = $this->update($sql, $arrData);
            return $request;
        } catch (Exception $e) {
            error_log("Error en markNotificationAsRead: " . $e->getMessage());
            return false;
        }
    }
    
     //Método para seleccionar información de notificaciones
    public function selectNotificacion()
    {
            $sql = "SELECT user as nombreCompleto, descripcion, gir_id as idRegistro, idNotificacion,
                CONCAT(DAY(dateCreate), ' of ', 
                CASE MONTH(dateCreate)
                    WHEN 1 THEN 'January'
                    WHEN 2 THEN 'February'
                    WHEN 3 THEN 'March'
                    WHEN 4 THEN 'April'
                    WHEN 5 THEN 'May'
                    WHEN 6 THEN 'June'
                    WHEN 7 THEN 'July'
                    WHEN 8 THEN 'August'
                    WHEN 9 THEN 'September'
                    WHEN 10 THEN 'October'
                    WHEN 11 THEN 'November'
                    WHEN 12 THEN 'December'
                END, ' of ', YEAR(dateCreate)) AS fechaMovimiento,
                DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaMovimiento 
            FROM notificaciones 
            WHERE status = 1 AND leerNotificacion = 1
            ORDER BY dateCreate DESC";
            $request = $this->select_All($sql);
            return $request;
        
    }
    
}
