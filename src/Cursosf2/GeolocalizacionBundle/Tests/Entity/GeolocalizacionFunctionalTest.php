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

namespace Cursosf2\GeolocalizacionBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion;
use Cursosf2\GeolocalizacionBundle\Tests\DataFixtures\ORM\GeolocalizacionTestData;
class GeolocalizacionFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $_application;
    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->_application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->_application->setAutoExit(false);
        $this->runConsole("doctrine:schema:drop", array("--force" => true));
        $this->runConsole("doctrine:schema:create");
        $this->runConsole("doctrine:fixtures:load", array("--fixtures" => __DIR__ . "/../DataFixtures", '--purge-with-truncate' => true));
    }

    protected function runConsole($command, Array $options = array()) {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->_application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }


    /**
     *
     * Testea creación de entidad Geolocalizacion
     *
     */
    public function testCrearGeolocalizacion()
    {
        $loc = new Geolocalizacion();

        $random = rand(1,100000);
        $timestamp = time();
        $city = "TEST_CITY_${timestamp}_$random";
        $state = "TEST_STATE_${timestamp}_$random";
        $loc->setCity($city);
        $loc->setLat(78.98717);
        $loc->setLng(-65.9890889);
        $loc->setState($state);
        $this->em->persist($loc);
        $this->em->flush();

        $results = $this->em->getRepository('\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion')->findBy(array('city' => $city, 'state' => $state));
        $this->assertCount(1, $results);
    }

    /**
     * Test sencillo para comprobar que los fixtures se cargan correctamente
     */
    public function testWithFixtures()
    {
        $results = $this->em->createQuery("SELECT g from Cursosf2GeolocalizacionBundle:Geolocalizacion g WHERE g.city LIKE :city")->
                                setParameter('city',GeolocalizacionTestData::$TEXT_PREFIX.'%')->
                                getResult();
        $this->assertCount(GeolocalizacionTestData::$MAX_LOCATIONS, $results);
    }
}
