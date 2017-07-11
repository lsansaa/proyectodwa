<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:06
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController{

    /**
     * @Route("/registro")
     */
    public function registroUsuario(){

        return new Response('<html><head><title>Registro de usuarios</title></head><body><h1>Registro de usuarios</h1></body></html>');

    }

    /**
     * @Route("/login")
     */
    public function loginUsuario(){

        return new Response('<html><head><title>Ingreso de usuarios</title></head><body><h1>Ingreso de usuarios</h1></body></html>');

    }

}