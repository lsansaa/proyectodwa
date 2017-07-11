<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:21
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProjectController{

    /**
     * @Route("/agregarproyecto")
     */
    public function agregarProyecto(){

        return new Response('<html><head><title>Agregar proyecto</title></head><body><h1>Agregar proyecto</h1></body></html>');

    }

    /**
     * @Route("/eliminarproyecto")
     */
    public function eliminarProyecto(){

        return new Response('<html><head><title>Eliminar proyecto</title></head><body><h1>Eliminar proyecto</h1></body></html>');

    }

    /**
     * @Route("/modificarproyecto")
     */
    public function modificarProyecto(){

        return new Response('<html><head><title>Modificar proyecto</title></head><body><h1>Modificar proyecto</h1></body></html>');

    }

}