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
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
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
    const MAX_USUARIOS = 2;
    const MAX_GROUPS_PER_USER = 5;
    public function  load(ObjectManager $manager) {

        // Creando el usuario admin
        $admin = new Usuario();
        $admin->setNombre('ADMIN');
        $admin->setApellidos('ADMIN APELLIDOS');
        $admin->setFechaAlta(new \DateTime('now - '.(rand(0,100).' days')));

        $passwd = 'ADMIN';
        $salt = md5(time().rand(1,10000000000));
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($admin);
        $passwd = $encoder->encodePassword($passwd, $salt);
        $admin->setPassword($passwd);
        $admin->setSalt($salt);
        $admin->setDescripcion('DESCRIPCION ADMIN');
        $admin->setSlug('slug-admin');
        $admin->setEmail('admin@gmail.com');
        $admin->setHomeaddress($manager->merge($this->getReference('Geolocalizacion-0')));
        $manager->persist($admin);
        $manager->flush();


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

                //Añadimos las ACLs


                // Este método falla por un bug de symfony
                //$idObjeto  = ObjectIdentity::fromDomainObject($grupo);
                $className = ($grupo instanceof \Doctrine\ORM\Proxy\Proxy)
                    ? get_parent_class($grupo) : get_class($grupo);
                $idObjeto  = new ObjectIdentity($grupo->getId(), $className);
                $idUsuario = UserSecurityIdentity::fromAccount($usuario);

                //Borramos las ACLs que ya pudiesen existir en la base de datos

                $provider = $this->container->get('security.acl.provider');
                try{

                    //Si existen ACLS, no se genera excepción y buscamos las que ya existan
                    $acl = $provider->findAcl($idObjeto, array($idUsuario));
                } catch (\Symfony\Component\Security\Acl\Exception\AclNotFoundException $e) {
                    // Si no existen ACLs se genera excepción y las creamos
                    $acl = $provider->createAcl($idObjeto);
                }
                $aces = $acl->getObjectAces();
                foreach ($aces as $index => $ace) {
                    echo "aqui\n";
                    $acl->deleteObjectAce($index);
                }
                // FIN DEL BORRADO

                $acl->insertObjectAce($idUsuario, MaskBuilder::MASK_OPERATOR);
                $provider->updateAcl($acl);
            }

            $this->addReference('Usuario-'.$i, $usuario);

        }
        $manager->flush();
    }

    public function getOrder() {
        return 3;
    }
}
