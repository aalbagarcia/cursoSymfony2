<?php
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

namespace Cursosf2\GrupoBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion;
use Cursosf2\GrupoBundle\Entity\Grupo;

class GrupoFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     *
     * Testea creación de entidad Grupo
     *
     */
    public function testCrearGrupo()
    {
        $entity = new Grupo();
        $random = rand(1,1000000);
        $nombre = 'GRUPO TEST '.$random;
        $entity->setDescripcion('DESCRIPCIÓN');
        $entity->setFechaCreacion(new \DateTime('now'));
        $entity->setNombre($nombre);
        $entity->setSlug('SLUG '.$nombre);

        $sede = new Geolocalizacion();
        $sede->setCity('CITY SEDE DE '.$nombre);
        $sede->setState('STATE SEDE DE '.$nombre);
        $sede->setLat(12.981);
        $sede->setLng(12.981);
        $entity->setSede($sede);
        $this->em->persist($sede);
        $this->em->persist($entity);
        $this->em->flush();

        $results = $this->em->getRepository('Cursosf2GrupoBundle:Grupo')->findBy(array('nombre' => $nombre));
        $this->assertCount(1, $results);
        $this->assertEquals($nombre, $results[0]->getNombre());
        $this->assertEquals('CITY SEDE DE '.$nombre, $results[0]->getSede()->getCity());
    }
}
