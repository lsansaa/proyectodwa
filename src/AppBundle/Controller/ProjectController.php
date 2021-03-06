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
use AppBundle\Entity\ProyectoTrabajador;
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
            return $this->redirect('/');

        }

        return $this->render('public/nuevoproyecto.html.twig', array(
            'form' => $form->createView()
        ));

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


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT t FROM AppBundle:Persona t, AppBundle:ProyectoTrabajador pt WHERE pt.id_proyecto = :id and pt.rut_trabajador = t.rut')->setParameter('id',$id_proyecto);
        $trabajadores = $query->getResult();

        //$trabajadoresproyecto = $this->getDoctrine()->getRepository(ProyectoTrabajador::class)

        return $this->render('public/proyecto.html.twig', array(
            'proyecto'=>$proyecto,
            'archivos'=>$archivos,
            'trabajadores'=>$trabajadores
        ));
    }

}