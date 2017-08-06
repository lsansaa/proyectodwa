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
use AppBundle\Form\ProyectoTrabajadorType;
use Distill\Format\Simple\Ar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ProyectoTrabajadorController extends Controller {

    /**
     * @Route("/proyectos/asignartrabajador/{id_proyecto}", name="asignar_trabajador")
     *
     */
    public function asignarTrabajador(Request $request, $id_proyecto){

        $proyectotrabajador = new ProyectoTrabajador();
        $form = $this->createFormBuilder($proyectotrabajador)->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            $idproyecto = $request->request->get('idproyecto');
            $ruttrabajador = $request->request->get('ruttrabajador');

            $query = $em->createQuery('SELECT p FROM AppBundle:Proyecto p WHERE p.id = :id')->setParameter('id',$idproyecto);
            $objeto = $query->getResult();
            $proyecto = $objeto[0];

            $query = $em->createQuery('SELECT t FROM AppBundle:Persona t WHERE t.rut = :rut')->setParameter('rut',$ruttrabajador);
            $objeto = $query->getResult();
            $trabajador = $objeto[0];

            $proyectotrabajador = new ProyectoTrabajador();
            $proyectotrabajador->setIdProyecto($proyecto);
            $proyectotrabajador->setRutTrabajador($trabajador);

            $em->persist($proyectotrabajador);
            $em->flush();
            return $this->redirect('/');

        }

        $em = $this->getDoctrine()->getManager();
        $query = 'SELECT * FROM Persona p WHERE (SELECT COUNT(*) FROM Proyecto_Trabajador pt WHERE pt.id_proyecto = :id and pt.rut_trabajador = p.rut) = 0 and p.rol = :rol';
        $statement = $em->getConnection()->prepare($query);
        $statement->bindValue('id',$id_proyecto);
        $rol = 'ROLE_USER';
        $statement->bindValue('rol',$rol);
        $statement->execute();

        $trabajadorestemp = $statement->fetchAll();
        $trabajadores = array();

        foreach ($trabajadorestemp as $t){

            array_push($trabajadores,$t);

        }

        return $this->render('default/asignaciontrabajador.html.twig', array(

            'trabajadores' => $trabajadores,
            'idproyecto' => $id_proyecto,
            'form' => $form->createView()

        ));

    }
}