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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserController extends Controller {

    /**
     * @Route("/usuarios/registro", name="user_registration")
     *
     */
    public function registrarUsuario(Request $request,UserPasswordEncoderInterface $encoder){

        //Condicion de entrada a la ruta. Solo pueden acceder usuarios que se hayan autenticado
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            throw $this->createAccessDeniedException();

        }

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
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/cambiar_contraseña", name="cambiar_contraseña")
     */
    public function cambiarContrasenia(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->find(array(
                "rut"=>$this->getUser()
            ));

        //1) se cargar el form sin DataClass
        $defaultData = array('default'=>'data');
        $form = $this->createFormBuilder($defaultData)
            ->add('old_password', PasswordType::class,
                array('label' => 'Actual contraseña'))
            ->add('new_password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'     => array('label' => 'Nueva contraseña'),
                'second_options'    => array('label' => 'Repita nueva Contraseña')
            ))
            ->getForm();
        //(2) Handle submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) verificar password)
//            $password = $form['old_password']->getData();
//            $factory = $this->get('security.encoder_factory');
//            $encoder = $factory->getEncoder($user);
//            $verificar = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
//            if($verificar){
//                $error = "Contraseña incorrecta, intente nuevamente";
//                return $this->render(
//                    'security/cambiar_contraseña.html.twig',
//                    array('form' => $form->createView(),
//                        'password_error' => $error)
//                );
//            }

            $noEncodePassword = $form['new_password']->getData();
            $newPassword = $encoder->encodePassword($user, $noEncodePassword);
            $user->setPassword($newPassword);

            // 4) guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('/');
        }

        return $this->render(
            'security/cambiar_contraseña.html.twig',
            array('form' => $form->createView())
        );
    }

}