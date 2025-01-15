<?php

class Notificaciones extends Controllers{
    public function __construct()
    {
        parent::__construct();
    }

    public function Controlador()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

        //Crear una variable y punteamos el metodo del modelo
        $arrData = $this->model->selectInformacion();
        if(!empty($arrData)){
            foreach($arrData as $notificacion){
                echo "data: " . json_encode([
                    'title' => 'Nueva Notificación Recibida',
                    'name' => $notificacion['nombreCompleto'],
                    'description'=> $notificacion['descripcion'],
                    'NoId' =>  "#".  $notificacion['idRegistro'],
                    'id' => $notificacion['idNotificacion'],// Ajustar según tu estructura de datos
                    'fecha' => $notificacion['fechaMovimiento'],
                    'hora' => $notificacion['horaMovimiento'],
                ]) .  PHP_EOL . "\n\n";
                
            }

            echo PHP_EOL;
            ob_flush();
            flush();    
            // Marcar la notificación  omo leída (opcional)
             $this->model->markNotification($notificacion['idNotificacion']); // Ajustar según tu método y estructura de datos
        }
    }
    
    public function getNotificaciones()
    {
        $arrData = $this->model->selectNotificacion();
        //Si el arreglo esta vacio mostrara un msj de error
        if (!empty($arrData)) {
            $arrReponse = array('status' => true, 'data' => $arrData);
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => false, 'msg' => 'Data not found');
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>