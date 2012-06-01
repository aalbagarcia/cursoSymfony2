<?php

namespace Cursosf2\ReunionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\ReunionesBundle\Entity\Reunion
 *
 * @ORM\Table()
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
     * @return datetime 
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
}