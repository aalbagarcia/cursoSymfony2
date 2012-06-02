<?php

namespace Cursosf2\ReunionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\ReunionesBundle\Entity\Participante
 *
 * @ORM\Table(name="Cursosf2_Participante")
 * @ORM\Entity(repositoryClass="Cursosf2\ReunionesBundle\Entity\ParticipanteRepository")
 */
class Participante
{
    const RSVP_SIN_CONFIRMAR = 0;
    const RSVP_ASISTE = 1;
    const RSVP_NO_ASISTE = 2;
    const RSVP_QUIZAS_ASISTE = 3;

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
     * @var \Cursosf2\ReunionesBundle\Entity\Reunion $reunion
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Cursosf2\ReunionesBundle\Entity\Reunion", inversedBy="participantes")
     * @ORM\JoinColumn(name="reunion_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $reunion;


    /**
     * @var \Cursosf2\UsuariosBundle\Entity\Usuario $usuario
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Cursosf2\UsuariosBundle\Entity\Usuario", inversedBy="partipaen")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $usuario;

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

    /**
     * Asigna la reunión
     *
     * @return \Cursosf2\ReunionesBundle\Entity\Reunion
     */
    public function getReunion() {
        return $this->reunion();
    }

    /**
     * Devuelve la reunión
     *
     * @param \Cursosf2\ReunionesBundle\Entity\Reunion  $reunion
     */
    public function setReunion(\Cursosf2\ReunionesBundle\Entity\Reunion $reunion) {
        $this->reunion = $reunion;
    }

    /**
     * Devuelve el usuario participante
     *
     * @return \Cursosf2\UsuariosBundle\Entity\Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * Asigna el usuario participante
     *
     * @param \Cursosf2\UsuariosBundle\Entity\Usuario $usuario
     * @return \Cursosf2\UsuariosBundle\Entity\Usuario
     */
    public function setUsuario(\Cursosf2\UsuariosBundle\Entity\Usuario $usuario) {
        return $this->usuario = $usuario;
    }
}