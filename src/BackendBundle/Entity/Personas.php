<?php

namespace BackendBundle\Entity;

/**
 * Personas
 */
class Personas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $dni;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido;

    /**
     * @var string
     */
    private $cuilCuit;

    /**
     * @var \DateTime
     */
    private $fechaNacimiento;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var \DateTime
     */
    private $fechaAlta;

    /**
     * @var integer
     */
    private $fechaBaja;

    /**
     * @var \BackendBundle\Entity\TiposPersonas
     */
    private $tipoPersona;


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
     * Set dni
     *
     * @param integer $dni
     *
     * @return Personas
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return integer
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Personas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Personas
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set cuilCuit
     *
     * @param string $cuilCuit
     *
     * @return Personas
     */
    public function setCuilCuit($cuilCuit)
    {
        $this->cuilCuit = $cuilCuit;

        return $this;
    }

    /**
     * Get cuilCuit
     *
     * @return string
     */
    public function getCuilCuit()
    {
        return $this->cuilCuit;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     *
     * @return Personas
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Personas
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return Personas
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param integer $fechaBaja
     *
     * @return Personas
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return integer
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set tipoPersona
     *
     * @param \BackendBundle\Entity\TiposPersonas $tipoPersona
     *
     * @return Personas
     */
    public function setTipoPersona(\BackendBundle\Entity\TiposPersonas $tipoPersona = null)
    {
        $this->tipoPersona = $tipoPersona;

        return $this;
    }

    /**
     * Get tipoPersona
     *
     * @return \BackendBundle\Entity\TiposPersonas
     */
    public function getTipoPersona()
    {
        return $this->tipoPersona;
    }
}
