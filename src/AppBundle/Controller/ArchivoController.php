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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ArchivoController extends Controller {

    /**
     * @Route("/registrar_archivo/{id_proyecto}", name="registrar_archivo")
     */
    public function registrarArchivo(Request $request, $id_proyecto){

        //(0) Obtener usuario de la sesión y proyecto del archivo
        $persona = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->find(array(
                "rut"=>$this->getUser()
            ));
        $proyecto = $this->getDoctrine()
            ->getRepository(Proyecto::class)
            ->find($id_proyecto);

        //(1) Se crea el form
        $archivo = new Archivo();
        $form = $this->createForm(ArchivoType::class , $archivo);

        //(2) Handle submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Referenciar al proyecto al que pertenece el archivo
            // y la persona que lo subio;
            $archivo->setIdProyecto($proyecto);
            $archivo->setRutPersona($persona);

            // 4) file guarda el archivo subido
            /** @var UploadedFile $file */
            $file = $archivo->getRuta();

            // 5) Guardar tipo del archivo

            $tipo = $file->getMimeType();

            // 6) Generar nombre del archivo unico

            $nombreArchivo = md5(uniqid()).'.'.$file->guessExtension();

            // 7) Mover el archivo al directorio donde se guardara

            $file->move(
                $this->getParameter('directorio_archivos'),
                $nombreArchivo
            );

            // 8) Actualizar ruta archivo

            $archivo->setRuta($nombreArchivo);


            $archivo->setTipo($tipo);

            // 9) guardar el archivo
            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the archivo

            return $this->redirectToRoute('detalle_proyecto',array(
                'id_proyecto' => $id_proyecto
            ));
        }

        return $this->render(
            'registration/registrar_archivo.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route ("/archivo/editar/", name="editar_archivo")
     *
     */
    public function verArchivo(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');
            $nombre = $request->request->get('nombre');
            $estado = $request->request->get('estado');

            $archivo = $this->getDoctrine()
                ->getRepository(Archivo::class)
                ->find($id);

            $archivo->setNombre($nombre);
            $archivo->setEstado($estado);

            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
            ));
            return $response;
        }

        $response = new JsonResponse(array(
            'message' => 'Invalid Request'),
            400);

        return $response;

    }

    /**
     * @Route ("/archivo/descargar/{id_archivo}", name="descargar_archivo")
     *
     */
    public function descargarArchivo(Request $request, $id_archivo){
        //0) Se obtiene el archivo con la id
        $archivo = $this->getDoctrine()
            ->getRepository(Archivo::class)
            ->find($id_archivo
            );

        $rutaArchivo = $this->getParameter('directorio_archivos').'/'.$archivo->getRuta();

        //$file = $this->file($rutaArchivo);

        $response = new BinaryFileResponse($rutaArchivo);
        $response->headers->set ( 'Content-Type', 'text/plain' );
        $response->setContentDisposition ( ResponseHeaderBag::DISPOSITION_ATTACHMENT, $archivo->getNombre() );
        return $response;
    }

    /**
     * @Route ("/archivo/eliminar/", name="eliminar_archivo")
     *
     */
    public function eliminarArchivo(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');

            $archivo = $this->getDoctrine()
                ->getRepository(Archivo::class)
                ->find($id);

            $archivo->setEstado("ELIMINADO");

            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'response' => 'success',
            ));
            return $response;
        }

        $response = new JsonResponse(array(
            'message' => 'Invalid Request'),
            400);

        return $response;

    }
}