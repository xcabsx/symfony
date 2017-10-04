<?php

namespace BackendBundle\Entity;

/**
 * Modulo
 */
class Modulo
{
    /**
     * @var integer
     */
    private $idModulo;

    /**
     * @var string
     */
    private $descripModulo;


    /**
     * Get idModulo
     *
     * @return integer
     */
    public function getIdModulo()
    {
        return $this->idModulo;
    }

    /**
     * Set descripModulo
     *
     * @param string $descripModulo
     *
     * @return Modulo
     */
    public function setDescripModulo($descripModulo)
    {
        $this->descripModulo = $descripModulo;

        return $this;
    }

    /**
     * Get descripModulo
     *
     * @return string
     */
    public function getDescripModulo()
    {
        return $this->descripModulo;
    }
}

