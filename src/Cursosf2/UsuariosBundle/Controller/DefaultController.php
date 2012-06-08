<?php

namespace Cursosf2\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cursosf2\UsuariosBundle\Entity\Usuario;
use Cursosf2\UsuariosBundle\Form\Frontend\UsuarioType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{

    /**
     * Acción que muestra los grupos de los que un usuario es miembro.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gruposAction() {

        $em = $this->getDoctrine()->getEntityManager();
        $usuario = $this->get('security.context')->getToken()->getUser();
        $grupos = $em->getRepository('Cursosf2UsuariosBundle:Usuario')->findTodosLosGrupos($usuario->getId());

        return $this->render('Cursosf2UsuariosBundle:Default:grupos.html.twig', array('grupos' => $grupos));
    }

    /**
     * Acción que autentica el usuario
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        if($this->get('security.context')->isGranted('ROLE_USUARIO')) {
            return $this->redirect($this->generateUrl('Cursosf2UsuariosBundle_grupos'));
        }
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();
        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );
        return $this->render('Cursosf2UsuariosBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }

    /**
     * Muestra y procesa el formulario de registro.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registroAction() {

        $usuario = new Usuario();
        $formulario = $this->createForm(new UsuarioType(), $usuario);

        $request = $this->getRequest();
        if($request->getMethod() == 'POST') {
            //Procesamos el formulario
            $formulario->bindRequest($request);
            if ($formulario->isValid()) {
                // guardar la información en la base de datos
                $encoder = $this->get('security.encoder_factory')
                    ->getEncoder($usuario);
                $usuario->setSalt(md5(time()));
                $passwordCodificado = $encoder->encodePassword(
                    $usuario->getPassword(),
                    $usuario->getSalt()
                );
                $usuario->setPassword($passwordCodificado);
                $usuario->setSlug($usuario->getNombre().time().rand(1,10));
                $usuario->setFechaAlta(new \DateTime('now'));
                $em = $this->getDoctrine()->getEntityManager();

                $em->persist($usuario);
                $em->flush();
                $this->get('session')->setFlash('success',
                    '¡Enhorabuena! Te has registrado correctamente en Cursosf2'
                );
                $token = new UsernamePasswordToken(
                    $usuario,
                    $usuario->getPassword(),
                    'usuarios',
                    $usuario->getRoles()
                );
                $this->container->get('security.context')->setToken($token);
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render('Cursosf2UsuariosBundle:Default:registro.html.twig', array('formulario' => $formulario->createView()));
    }
}
