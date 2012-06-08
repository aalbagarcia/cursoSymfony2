<?php

namespace Cursosf2\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Cursosf2\UsuariosBundle\Entity\Usuario
 *
 * @ORM\Table(name="Cursosf2_Usuario")
 * @ORM\Entity(repositoryClass="Cursosf2\UsuariosBundle\Entity\UsuarioRepository")
 * @DoctrineAssert\UniqueEntity(fields= {"email"})
 * @Assert\Callback(methods={"tienePalabrasProhibidas"})
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
     * @Assert\MinLength(limit=8, message = "La contraseña de tener {{ limit }} caracteres")
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

    /**
     *
     * @var \Symfony\Component\HttpFoundation\File\File
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     *     mimeTypesMessage = "Subir una foto en jpg o png"
     * )
     */
    public $foto;



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

    public function tienePalabrasProhibidas(\Symfony\Component\Validator\ExecutionContext $context)
    {
        $nombre_propiedad = $context->getPropertyPath() . '.nombre';
        $dni = $this->getNombre();
        $palabras = array('restaurante', 'hotel', 'bar', 'cafeteria');
        if (1 === preg_match('/('.implode('|', $palabras).')/i', $dni)) {
            $context->setPropertyPath($nombre_propiedad);
            $context->addViolation('El nombre no puede contener las palabras '.implode(',',$palabras), array(), null);
        }

    }

    /**
     * Obtiene la foto del usuario
     *
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Fija la foto del usuario
     *
     * @param File $file
     */
    public function setFoto(\Symfony\Component\HttpFoundation\File\File $file)
    {
        $this->foto = $file;
    }

    //---------------------- File methods ----------------------
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/usuarios/fotosperfil';
    }

    public function upload()
    {
        // Si el campo foto no es obligatoria, esta propiedad puede estar vacía
        if (null === $this->foto) {
            return;
        }

        // TODO: No utilizar el nombre original del fichero

        $this->foto->move($this->getUploadRootDir(), $this->foto->getClientOriginalName());
        $this->path = $this->foto->getClientOriginalName();

        $this->foto = null;
    }
}
