<?php

namespace Cursosf2\GrupoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\GrupoBundle\Entity\Grupo
 *
 * @ORM\Table(name="Cursosf2_Grupo")
 * @ORM\Entity(repositoryClass="Cursosf2\GrupoBundle\Entity\GrupoRepository")
 */
class Grupo
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
     * @var text $descripcion
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, unique="true")
     */
    private $slug;

    /**
     * @var datetime $fecha_creacion
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fecha_creacion;

    /**
     * @var string $foto
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    private $foto;


    /**
     * @ORM\ManyToOne(targetEntity="\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion")
     * @ORM\JoinColumn(name="sede_id", referencedColumnName="id")
     **/
    private $sede;

    /**
     * @var \Doctrine\Common\Collections\Collection $miembros
     *
     * @ORM\OneToMany(targetEntity="\Cursosf2\GrupoBundle\Entity\Miembro", mappedBy="miembro")
     */
    private $miembros;


    public function __construct() {
        $this->miembros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reuniones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @var \Doctrine\Common\Collections\Collection $reuniones
     *
     * @ORM\OneToMany(targetEntity="\Cursosf2\ReunionesBundle\Entity\Reunion", mappedBy="reunion")
     */
    private $reuniones;

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
     * Set fecha_creacion
     *
     * @param datetime $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fecha_creacion = $fechaCreacion;
    }

    /**
     * Get fecha_creacion
     *
     * @return datetime 
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }


    /**
     * Devuelve la ruta relativa a la foto.
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }


    /**
     * Asigna la ruta relativa de la foto.
     * @param $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    /**
     * Devuelve la sede del grupo
     *
     * @return \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion
     */
    public function getSede() {
        return $this->sede;
    }

    /**
     * Fija la sede del grupo
     *
     * @param \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $sede
     */
    public function setSede(\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $sede) {
        $this->sede = $sede;
    }

    /**
     * Obtiene los miembros de un grupo
     *
     * @return  \Doctrine\Common\Collections\Collection
     */
    public function getMiembros() {
        return $this->miembros;
    }

    /**
     * Obtiene las reuniones de un grupo
     *
     * @return  \Doctrine\Common\Collections\Collection
     */
    public function getReuniones() {
        return $this->reuniones;
    }

    /**
     * Añade un usuario al grupo creando la correspondiente entrada en la tabla Miembro
     *
     * @param \Cursosf2\UsuariosBundle\Entity\Usuario $usuario
     * @param DateTime $fechaAlta
     *
     * @return \Cursosf2\GrupoBundle\Entity\Miembro
     */
    public function getUsuarioComoMiembro(\Cursosf2\UsuariosBundle\Entity\Usuario $usuario, \DateTime $fechaAlta = null) {
        $miembro = new Miembro();
        $miembro->setGrupo($this);
        $miembro->setUsuario($usuario);
        if(!$fechaAlta) {
            $miembro->setFechaAlta(new \DateTime('now'));
        } else {
            $miembro->setFechaAlta($fechaAlta);
        }
        $usuario->getMiembrode()->add($miembro);
        $this->miembros->add($miembro);
        return $miembro;
    }
}