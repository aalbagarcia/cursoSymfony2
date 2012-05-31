<?php


namespace Cursosf2\StaticBundle\Controller;

/**
 * This file is part of Cursosf2Application.
 *
 * Cursosf2Application is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Foobar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Cursosf2Application.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<?php


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{

    /**
     * Muestra la portada de la página
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepageAction()
    {
        //return new \Symfony\Component\HttpFoundation\Response('Portada del Curso de Symfony2');
        return $this->render('Cursosf2StaticBundle:Default:homepage.html.twig');
    }

    /**
     * Muestra el contenido estático del sitio web
     *
     * @param $pagina
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sitioAction($pagina) {
        return $this->render('Cursosf2StaticBundle:Default:'.$pagina.'.html.twig');
    }

}
