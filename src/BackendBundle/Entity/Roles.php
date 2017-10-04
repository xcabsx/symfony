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
}

