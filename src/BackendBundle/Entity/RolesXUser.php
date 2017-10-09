<?php

namespace BackendBundle\Entity;

/**
 * RolesXUser
 */
class RolesXUser
{
    /**
     * @var integer
     */
    private $id;

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
     * Set rolid
     *
     * @param \BackendBundle\Entity\Roles $rolid
     *
     * @return RolesXUser
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
     * @return RolesXUser
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
