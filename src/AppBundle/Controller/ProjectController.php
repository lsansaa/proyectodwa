<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Director;
use AppBundle\Entity\RepresentanteLegal;
use AppBundle\Form\ProyectoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller {

    /**
     * @Route("/nuevoproyecto")
     */
    public function nuevoProyecto(Request $request){

        $personasTemp = $this->getDoctrine()->getRepository(Persona::class)->findAll();
        $personas = array();
        $i = 0;

        foreach ($personasTemp as $p){

            $rut = $p->getRut();
            $personas[$i] = $rut;
            $i = $i + 1;

        }

        $proyecto = new Proyecto();

        $form = $this->createForm(ProyectoType::class, $proyecto, array('directores' => $personas, 'representantes' => $personas));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Obtengo los datos recolectados del formulario.
            $nombre = $form["nombre"]->getData();
            $fechainicio = $form["fecha_inicio"]->getData();
            $fechatermino = $form["fecha_termino"]->getData();
            $rutdirector = $form["rut_director"]->getData();
            $rutrepresentante = $form["rut_representante"]->getData();

            $proyecto->setNombre($nombre);
            $proyecto->setFechaInicio($fechainicio);
            $proyecto->setFechaTermino($fechatermino);
            $proyecto->setEstado('publicado');

            $personadirector = $this->getDoctrine()->getRepository(Persona::class)->find($rutdirector);
            $personarepresentante = $this->getDoctrine()->getRepository(Persona::class)->find($rutrepresentante);

            $proyecto->setRutDirector($personadirector);
            $proyecto->setRutRepresentante($personarepresentante);

            //Inicializo la persistencia.
            $em = $this->getDoctrine()->getManager();
            $em->persist($proyecto);
            $em->flush();
            return new Response("<html><body><h1>Ingreso exitoso</h1></body></html>");

        }

        return $this->render('default/nuevoproyecto.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/proyectos")
     */
    public function proyectos(){

        return $this->render('default/proyectos.html.twig');

    }


}