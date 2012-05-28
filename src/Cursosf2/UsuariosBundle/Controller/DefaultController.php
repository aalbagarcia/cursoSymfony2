<?php

namespace Cursosf2\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('Cursosf2UsuariosBundle:Default:index.html.twig', array('name' => $name));
    }
}
