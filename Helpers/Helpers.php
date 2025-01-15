<?php

//Retornar la url del proyecto
function base_url()
{
   return Base_URL;
}
//Retorna la url de Assets
function media()
{
   return Base_URL . "/Assets";
}
//Muestra informacion formateada
function dep($data)
{
   $format = print_r('<pre>');
   $format .= print_r($data);
   $format .= print_r('</pre>');
   return $format;
}
//Diccionario de validaciones que nos permite utilizar para proteger de inyecciones SQL
function strClean($strCadena)
{
   $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
   $string = trim($string);
   $string = stripslashes($string);
   $string = str_ireplace("<script>", "", $string);
   $string = str_ireplace("</script>", "", $string);
   $string = str_ireplace("<script src>", "", $string);
   $string = str_ireplace("SELECT * FROM", "", $string);
   $string = str_ireplace("DELETE FROM", "", $string);
   $string = str_ireplace("INSERT INTO", "", $string);
   $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
   $string = str_ireplace("DROP TABLE", "", $string);
   $string = str_ireplace("OR '1'='1'", "", $string);
   $string = str_ireplace('OR "1"="1"', "", $string);
   $string = str_ireplace('OR `1`=`1`', "", $string);
   $string = str_ireplace("is NULL; --", "", $string);
   $string = str_ireplace("LIKE '", "", $string);
   $string = str_ireplace('LIKE "', "", $string);
   $string = str_ireplace("LIKE `", "", $string);
   $string = str_ireplace("[", "", $string);
   $string = str_ireplace("]", "", $string);
   $string = str_ireplace("==", "", $string);
   return $string;
}
//Generar un token
function token()
{
   $r1 = bin2hex(random_bytes(10));
   $r2 = bin2hex(random_bytes(10));
   $r3 = bin2hex(random_bytes(10));
   $r4 = bin2hex(random_bytes(10));
   $r5 = bin2hex(random_bytes(10));
   $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4 . '-' . $r5;
   return $token;
}
//Formatear para valores monetarios
function formatMoney($cantidad)
{
   $cantidad = number_format($cantidad, 2, SPD, SPM);
   return $cantidad;
}
//Contenido de header
function headerAdmin($data = "")
{
   $view_header = "Views/Templates/header.php";
   require_once($view_header);
}
//Contenido de footer
function footerAdmin($data = "")
{
   $view_footer = "Views/Templates/footer.php";
   require_once($view_footer);
}
//Funcion para direccionar al modal seleccionado
function getModal(string $nameModal, $data)
{
   $view_modal = "Views/Templates/Modals/{$nameModal}.php";
   require_once $view_modal;
}
//Funcion para otorgar permisos
function getPermisos(int $idmodulo)
{
   //Aqui lo que hacemos es requerir el archivo del modelo de los permisos
   require_once("Models/PermisosModel.php");
   //Estamos creando una instancia a la clase permisosModel del modelo de permisos para utilizar los metodos que tiene
   $objPermisos = new PermisosModel();
   //Obtenemos el id del rol con el cual estamos logueados y lo abtenemos con la variable de sesion 
   $idrol = $_SESSION['UserData']['idRol'];
   //Creamos una variable que nos sirve como un arreglo de datos lo igualamos a la variable de la instancia de la clase y declaramos un metodo que vamos a crear en el modelo y le pasamos el id del rol
   $arrPermisos = $objPermisos->permisosModulo($idrol);
   $permisos = '';
   $permisosModulo = '';
   if (count($arrPermisos) > 0) {
      $permisos = $arrPermisos;
      $permisosModulo = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
   }
   $_SESSION['permisos'] = $permisos;
   $_SESSION['permisosModulo'] = $permisosModulo;
}
function sessionUser(int $idusuario)
{
   require_once("Models/LoginModel.php");
   $objLogin = new LoginModel();
   $request = $objLogin->sessionLogin($idusuario);
   return $request;
}
function sessionStart()
{
   session_start();
   $inactiva = 5000;
   if (isset($_SESSION['timeout'])) {
      $session_in = time() - $_SESSION['inicio'];
      if ($session_in > $inactiva) {
         header("Location: " . Base_URL . "/logout");
      }
   }else{
      header("Location: " . Base_URL . "/logout");
   }
}
function FPDF()
{
   $view_PDF = "Libraries/PDF/fpdf.php";
   require_once($view_PDF);
}
function Celdas()
{
   $view_PDF = "Libraries/PDF/celdas.php";
   require_once($view_PDF);
}
