<?php

require_once("Libraries/PHPMailer/src/PHPMailer.php");
require_once("Libraries/PHPMailer/src/SMTP.php");
require_once("Libraries/PHPMailer/src/Exception.php");

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

//Envio de correo electronico
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailVerification(string $email, string $token, string $strNombres): bool
{
   require_once("Libraries/PHPMailer/src/PHPMailer.php");
   require_once("Libraries/PHPMailer/src/SMTP.php");
   require_once("Libraries/PHPMailer/src/Exception.php");

   $mail = new PHPMailer(true);

   try {
      $mail->isSMTP();
      $mail->Host = 'sandbox.smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Username = 'f5547557a93961';
      $mail->Password = '52a7b0313a7973';
      $mail->Port = 2525;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      $mail->setFrom('Gustavo_Carranza2008@outlook.com', 'Go To Guest');
      $mail->addAddress($email);

      $url = base_url() . "/Verification/email_verified?token=" . $token;

      $mail->isHTML(true);
      $mail->Subject = 'Bienvenido a Go To Guest';

      $mail->Body = "
<html>
<head>
    <style>
        /* Ajustes para móviles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }
            .content {
                padding: 20px !important;
            }
            .button {
                padding: 12px 20px !important;
                font-size: 14px !important;
            }
        }
    </style>
</head>
<body style='margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
    <table width='100%' bgcolor='#f4f4f4' cellpadding='0' cellspacing='0'>
        <tr>
            <td>
                <table align='center' width='600' class='container' bgcolor='#ffffff' cellpadding='0' cellspacing='0' style='border-radius:8px; overflow:hidden;'>
                    <!-- Header -->
                    <tr>
                        <td bgcolor='#006399' style='padding:20px; text-align:center; color:white; font-size:26px; font-weight:bold;'>
                            Go To Guest
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td class='content' style='padding:30px; color:#333; font-size:18px; line-height:1.5;'>
                            <p>Hola <strong>$strNombres</strong>,</p>
                            <p style='line-height:1.5;'>Gracias por unirte a <strong> Go To Guest </strong>. Para comenzar a disfrutar de esta experiencia, verifica tu correo y activa tu cuenta presionando el boton a continuacion:</p>
                            
                            <p style='text-align:center; margin:30px 0;'>
                                <a href='$url' class='button' style=\"
                                    background-color:#006399;
                                    color:#ffffff;
                                    padding:15px 30px;
                                    text-decoration:none;
                                    border-radius:5px;
                                    font-size:16px;
                                    display:inline-block;
                                \">Activa tu cuenta</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor='#f0f0f0' style='padding:20px; text-align:center; font-size:12px; color:#888;'>
                            <p>2024 - " . date('Y') . " Gustavo Carranza Rviera. Todos los derechos reservaodos.</p>
                            <p><a href='Gustavo_Carranza2008@outlook.com' style='color:#0d6efd; text-decoration:none;'>Gustavo_Carranza2008@outlook.com</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";

      $mail->AltBody = "Hi $strNombres, please verify your account using this link: $url";


      return $mail->send();
   } catch (Exception $e) {
      error_log("Mail error: " . $mail->ErrorInfo);
      return false;
   }
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
   } else {
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
