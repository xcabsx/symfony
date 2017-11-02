<?php

namespace BackendBundle\Entity;

/**
 * AplicacionXRol
 */
class AplicacionXRol
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var \BackendBundle\Entity\Aplicacion
     */
    private $idapl;

    /**
     * @var \BackendBundle\Entity\Roles
     */
    private $idrol;


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
     * Set estado
     *
     * @param string $estado
     *
     * @return AplicacionXRol
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
     * Set idapl
     *
     * @param \BackendBundle\Entity\Aplicacion $idapl
     *
     * @return AplicacionXRol
     */
    public function setIdapl(\BackendBundle\Entity\Aplicacion $idapl = null)
    {
        $this->idapl = $idapl;

        return $this;
    }

    /**
     * Get idapl
     *
     * @return \BackendBundle\Entity\Aplicacion
     */
    public function getIdapl()
    {
        return $this->idapl;
    }

    /**
     * Set idrol
     *
     * @param \BackendBundle\Entity\Roles $idrol
     *
     * @return AplicacionXRol
     */
    public function setIdrol(\BackendBundle\Entity\Roles $idrol = null)
    {
        $this->idrol = $idrol;

        return $this;
    }

    /**
     * Get idrol
     *
     * @return \BackendBundle\Entity\Roles
     */
    public function getIdrol()
    {
        return $this->idrol;
    }
}
