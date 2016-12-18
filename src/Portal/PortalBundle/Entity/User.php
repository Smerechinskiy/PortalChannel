<?php
// src/Portal/PortalBundle/Entity/User.php

namespace Portal\PortalBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function isAdmin()
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Portal\PortalBundle\Entity\Channel", mappedBy="user")
     */
    private $channels;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Portal\PortalBundle\Entity\Channel", inversedBy="follower")
     * @ORM\JoinTable(name="user_to_channel",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="channel_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $followedChannels;

    /**
     * Add channels
     *
     * @param \Portal\PortalBundle\Entity\Channel $channels
     * @return User
     */
    public function addChannel(\Portal\PortalBundle\Entity\Channel $channels)
    {
        $this->channels[] = $channels;

        return $this;
    }

    /**
     * Remove channels
     *
     * @param \Portal\PortalBundle\Entity\Channel $channels
     */
    public function removeChannel(\Portal\PortalBundle\Entity\Channel $channels)
    {
        $this->channels->removeElement($channels);
    }

    /**
     * Get channels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Add followedChannels
     *
     * @param \Portal\PortalBundle\Entity\Channel $followedChannels
     * @return User
     */
    public function addFollowedChannel(\Portal\PortalBundle\Entity\Channel $followedChannels)
    {
        $this->followedChannels[] = $followedChannels;

        return $this;
    }

    /**
     * Remove followedChannels
     *
     * @param \Portal\PortalBundle\Entity\Channel $followedChannels
     */
    public function removeFollowedChannel(\Portal\PortalBundle\Entity\Channel $followedChannels)
    {
        $this->followedChannels->removeElement($followedChannels);
    }

    /**
     * Get followedChannels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollowedChannels()
    {
        return $this->followedChannels;
    }
}
