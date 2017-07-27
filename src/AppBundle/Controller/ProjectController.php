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
use AppBundle\Entity\Archivo;
use AppBundle\Form\ProyectoType;
use Distill\Format\Simple\Ar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class ProjectController extends Controller {

    /**
     * @Route("/nuevoproyecto", name="registrar_proyecto")
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
     * @Route("/proyectos/")
     */
    public function proyectos(Request $request){

        $sesion = $this->getUser();
        $proyecto = new Proyecto();

        $form = $this->createFormBuilder($proyecto)->getForm();
        $form->handleRequest($request);

        //Acceso por medio de una credencial guardada en memoria. (No obtenida de la BD).
        if(strcmp($sesion,'luis') == 0){

            $proyectos = $this->getDoctrine()->getRepository(Proyecto::class)->findAll();
            return $this->render('default/proyectos.html.twig',array('proyectos' => $proyectos, 'form' => $form->createView()));

        }else{ //De lo contrario, se busca a la persona en la BD usando el rut o email de la sesión.

            $personas = $this->getDoctrine()->getRepository(Persona::class)->findAll();

            foreach($personas as $persona){

                if(strcmp($persona->getRut(),$sesion) == 0 or strcmp($persona->getEmail(),$sesion) == 0){

                    //Si la persona es administrador, tiene acceso a todos los proyectos.
                    if(strcmp($persona->getRol(),"ROLE_ADMIN") == 0){

                        $proyectos = $this->getDoctrine()->getRepository(Proyecto::class)->findAll();
                        return $this->render('default/proyectos.html.twig',array('proyectos' => $proyectos, 'form' => $form->createView()));

                        //De lo contrario, solo tiene acceso a los proyectos que participe, ya sea como director, representante o trabajador comun.
                    }elseif(strcmp($persona->getRol(),"ROLE_USER") == 0){

                        //Obteniendo todos los proyectos en que el usuario es director.
                        $proyectosDirector = $this->getDoctrine()->getRepository(Proyecto::class)->findByRutDirector($persona);

                        //Obteniendo todos los proyectos en que el usuario es representante.
                        $proyectosRepresentante = $this->getDoctrine()->getRepository(Proyecto::class)->findByRutRepresentante($persona);

                        //Obteniendo todos los proyectos en que el usuario es trabajador comun.
                        $proyectosTrabajador = $this->getDoctrine()->getRepository(ProyectoTrabajador::class)->findByRutTrabajador($persona);

                        //Se guardan todos los proyectos en que participa en una sola lista.
                        $proyectos = array_merge($proyectosDirector,$proyectosRepresentante,$proyectosTrabajador);

                        return $this->render('default/proyectos.html.twig',array('proyectos' => $proyectos, 'form' => $form->createView()));

                    }

                }

            }

        }

        return new Response("<html><body><h1>NO EXISTE EL USUARIO</h1></body></html>");

    }


    /**
     * @Route("/proyectos/detalle/{id_proyecto}", name="detalle_proyecto")
     *
     */
    public function verProyecto(Request $request, $id_proyecto){

        $proyecto = $this->getDoctrine()
                            ->getRepository(Proyecto::class)
                            ->findOneBy(array(
                                'id' => $id_proyecto
                            ));


        $archivos = $this->getDoctrine()
                            ->getRepository(Archivo::class)
                            ->findArchivosByProyectoId($id_proyecto);
        return $this->render('default/proyecto.html.twig', array(
            'proyecto'=>$proyecto,
            'archivos'=>$archivos
        ));
    }


}