<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Feed;
use AppBundle\Entity\Proyecto;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $usuario = $this->getUser();
        //Acceso por medio de una credencial guardada en memoria. (No obtenida de la BD).
        if(strcmp($usuario,'luis') == 0){

            $feed = new Feed();
            $form = $this->createFormBuilder($feed)->getForm();

            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findAll();
            $proyectos = $this->getDoctrine()->getRepository(Proyecto::class)->findAll();
            return $this->render('default/index.html.twig',array(
                'feeds' => $feeds,
                'form' => $form->createView(),
                'proyectos' => $proyectos));


        }else{

            return new Response("<html><h1>EN CONSTRUCCIÓN</h1></html>");

        }

        return new Response("<html><h1>EN CONSTRUCCIÓN</h1></html>");

    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}
