<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Feed;
use AppBundle\Entity\Proyecto;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $feed = new Feed();
        $form = $this->createFormBuilder($feed)->getForm();
        $persona = $this->getUser();

        //Redirecciona si se cerró la sesión.
        if(is_null($persona)){

            return $this->redirect('/login');

        }

        if(strcmp($persona->getRol(),"ROLE_ADMIN") == 0){

            $proyectos = $this->getDoctrine()->getRepository(Proyecto::class)->findAll();
            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findAll();
            return $this->render('default/index.html.twig',array('feeds'=>$feeds,'form'=>$form->createView(),'proyectos'=>$proyectos));

        }

        if(strcmp($persona->getRol(),"ROLE_USER") == 0){

            $em = $this->getDoctrine()->getManager();

            $query1 = $em->createQuery('SELECT p FROM AppBundle:Proyecto p WHERE p.rut_director = :rut OR p.rut_representante = :rut')->setParameter('rut',$persona->getRut());
            $proyectos1 = $query1->getResult();

            $query2 = $em->createQuery('SELECT p FROM AppBundle:Proyecto p, AppBundle:ProyectoTrabajador pt WHERE pt.id_proyecto = p.id and pt.rut_trabajador = :rut')->setParameter('rut',$persona->getRut());
            $proyectos2 = $query2->getResult();

            $proyectos = array_merge($proyectos1,$proyectos2);

            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findBy(array('rut_usuario' => $persona->getRut()));
            return $this->render('default/index.html.twig',array('feeds'=>$feeds,'form'=>$form->createView(),'proyectos'=>$proyectos));

        }

        return new Response("<html><h1>EN CONSTRUCCIÓN</h1></html>");

    }

}
