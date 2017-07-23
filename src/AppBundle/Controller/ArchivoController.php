<?php
/**
 * Created by PhpStorm.
 * User: Hal9000
 * Date: 20/07/17
 * Time: 21:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Archivo;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Proyecto;
use AppBundle\Form\ArchivoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArchivoController extends Controller {

    /**
     * @Route("/registrar_archivo/{id_proyecto}", name="registrar_archivo")
     */
    public function registrarArchivo(Request $request, $id_proyecto){
        //(0) Obtener usuario de la sesión y proyecto del archivo
        $persona = $this->getUser();
        $proyecto = $this->getDoctrine()
            ->getRepository(Proyecto::class)
            ->findBy(array(
                "id"=>$id_proyecto
            ));
        //(1) Se crea el form
        $archivo = new Archivo();
        $form = $this->createForm(ArchivoType::class , $archivo);

        //(2) Handle submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Referenciar al proyecto al pertenece el archivo
            // y la persona que lo inserto.
            $file = $archivo->getDatos();
            $type = $file->getMimeType();
            $archivo->setIdProyecto($proyecto);
            $archivo->setRutPersona($persona);

            // 4) guardar el archivo
            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the archivo

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'registration/registrar_archivo.html.twig',
            array('form' => $form->createView())
        );
    }

}