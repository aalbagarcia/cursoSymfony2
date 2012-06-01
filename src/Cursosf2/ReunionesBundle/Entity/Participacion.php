<?php

namespace Cursosf2\ReunionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\ReunionesBundle\Entity\Participacion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cursosf2\ReunionesBundle\Entity\ParticipacionRepository")
 */
class Participacion
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
     * @var integer $rsvp
     *
     * @ORM\Column(name="rsvp", type="integer")
     */
    private $rsvp;

    /**
     * @var datetime $fecha_alta
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fecha_alta;


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
     * Set rsvp
     *
     * @param integer $rsvp
     */
    public function setRsvp($rsvp)
    {
        $this->rsvp = $rsvp;
    }

    /**
     * Get rsvp
     *
     * @return integer 
     */
    public function getRsvp()
    {
        return $this->rsvp;
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
}