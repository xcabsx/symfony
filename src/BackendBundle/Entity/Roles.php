<?php

namespace BackendBundle\Entity;

/**
 * Roles
 */
class Roles
{
    /**
     * @var integer
     */
    private $rolId;

    /**
     * @var string
     */
    private $descRol;


    /**
     * Get rolId
     *
     * @return integer
     */
    public function getRolId()
    {
        return $this->rolId;
    }

    /**
     * Set descRol
     *
     * @param string $descRol
     *
     * @return Roles
     */
    public function setDescRol($descRol)
    {
        $this->descRol = $descRol;

        return $this;
    }

    /**
     * Get descRol
     *
     * @return string
     */
    public function getDescRol()
    {
        return $this->descRol;
    }
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
     * @return Roles
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
     * @return Roles
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
     * @return Roles
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
}
