<?php

namespace Cursosf2\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Cursosf2\UsuariosBundle\Entity\Usuario;

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

    public function registroAction() {

        $formulario = $this->createFormBuilder()->
            add('nombre')->
            add('apellidos')->
            add('descripcion','textarea')->
            add('contrasenha')->
            getForm();
        return $this->render('Cursosf2UsuariosBundle:Default:registro.html.twig', array('formulario' => $formulario->createView()));
    }
}
