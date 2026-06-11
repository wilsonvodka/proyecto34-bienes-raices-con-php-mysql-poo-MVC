<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController
{
    public static function crear(Router $router)
    {


        $errores = Vendedor::getErrores();
        $vendedor = new Vendedor;


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //crear una nueva instancia
            $vendedor = new Vendedor($_POST['vendedor']);

            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }
    public static function actualizar(Router $router)
    {
        $errores = Vendedor::getErrores();
        $id = validarORedireccionar('/admin');
        //obtener los datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);

        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor'=> $vendedor
        ]);
    }
    public static function eliminar()
    {
        echo 'eliminar vendedor';
    }
}
