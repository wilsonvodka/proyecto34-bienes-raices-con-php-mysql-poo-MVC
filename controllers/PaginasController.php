<?php


namespace Controllers;

use Dotenv\Dotenv;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;



class PaginasController
{
    public static function index(Router $router)
    {

        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio

        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros');
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router)
    {
        $id = validarORedireccionar('/propiedades');

        //buscar  la propiedad por su id
        $propiedad = Propiedad::find($id);


        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {

        $router->render('paginas/blog');
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();

            //crear una instancia de phpmailer
            $mail = new PHPMailer();
            //configurar el smtp
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['USERNAME'];
            $mail->Password = $_ENV['PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //configurar el contendio del email
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@binenesraices.com', 'BienesRaices');
            $mail->Subject = 'tienes un nuevo mensaje';

            //habilitar el html
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            //definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

            //enviar de forma condicional algunos campos de email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p>Eligió ser contactado por telefono</p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p> Fecha contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p> Hora: ' . $respuestas['hora'] . '</p>';
            } else {
                //agregamos el campo del email
                $contenido .= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }


            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . '</p>';

            $contenido .= '</html>';


            $mail->Body = $contenido;
            $mail->AltBody = 'esto es texto alternativo sin html';
            //enviar el email
            if ($mail->send()) {
                $mensaje = 'mensaje enviado correctamente';
            } else {
                $mensaje = 'el mensaje no se pudo enviar';
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
