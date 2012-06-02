<?php

namespace Cursosf2\ReunionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\ReunionesBundle\Entity\Reunion
 *
 * @ORM\Table(name="Cursosf2_Reunion")
 * @ORM\Entity(repositoryClass="Cursosf2\ReunionesBundle\Entity\ReunionRepository")
 */
class Reunion
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
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var datetime $fecha_creacion
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     */
    private $fecha_creacion;

    /**
     * @var datetime $fecha_reunion
     *
     * @ORM\Column(name="fecha_reunion", type="datetime")
     */
    private $fecha_reunion;

    /**
     * @var \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion  $lugar
     * @ORM\ManyToOne(targetEntity="\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion")
     * @ORM\JoinColumn(name="lugar_id", referencedColumnName="id")
     */
    private $lugar;

    /**
     * @var \Cursosf2\GrupoBundle\Entity\Grupo $grupo
     *
     * @ORM\ManyToOne(targetEntity="\Cursosf2\GrupoBundle\Entity\Grupo", inversedBy="reuniones")
     * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $grupo;

    /**
     * @var \Doctrine\Common\Collections\Collection $participantes
     *
     * @ORM\OneToMany(targetEntity="\Cursosf2\ReunionesBundle\Entity\Participante", mappedBy="participante")
     */
    private $participantes;


    public function __construct() {
        $this->participantes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set fecha_reunion
     *
     * @param datetime $fechaReunion
     */
    public function setFechaReunion($fechaReunion)
    {
        $this->fecha_reunion = $fechaReunion;
    }

    /**
     * Get fecha_reunion
     *
     * @return datetime 
     */
    public function getFechaReunion()
    {
        return $this->fecha_reunion;
    }

    /**
     * Devuelve el lugar de la reunión
     *
     * @return \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion
     */
    public function getLugar() {
        return $this->lugar;
    }

    /**
     * Fija el lugar de la reunión
     *
     * @param \Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $lugar
     */
    public function setLugar(\Cursosf2\GeolocalizacionBundle\Entity\Geolocalizacion $lugar) {
        $this->lugar = $lugar;
    }

    /**
     * Get grupo
     *
     * @return \Cursosf2\GrupoBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Asigna el grupo
     *
     * @param \Cursosf2\GrupoBundle\Entity\Grupo $grupo
     */
    public function setGrupo(\Cursosf2\GrupoBundle\Entity\Grupo $grupo) {
        $this->grupo = $grupo;
    }
    /**
     * Devuelve los participantes de una reunión
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipantes() {
        return $this->participantes;
    }
}