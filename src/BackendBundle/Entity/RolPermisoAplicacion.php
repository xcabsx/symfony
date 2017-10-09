<?php

namespace BackendBundle\Entity;

/**
 * RolPermisoAplicacion
 */
class RolPermisoAplicacion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @var integer
     */
    private $fechaModificacion;

    /**
     * @var \BackendBundle\Entity\Aplicacion
     */
    private $idaplicacion;

    /**
     * @var \BackendBundle\Entity\Permisos
     */
    private $idpermiso;

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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return RolPermisoAplicacion
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
     * Set fechaModificacion
     *
     * @param integer $fechaModificacion
     *
     * @return RolPermisoAplicacion
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return integer
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Set idaplicacion
     *
     * @param \BackendBundle\Entity\Aplicacion $idaplicacion
     *
     * @return RolPermisoAplicacion
     */
    public function setIdaplicacion(\BackendBundle\Entity\Aplicacion $idaplicacion = null)
    {
        $this->idaplicacion = $idaplicacion;

        return $this;
    }

    /**
     * Get idaplicacion
     *
     * @return \BackendBundle\Entity\Aplicacion
     */
    public function getIdaplicacion()
    {
        return $this->idaplicacion;
    }

    /**
     * Set idpermiso
     *
     * @param \BackendBundle\Entity\Permisos $idpermiso
     *
     * @return RolPermisoAplicacion
     */
    public function setIdpermiso(\BackendBundle\Entity\Permisos $idpermiso = null)
    {
        $this->idpermiso = $idpermiso;

        return $this;
    }

    /**
     * Get idpermiso
     *
     * @return \BackendBundle\Entity\Permisos
     */
    public function getIdpermiso()
    {
        return $this->idpermiso;
    }

    /**
     * Set idrol
     *
     * @param \BackendBundle\Entity\Roles $idrol
     *
     * @return RolPermisoAplicacion
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
