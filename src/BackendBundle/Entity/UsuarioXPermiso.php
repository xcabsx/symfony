<?php

namespace BackendBundle\Entity;

/**
 * UsuarioXPermiso
 */
class UsuarioXPermiso
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BackendBundle\Entity\Permisos
     */
    private $idPermiso;

    /**
     * @var \BackendBundle\Entity\Users
     */
    private $idUsuario;


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
     * Set idPermiso
     *
     * @param \BackendBundle\Entity\Permisos $idPermiso
     *
     * @return UsuarioXPermiso
     */
    public function setIdPermiso(\BackendBundle\Entity\Permisos $idPermiso = null)
    {
        $this->idPermiso = $idPermiso;

        return $this;
    }

    /**
     * Get idPermiso
     *
     * @return \BackendBundle\Entity\Permisos
     */
    public function getIdPermiso()
    {
        return $this->idPermiso;
    }

    /**
     * Set idUsuario
     *
     * @param \BackendBundle\Entity\Users $idUsuario
     *
     * @return UsuarioXPermiso
     */
    public function setIdUsuario(\BackendBundle\Entity\Users $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \BackendBundle\Entity\Users
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}

