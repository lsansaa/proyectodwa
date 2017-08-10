<?php
/**
 * Created by PhpStorm.
 * User: RodrigoPizarro
 * Date: 11-07-2017
 * Time: 16:06
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Persona;
use AppBundle\Form\PersonaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends Controller {



    /**
     * @Route("/usuarios/registro", name="user_registration")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function registrarUsuario(Request $request,UserPasswordEncoderInterface $encoder){

        //(1) Se crea el form
        $user = new Persona();
        $form = $this->createForm(PersonaType::class , $user);
        //(2) Handle submit
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //obtener RUT
            $rut = $user->getRut();
            //eliminar puntos, guiones y espacios
            $rutLimpio = preg_replace('/[.-]/', '', $rut);
            $rutLimpio = str_replace(' ','', $rutLimpio);
            //guardar rut
            $user->setRut($rutLimpio);
            // 3) codificar password)
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setisActive(true);
            $user->setRol("ROLE_USER");
            // 4) guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirect('/');

        }

        return $this->render(
            'registration/registrar_usuario.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/usuarios/editarroles", name="editar_roles")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editarRoles(Request $request){

        $trabajadoresTemp = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->findAll();
        $trabajadores = array();

        foreach ($trabajadoresTemp as $t){

            array_push($trabajadores,$t);

        }

        return $this->render('security/editar_roles.html.twig', array(

            'trabajadores' => $trabajadores

        ));

    }
    /**
     * @Route("/usuarios/editarrol", name="editar_rol")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editarRol(Request $request){

        if($request->isXmlHttpRequest())
        {
            $rut = $request->request->get('rut');
            $rol = $request->request->get('rol');

            $usuario = $this->getDoctrine()
                ->getRepository(Persona::class)
                ->find(array(
                    "rut"=>$rut
                ));

            $usuario->setRol($rol);

            // 4) guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
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