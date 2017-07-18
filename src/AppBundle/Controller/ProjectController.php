<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Proyecto;
use AppBundle\Form\ProyectoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProjectController extends Controller {

    /**
     * @Route("/nuevoproyecto")
     */
    public function nuevoProyecto(){

        $proyecto = new Proyecto();
        $form = $this->createForm(ProyectoType::class , $proyecto);

        if ($form->isSubmitted() && $form->isValid()) {

            //Agregar codigo para persistir

        }

        return $this->render('default/nuevoproyecto.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/proyectos")
     */
    public function proyectos(){

        return $this->render('default/proyectos.html.twig');

    }


}