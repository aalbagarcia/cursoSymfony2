<?php

namespace Cursosf2\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Cursosf2\UsuariosBundle\Entity\Usuario
 *
 * @ORM\Table(name="Cursosf2_Usuario")
 * @ORM\Entity(repositoryClass="Cursosf2\UsuariosBundle\Entity\UsuarioRepository")
 */
class Usuario implements UserInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string $apellidos
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var text $descripcion
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var datetime $fecha_alta
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fecha_alta;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $homeaddress
     *
     * @ORM\ManyToOne(targetEntity="\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion")
     * @ORM\JoinColumn(name="homeaddress_id", referencedColumnName="id")
     *
     **/
    private $homeaddress;

    /**
     * @var \Doctrine\Common\Collections\Collection $miembrode
     *
     * @ORM\OneToMany(targetEntity="\Cursosf2\GrupoBundle\Entity\Miembro", mappedBy="miembro")
     */
    protected $miembrode;

    /**
     * @var \Doctrine\Common\Collections\Collection $participaen
     *
     * @ORM\OneToMany(targetEntity="\Cursosf2\ReunionesBundle\Entity\Participante", mappedBy="usuario")
     */
    private $participaen;

    public function __construct() {
        $this->miembrode = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participaen = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set descripcion
     *
     * @param text $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return text 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set fecha_alta
     *
     * @param datetime $fechaAlta
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fecha_alta = $fechaAlta;
    }

    /**
     * Get fecha_alta
     *
     * @return datetime 
     */
    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Devuelve la dirección homeaddress del usuario
     *
     * @return \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion
     */
    public function getHomeaddress() {
        return $this->homeaddress;
    }

    /**
     * Fija la homeaddress del usuario
     *
     * @param \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $homeaddress
     */
    public function setHomeaddress(\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $homeaddress) {
        $this->homeaddress = $homeaddress;
    }


    /**
     * Obtiene los miembros de un usuario, es decir, los objetos miembro a los que el pertenece el usuario. A partir
     * de estos objetos podemos sacar el grupo.
     *
     * @return  \Doctrine\Common\Collections\Collection
     */
    public function getMiembrode() {

        return $this->miembrode;
    }

    /**
     * Obtiene las participaciones de un usuario, es decir, los objetos Participante a los que pertenece el usuario.
     * A partir de estos objetos podemos sacar la reunión.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipaen() {
        return $this->participaen;
    }

    /**
     * Devuelve la representación en cadeca de texto de un Usuario
     *
     * @return string
     */
    public function __toString() {
        return $this->nombre.' '.$this->apellidos;
    }

    public function equals(UserInterface $usuario)
    {
        return $this->getEmail() == $usuario->getEmail();
    }

    public function eraseCredentials()
    {
    }

    public function getRoles()
    {
        $roles = array();
        if($this->id == 1 ) {
            $roles[]='ROLE_ALLOWED_TO_SWITCH';
        }
        return array_merge($roles, array('ROLE_USUARIO'));
    }
    public function getUsername()
    {
        return $this->getEmail();
    }
}