<?php

namespace BackendBundle\Entity;

/**
 * Aplicacion
 */
class Aplicacion
{
    /**
     * @var integer
     */
    private $idapll;

    /**
     * @var string
     */
    private $descripcionApl;

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var string
     */
    private $estado;


    /**
     * Get idapll
     *
     * @return integer
     */
    public function getIdapll()
    {
        return $this->idapll;
    }

    /**
     * Set descripcionApl
     *
     * @param string $descripcionApl
     *
     * @return Aplicacion
     */
    public function setDescripcionApl($descripcionApl)
    {
        $this->descripcionApl = $descripcionApl;

        return $this;
    }

    /**
     * Get descripcionApl
     *
     * @return string
     */
    public function getDescripcionApl()
    {
        return $this->descripcionApl;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Aplicacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Aplicacion
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
     * @var string
     */
    private $temp;


    /**
     * Set temp
     *
     * @param string $temp
     *
     * @return Aplicacion
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * Get temp
     *
     * @return string
     */
    public function getTemp()
    {
        return $this->temp;
    }
}
