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

namespace Cursosf2\GrupoBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * GrupoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GrupoRepository extends EntityRepository
{

    /**
     * Devuelve el grupo cuyo slug es $slug con todos los objetos hidratados
     *
     * @param $slug
     * @return mixed
     */
    public function findBySlugHydrated($slug)
    {
        $query = '
            SELECT g,r,m,u FROM Cursosf2GrupoBundle:Grupo g
            LEFT JOIN g.reuniones r
            LEFT JOIN g.miembros m
            LEFT JOIN m.usuario u
            WHERE g.slug LIKE :slug
        ';
        return $this->getEntityManager()->createQuery($query)->setMaxResults(1)->setParameter('slug', $slug)->getSingleResult();

    }
}