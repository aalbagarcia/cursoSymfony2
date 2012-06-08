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
namespace Cursosf2\GrupoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Cursosf2\GrupoBundle\Entity\Grupo;
use Cursosf2\GeolocalizacionBundle\DataFixtures\ORM\GeolocalizacionData;

class GrupoData extends AbstractFixture implements OrderedFixtureInterface
{
    const MAX_GRUPOS = 5;
    public function  load(ObjectManager $manager) {
        for ($i=0; $i < self::MAX_GRUPOS ; $i++) {
            $grupo = new Grupo();
            $grupo->setDescripcion('DESCRIPCIÓN '.$i);
            $grupo->setNombre("GRUPO $i");
            $grupo->setSlug("grupo-$i");
            $grupo->setFechaCreacion(new \DateTime('now - '.$i*rand(1,100).' days'));

            $this->addReference('Grupo-'.$i, $grupo);

            $grupo->setSede($manager->merge($this->getReference('Geolocalizacion-'.rand(0,GeolocalizacionData::MAX_LOCATIONS - 1))));
            $manager->persist($grupo);
        }
        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }
}
