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
use Cursosf2\UsuariosBundle\Entity\Usuario;
use Cursosf2\GrupoBundle\Entity\Grupo;
use Cursosf2\GrupoBundle\Entity\Miembro;

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

        $grupo = $this->crearGrupo($random);
        $nombre = $grupo->getNombre();
        $nombreSede = $grupo->getSede()->getCity();

        $results = $this->em->getRepository('Cursosf2GrupoBundle:Grupo')->findBy(array('nombre' => $nombre));
        $this->assertCount(1, $results);
        $this->assertEquals($nombre, $results[0]->getNombre());
        $this->assertEquals($nombreSede, $results[0]->getSede()->getCity());
    }

    public function testMiembrosDeGrupo() {
        //Crear un grupo
        $random = rand(1,10000000);
        $grupo = $this->crearGrupo($random);
        $testGrupoId = $grupo->getId();
        //Crear n usuarios
        $numUsuarios = 3;
        $usuarios = $this->crearUsuarios($numUsuarios);

        //Almacenamos los nombres de usuario en la base de datos para testear que los usuarios se han guardado correctamente

        $testUserNames = array();
        //Asignar los usuarios al grupo
        foreach( $usuarios as $usuario ) {
            //Creamos un objeto Miembro
            $testUserNames[]=$usuario->getNombre();
            $miembro = new Miembro();
            $miembro->setFechaAlta(new \DateTime('now'));

            //Asignar el usuario al objeto miembro y viceversa
            $usuario->getMiembrode()->add($miembro);
            $miembro->setUsuario($usuario);

            //Asignar el grupo al objeto miembro y viceversa
            $grupo->getMiembros()->add($miembro);
            $miembro->setGrupo($grupo);


            $this->em->persist($miembro);
            $this->em->persist($usuario);
            $this->em->persist($grupo);
        }


        $this->em->flush();

        //Ahora buscamos el grupo, recuperamos los usuarios y confirmamos que son tres y que los nombres son
        //los que hemos almacenado en $testUserNames

        $grupo = null;

        $grupo = $this->em->find('Cursosf2\GrupoBundle\Entity\Grupo', $testGrupoId);

        $this->assertEquals(3, $grupo->getMiembros()->count(),'Recuperamos tres miembros');

        foreach($grupo->getMiembros() as $miembro) {
            $this->assertTrue(in_array($miembro->getUsuario()->getNombre(), $testUserNames), 'El usuario '.$miembro->getUsuario()->getNombre().' es miembro del grupo '.$grupo->getNombre());
        }
    }

    /**
     * Crea un grupo en BBDD y lo devuelve
     *
     * @param $random
     *
     * @return \Cursosf2\GrupoBundle\Entity\Grupo
     */
    private function crearGrupo($random) {
        $grupo = new Grupo();
        $nombre = 'GRUPO TEST '.$random;
        $grupo->setDescripcion('DESCRIPCIÓN '.$nombre);
        $grupo->setFechaCreacion(new \DateTime('now'));
        $grupo->setNombre($nombre);
        $grupo->setSlug('SLUG '.$nombre);

        $sede = new Geolocalizacion();
        $sede->setCity('CITY SEDE DE '.$nombre);
        $sede->setState('STATE SEDE DE '.$nombre);
        $sede->setLat(12.981);
        $sede->setLng(12.981);
        $grupo->setSede($sede);
        $this->em->persist($sede);
        $this->em->persist($grupo);
        $this->em->flush();

        return $grupo;
    }

    /**
     * Crea $n usuarios
     *
     * @param int $n
     * @return array
     */
    private function crearUsuarios($n = 1) {
        $usuarios = array();

        $random = rand(1,100000000);
        for($i=0; $i<$n; $i++) {
            $usuario = new Usuario();
            $usuario->setNombre("NOMBRE $i $random");
            $usuario->setApellidos("APELLIDOS $i $random");
            $usuario->setDescripcion("DESCRIPCION $i $random");
            $usuario->setSlug("SLUG_${i}_$random");
            $usuario->setFechaAlta(new \DateTime('now'));
            $usuario->setPassword("PASSWORD_${i}_$random");
            $usuario->setSalt("SALT_${i}_$random");
            $this->em->persist($usuario);
            $usuarios[]=$usuario;
        }
        $this->em->flush();
        return $usuarios;
    }
}
