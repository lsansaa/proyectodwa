<?php
/**
 * Created by PhpStorm.
 * User: Hal9000
 * Date: 06/08/17
 * Time: 13:28
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

class ChangePasswordController extends Controller
{
    /**
     * @Route("/usuarios/cambiar_contrasenia", name="cambiar_contrasenia")
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function cambiarContrasenia(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(Persona::class)
            ->find(array(
                "rut"=>$this->getUser()
            ));

        //1) se cargar el form sin DataClass
        $defaultData = array('public'=>'data');
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
            $password = $form['old_password']->getData();
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $verificar = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? "true" : "false";
            if(!$verificar){
                $error = "Contraseña incorrecta, intente nuevamente";
                return $this->render(
                    'security/cambiar_contrasenia.html.twig',
                    array('form' => $form->createView(),
                        'password_error' => $error)
                );
            }

            $noEncodePassword = $form['new_password']->get('first')->getData();
            $newPassword = $encoder->encodePassword($noEncodePassword, $user->getSalt());
            $user->setPassword($newPassword);

            // 4) guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('index');

        }

        return $this->render(
            'security/cambiar_contrasenia.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/public/recuperarcontrasenia", name="recuperar_contrasenia")
     */

}