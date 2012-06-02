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

use Cursosf2\ReunionesBundle\Entity\Reunion;
use Cursosf2\GeolocalizacionBundle\DataFixtures\ORM\GeolocalizacionData;
use Cursosf2\ReunionesBundle\Entity\Participante;
use Cursosf2\UsuariosBundle\DataFixtures\ORM\UsuarioData;
use Cursosf2\GrupoBundle\DataFixtures\ORM\GrupoData;
class ReunionData  extends AbstractFixture implements OrderedFixtureInterface
{
    const MAX_REUNIONES = 50;
    const MAX_PARTICIPANTES_POR_REUNION = 20;

    public function  load(ObjectManager $manager) {
        for($i = 0; $i < self::MAX_REUNIONES; $i++) {
            $reunion = new Reunion();
            $reunion->setNombre('REUNIÓN '.$i);
            $reunion->setFechaCreacion(new \DateTime('now'));
            $days = rand(10,100);
            $reunion->setFechaReunion(new \DateTime('now + '.$days.' days'));
            $reunion->setLugar($manager->merge($this->getReference('Geolocalizacion-'.rand(0,GeolocalizacionData::MAX_LOCATIONS - 1))));
            $reunion->setSlug('reunion-'.$i);
            $reunion->setGrupo($manager->merge($this->getReference('Grupo-'.rand(0,GrupoData::MAX_GRUPOS - 1))));
            $manager->persist($reunion);
            $manager->flush();
            //Añadimos los participantes

            $participantes = array();
            for ($j = 0; $j < self::MAX_PARTICIPANTES_POR_REUNION; $j++) {

                $participante = new Participante();
                $interval = new \DateInterval('P'.rand(1,$days).'D');
                $participante->setFechaAlta( $reunion->getFechaCreacion()->add($interval));
                $participante->setRsvp(rand(1,3));
                $participante->setReunion($reunion);

                do {
                    $usuario = $manager->merge($this->getReference('Usuario-'.rand(0,UsuarioData::MAX_USUARIOS - 1)));
                } while(in_array($usuario->getId(), $participantes));
                $usuario->getParticipaen()->add($participante);
                $participante->setUsuario($usuario);
                $manager->persist($usuario);
                $manager->persist($participante);
                $participantes[]=$usuario->getId();
            }



        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
