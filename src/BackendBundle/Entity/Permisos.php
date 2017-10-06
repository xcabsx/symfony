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

}

