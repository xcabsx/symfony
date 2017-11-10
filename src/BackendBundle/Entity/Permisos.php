<?php

namespace BackendBundle\Entity;

/**
 * Permisos
 */
class Permisos
{
    /**
     * @var integer
     */
    private $idPermiso;

    /**
     * @var string
     */
    private $descripPermiso;


    /**
     * Get idPermiso
     *
     * @return integer
     */
    public function getIdPermiso()
    {
        return $this->idPermiso;
    }

    /**
     * Set descripPermiso
     *
     * @param string $descripPermiso
     *
     * @return Permisos
     */
    public function setDescripPermiso($descripPermiso)
    {
        $this->descripPermiso = $descripPermiso;

        return $this;
    }

    /**
     * Get descripPermiso
     *
     * @return string
     */
    public function getDescripPermiso()
    {
        return $this->descripPermiso;
    }

    /**
     * @param int $idPermiso
     */

    /**
     * @var \DateTime
     */
    private $creado;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $estado;


    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Permisos
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Permisos
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Permisos
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
    private $nombrePermiso;


    /**
     * Set nombrePermiso
     *
     * @param string $nombrePermiso
     *
     * @return Permisos
     */
    public function setNombrePermiso($nombrePermiso)
    {
        $this->nombrePermiso = $nombrePermiso;

        return $this;
    }

    /**
     * Get nombrePermiso
     *
     * @return string
     */
    public function getNombrePermiso()
    {
        return $this->nombrePermiso;
    }
}
