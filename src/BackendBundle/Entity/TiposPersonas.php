<?php

namespace BackendBundle\Entity;

/**
 * TiposPersonas
 */
class TiposPersonas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $temporal;

    /**
     * @var string
     */
    private $promocion;


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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TiposPersonas
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return TiposPersonas
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
     * Set temporal
     *
     * @param string $temporal
     *
     * @return TiposPersonas
     */
    public function setTemporal($temporal)
    {
        $this->temporal = $temporal;

        return $this;
    }

    /**
     * Get temporal
     *
     * @return string
     */
    public function getTemporal()
    {
        return $this->temporal;
    }

    /**
     * Set promocion
     *
     * @param string $promocion
     *
     * @return TiposPersonas
     */
    public function setPromocion($promocion)
    {
        $this->promocion = $promocion;

        return $this;
    }

    /**
     * Get promocion
     *
     * @return string
     */
    public function getPromocion()
    {
        return $this->promocion;
    }
}

