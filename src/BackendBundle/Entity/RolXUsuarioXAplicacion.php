<?php

namespace BackendBundle\Entity;

/**
 * RolXUsuarioXAplicacion
 */
class RolXUsuarioXAplicacion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $fechaCreacion;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var \BackendBundle\Entity\Aplicacion
     */
    private $aplid;

    /**
     * @var \BackendBundle\Entity\Roles
     */
    private $rolid;

    /**
     * @var \BackendBundle\Entity\Users
     */
    private $userid;


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
     * Set fechaCreacion
     *
     * @param integer $fechaCreacion
     *
     * @return RolXUsuarioXAplicacion
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return integer
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return RolXUsuarioXAplicacion
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
     * @return RolXUsuarioXAplicacion
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
     * Set aplid
     *
     * @param \BackendBundle\Entity\Aplicacion $aplid
     *
     * @return RolXUsuarioXAplicacion
     */
    public function setAplid(\BackendBundle\Entity\Aplicacion $aplid = null)
    {
        $this->aplid = $aplid;

        return $this;
    }

    /**
     * Get aplid
     *
     * @return \BackendBundle\Entity\Aplicacion
     */
    public function getAplid()
    {
        return $this->aplid;
    }

    /**
     * Set rolid
     *
     * @param \BackendBundle\Entity\Roles $rolid
     *
     * @return RolXUsuarioXAplicacion
     */
    public function setRolid(\BackendBundle\Entity\Roles $rolid = null)
    {
        $this->rolid = $rolid;

        return $this;
    }

    /**
     * Get rolid
     *
     * @return \BackendBundle\Entity\Roles
     */
    public function getRolid()
    {
        return $this->rolid;
    }

    /**
     * Set userid
     *
     * @param \BackendBundle\Entity\Users $userid
     *
     * @return RolXUsuarioXAplicacion
     */
    public function setUserid(\BackendBundle\Entity\Users $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \BackendBundle\Entity\Users
     */
    public function getUserid()
    {
        return $this->userid;
    }
}

