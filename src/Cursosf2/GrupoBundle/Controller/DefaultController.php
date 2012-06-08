<?php
/**
 * This file is part of Cursosf2Application.
 *
 * Cursosf2Application is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Cursosf2Application is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Cursosf2Application.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Cursosf2\GrupoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;


class DefaultController extends Controller
{

    public function showAction($slug, $_format)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $grupo = $em->getRepository('Cursosf2GrupoBundle:Grupo')->findBySlugHydrated($slug);
        $context = $this->get('security.context');
        if (false === $context->isGranted('VIEW', $grupo))
        {
            throw new AccessDeniedException();
        }
        if(!$grupo)
        {
            $this->createNotFoundException('Grupo '.$slug.' desconocido.');
        };
        return $this->render('Cursosf2GrupoBundle:Default:show.'.$_format.'.twig', array('grupo' => $grupo));

    }

}
