<?php

namespace Cursosf2\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{

    /**
     * Acción que muestra los grupos de los que un usuario es miembro.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function gruposAction() {
        $usuarioId = 1;
        $em = $this->getDoctrine()->getEntityManager();
        $grupos = $em->getRepository('Cursosf2UsuariosBundle:Usuario')->findTodosLosGrupos($usuarioId);

        return $this->render('Cursosf2UsuariosBundle:Default:grupos.html.twig', array('grupos' => $grupos, 'usuarioId' => $usuarioId));
    }

    /**
     * Acción que autentica el usuario
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
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
}
