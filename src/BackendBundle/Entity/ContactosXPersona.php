<?php

namespace BackendBundle\Entity;

/**
 * ContactosXPersona
 */
class ContactosXPersona
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $telefono1;

    /**
     * @var string
     */
    private $telefono2;

    /**
     * @var string
     */
    private $celular;

    /**
     * @var string
     */
    private $facebook;

    /**
     * @var string
     */
    private $twiter;

    /**
     * @var string
     */
    private $linkedin;

    /**
     * @var string
     */
    private $instagram;

    /**
     * @var string
     */
    private $email1;

    /**
     * @var string
     */
    private $email2;

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
     * Set telefono1
     *
     * @param string $telefono1
     *
     * @return ContactosXPersona
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     *
     * @return ContactosXPersona
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set celular
     *
     * @param string $celular
     *
     * @return ContactosXPersona
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return ContactosXPersona
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twiter
     *
     * @param string $twiter
     *
     * @return ContactosXPersona
     */
    public function setTwiter($twiter)
    {
        $this->twiter = $twiter;

        return $this;
    }

    /**
     * Get twiter
     *
     * @return string
     */
    public function getTwiter()
    {
        return $this->twiter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return ContactosXPersona
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set instagram
     *
     * @param string $instagram
     *
     * @return ContactosXPersona
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram
     *
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set email1
     *
     * @param string $email1
     *
     * @return ContactosXPersona
     */
    public function setEmail1($email1)
    {
        $this->email1 = $email1;

        return $this;
    }

    /**
     * Get email1
     *
     * @return string
     */
    public function getEmail1()
    {
        return $this->email1;
    }

    /**
     * Set email2
     *
     * @param string $email2
     *
     * @return ContactosXPersona
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string
     */
    public function getEmail2()
    {
        return $this->email2;
    }

    /**
     * Set idPersona
     *
     * @param \BackendBundle\Entity\Personas $idPersona
     *
     * @return ContactosXPersona
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
