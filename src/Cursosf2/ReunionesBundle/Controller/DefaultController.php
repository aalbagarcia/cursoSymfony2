<?php

namespace Cursosf2\ReunionesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('Cursosf2ReunionesBundle:Default:index.html.twig', array('name' => $name));
    }
}
