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
use Doctrine\ORM\Query\ResultSetMapping;

class ProyectoTrabajadorController extends Controller {

    /**
     * @Route("/proyectos/asignartrabajador/{id_proyecto}", name="asignar_trabajador")
     *
     */
    public function asignarTrabajador(Request $request, $id_proyecto){

        //Condicion de entrada a la ruta. Solo pueden acceder usuarios que se hayan autenticado
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            throw $this->createAccessDeniedException();

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
            'idproyecto' => $id_proyecto

        ));

    }

    /**
     * @Route("/proyectos/asignartrabajador/{id_proyecto}/{rut_trabajador}", name="asignar_trabajador2")
     *
     */
    public function asignarTrabajador2(Request $request, $id_proyecto, $rut_trabajador){

        //Condicion de entrada a la ruta. Solo pueden acceder usuarios que se hayan autenticado
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            throw $this->createAccessDeniedException();

        }

        return new Response("<html><body><h1>Hola</h1></body></html>");

    }

}