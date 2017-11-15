<?php

namespace BackendBundle\Entity;

/**
 * DireccionesXPersonas
 */
class DireccionesXPersonas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pais;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var string
     */
    private $localidad;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var integer
     */
    private $numero;

    /**
     * @var integer
     */
    private $casa;

    /**
     * @var integer
     */
    private $piso;

    /**
     * @var integer
     */
    private $dpto;

    /**
     * @var integer
     */
    private $manzana;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var \DateTime
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     */
    private $fechaBaja;

    /**
     * @var \BackendBundle\Entity\Personas
     */
    private $idPersona;


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
     * Set pais
     *
     * @param string $pais
     *
     * @return DireccionesXPersonas
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return DireccionesXPersonas
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     *
     * @return DireccionesXPersonas
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return DireccionesXPersonas
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return DireccionesXPersonas
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set casa
     *
     * @param integer $casa
     *
     * @return DireccionesXPersonas
     */
    public function setCasa($casa)
    {
        $this->casa = $casa;

        return $this;
    }

    /**
     * Get casa
     *
     * @return integer
     */
    public function getCasa()
    {
        return $this->casa;
    }

    /**
     * Set piso
     *
     * @param integer $piso
     *
     * @return DireccionesXPersonas
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get piso
     *
     * @return integer
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set dpto
     *
     * @param integer $dpto
     *
     * @return DireccionesXPersonas
     */
    public function setDpto($dpto)
    {
        $this->dpto = $dpto;

        return $this;
    }

    /**
     * Get dpto
     *
     * @return integer
     */
    public function getDpto()
    {
        return $this->dpto;
    }

    /**
     * Set manzana
     *
     * @param integer $manzana
     *
     * @return DireccionesXPersonas
     */
    public function setManzana($manzana)
    {
        $this->manzana = $manzana;

        return $this;
    }

    /**
     * Get manzana
     *
     * @return integer
     */
    public function getManzana()
    {
        return $this->manzana;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return DireccionesXPersonas
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return DireccionesXPersonas
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     *
     * @return DireccionesXPersonas
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     *
     * @return DireccionesXPersonas
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set idPersona
     *
     * @param \BackendBundle\Entity\Personas $idPersona
     *
     * @return DireccionesXPersonas
     */
    public function setIdPersona(\BackendBundle\Entity\Personas $idPersona = null)
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    /**
     * Get idPersona
     *
     * @return \BackendBundle\Entity\Personas
     */
    public function getIdPersona()
    {
        return $this->idPersona;
    }
}
