<?php

namespace BackendBundle\Entity;

/**
 * PermisosXRol
 */
class PermisosXRol
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
     * @var \BackendBundle\Entity\Roles
     */
    private $idRol;


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
     * @return PermisosXRol
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
     * Set idRol
     *
     * @param \BackendBundle\Entity\Roles $idRol
     *
     * @return PermisosXRol
     */
    public function setIdRol(\BackendBundle\Entity\Roles $idRol = null)
    {
        $this->idRol = $idRol;

        return $this;
    }

    /**
     * Get idRol
     *
     * @return \BackendBundle\Entity\Roles
     */
    public function getIdRol()
    {
        return $this->idRol;
    }
}
