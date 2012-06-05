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
namespace Cursosf2\UsuariosBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Cursosf2\GrupoBundle\Entity\Grupo;
use Cursosf2\UsuariosBundle\Entity\Usuario;
use Cursosf2\GrupoBundle\DataFixtures\ORM\GrupoData;

class UsuarioData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    const MAX_USUARIOS = 20;
    const MAX_GROUPS_PER_USER = 5;
    public function  load(ObjectManager $manager) {
        for ($i=0; $i < self::MAX_USUARIOS ; $i++) {
            $usuario = new Usuario();
            $usuario->setNombre('NOMBRE '.$i);
            $usuario->setApellidos('APELLIDOS '.$i);
            $usuario->setFechaAlta(new \DateTime('now - '.(rand(0,100).' days')));

            $passwd = 'PASSWD'.$i;
            $salt = md5(time().rand(1,10000000000));
            $encoder = $this->container->get('security.encoder_factory')
                ->getEncoder($usuario);
            $passwd = $encoder->encodePassword($passwd, $salt);
            $usuario->setPassword($passwd);
            $usuario->setSalt($salt);
            $usuario->setDescripcion('DESCRIPCION '.$i);
            $usuario->setSlug('slug-'.$i);
            $usuario->setEmail('email-'.$i.'@gmail.com');
            $usuario->setHomeaddress($manager->merge($this->getReference('Geolocalizacion-'.$i)));
            $manager->persist($usuario);
            $manager->flush();

            $grupos = array();
            for($j = 0; $j < rand(1, self::MAX_GROUPS_PER_USER); $j++) {
                $miembro = new \Cursosf2\GrupoBundle\Entity\Miembro();
                do {
                    $grupo = $manager->merge($this->getReference('Grupo-'.rand(0,GrupoData::MAX_GRUPOS - 1)));
                } while (in_array($grupo->getId(),$grupos));
                $miembro->setGrupo($grupo);
                $miembro->setUsuario($usuario);
                $miembro->setFechaAlta(new \DateTime('now - '.rand(0,100).' days'));
                $manager->persist($miembro);
                $grupos[] = $grupo->getId();
            }

            $this->addReference('Usuario-'.$i, $usuario);

        }
        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }
}
