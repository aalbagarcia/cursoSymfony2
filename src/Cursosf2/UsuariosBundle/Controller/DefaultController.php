<?php

namespace Cursosf2\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
}
