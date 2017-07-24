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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


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
     * @Route ("/archivo/editar/{id_archivo}", name="editar_archivo")
     *
     */
    public function verArchivo(Request $request, $id_archivo)
    {
        //0) Se obtiene el archivo con la id
        $archivo = $this->getDoctrine()
            ->getRepository(Archivo::class)
            ->find($id_archivo
            );
        //1) se cargar el form sin DataClass
        $defaultData = array('default'=>'data');
        $form = $this->createFormBuilder($defaultData)
            ->add('nombre', TextType::class, array(
                'data'=> $archivo->getNombre()
            ))
            ->add('estado', ChoiceType::class, array(
                'choices'=> array(
                    'Seleccione un tipo de usuario' => null,
                    'Borrador' => 'BORRADOR',
                    'Publicado' => 'PUBLICADO'
                ),
                'data'=> $archivo->getEstado()
            ))
            ->getForm();
        //

        //(2) Handle submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) obtener datos del form

            $nombreArchivo = $form['nombre']->getData();
            $estadoArchivo = $form['estado']->getData();

            // 4) editar datos en archivo

            $archivo->setNombre($nombreArchivo);
            $archivo->setEstado($estadoArchivo);

            $em = $this->getDoctrine()->getManager();
            $em->persist($archivo);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the archivo

            return $this->redirectToRoute('editar_archivo', array(
                'id_archivo' => $id_archivo
            ));

        }
        return $this->render('default/archivo.html.twig', array(
            'archivo' => $archivo,'form' => $form->createView()
        ));
    }
}