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
namespace Cursosf2\ReunionesBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Cursosf2\ReunionesBundle\Tests\DataFixtures\ORM\ReunionRepositoryData;

class ReunionRepositoryTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Bundle\FrameworkBundle\Console\Application
     */
    protected $_application;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->_application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $this->_application->setAutoExit(false);
        $this->runConsole("doctrine:schema:drop", array("--force" => true));
        $this->runConsole("doctrine:schema:create");
        $this->runConsole("doctrine:fixtures:load", array("--fixtures" => __DIR__ . "/../DataFixtures", '--purge-with-truncate' => true));
    }

    protected function runConsole($command, Array $options = array())
    {
        $options["-e"] = "test";
        $options["-q"] = null;
        $options = array_merge($options, array('command' => $command));
        return $this->_application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    public function testFindProximasReuniones()
    {
        //$repository = new \Cursosf2\ReunionesBundle\Entity\ReunionRepository();
        $repository = $this->em->getRepository('Cursosf2ReunionesBundle:Reunion');
        $results = $repository->findProximasReuniones();
        $this->assertCount(5, $results, 'Encontramos 5 reuniones en base de datos');
        $interval = new \DateInterval('P'.(ReunionRepositoryData::MAX_DAYS + 10).'D');
        $fecha = new \DateTime('now');
        $results = $repository->findProximasReuniones($fecha->add($interval));
        $this->assertCount(0, $results, 'Encontramos 0 reuniones en base de datos');
    }
}
