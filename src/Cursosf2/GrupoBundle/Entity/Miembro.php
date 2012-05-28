<?php

namespace Cursosf2\GrupoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cursosf2\GrupoBundle\Entity\Miembro
 *
 * @ORM\Table(name="Cursosf2_Miembro")
 * @ORM\Entity(repositoryClass="Cursosf2\GrupoBundle\Entity\MiembroRepository")
 */
class Miembro
{
    /**
     * @var integer $grupo
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Cursosf2\GrupoBundle\Entity\Grupo")
     * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
     */
    private $grupo;
    /**
     * @var integer $usuario
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\Cursosf2\UsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * @var datetime $fecha_alta
     *
     * @ORM\Column(name="fecha_alta", type="datetime")
     */
    private $fecha_alta;


    /**
     * Get grupo
     *
     * @return integer 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set grupo
     *
     * @param \Cursosf2\GrupoBundle\Entity\Grupo $grupo
     */
    public function setGrupo(\Cursosf2\GrupoBundle\Entity\Grupo $grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get usuario
     *
     * @return \Cursosf2\UsuariosBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario(\Cursosf2\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
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