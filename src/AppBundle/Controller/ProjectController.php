<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:21
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProjectController extends Controller {

    /**
     * @Route("/nuevoproyecto")
     */
    public function nuevoProyecto(){

        return $this->render('default/nuevoproyecto.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);

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