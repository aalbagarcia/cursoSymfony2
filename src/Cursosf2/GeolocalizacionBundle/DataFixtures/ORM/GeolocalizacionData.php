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
namespace Cursosf2\GeolocalizacionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion;

class GeolocalizacionData implements FixtureInterface
{
    public function  load(ObjectManager $manager) {
        $geolocalizacion = new Geolocalizacion();
        $geolocalizacion->setCity('Madrid');
        $geolocalizacion->setLat(40.403562);
        $geolocalizacion->setLng(-3.786335);
        $geolocalizacion->setState('Madrid');
        $manager->persist($geolocalizacion);
        $manager->flush();
    }
}
