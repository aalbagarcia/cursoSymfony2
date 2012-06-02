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
namespace Cursosf2\ReunionesBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Cursosf2\ReunionesBundle\Entity\Reunion;
class ReunionRepositoryData implements  FixtureInterface
{
    const MAX_REUNIONES = 50;
    const MAX_DAYS = 100;
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager) {
        for($i = 0; $i < self::MAX_REUNIONES; $i++) {
            $reunion = new Reunion();
            $reunion->setNombre('REUNIÓN '.$i);
            $reunion->setFechaCreacion(new \DateTime('now'));
            $days = rand(10,self::MAX_DAYS);
            $reunion->setFechaReunion(new \DateTime('now + '.$days.' days'));
            //$reunion->setLugar($manager->merge($this->getReference('Geolocalizacion-'.rand(0,GeolocalizacionData::MAX_LOCATIONS - 1))));
            $reunion->setSlug('reunion-'.$i);
            //$reunion->setGrupo($manager->merge($this->getReference('Grupo-'.rand(0,GrupoData::MAX_GRUPOS - 1))));
            $manager->persist($reunion);
            $manager->flush();
        }
    }

}