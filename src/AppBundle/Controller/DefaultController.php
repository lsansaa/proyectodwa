<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Feed;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $usuario = $this->getUser();

        if(strcmp($usuario,"luis") == 0){

            $feed = new Feed();
            $form = $this->createFormBuilder($feed)->getForm();

            $feeds = $this->getDoctrine()->getRepository(Feed::class)->findAll();
            return $this->render('default/index.html.twig',array('feeds' => $feeds, 'form' => $form->createView()));

        }else{

            return new Response("<hml><h1>EN CONSTRUCCIÓN</h1></hml>");

        }

        return new Response("<hml><h1>EN CONSTRUCCIÓN</h1></hml>");

    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

}
