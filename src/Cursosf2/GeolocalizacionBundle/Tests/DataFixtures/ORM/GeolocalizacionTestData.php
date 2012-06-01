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
namespace Cursosf2\GeolocalizacionBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion;

class GeolocalizacionTestData implements \Doctrine\Common\DataFixtures\FixtureInterface
{
    public static $MAX_LOCATIONS = 10;
    public static $TEXT_PREFIX = 'FIXTURE TEST';
    public function  load(ObjectManager $manager) {
        for ($i=0; $i < self::$MAX_LOCATIONS ; $i++){
            $geolocalizacion = new Geolocalizacion();
            $geolocalizacion->setCity(self::$TEXT_PREFIX.' CIUDAD '.$i);
            $geolocalizacion->setLat(40.403562 + rand(-100, 100)/100);
            $geolocalizacion->setLng(-3.786335 + rand(-100, 100)/100);
            $geolocalizacion->setState(self::$TEXT_PREFIX.' STATE '.$i);

            $manager->persist($geolocalizacion);
        }
        $manager->flush();
    }
}
