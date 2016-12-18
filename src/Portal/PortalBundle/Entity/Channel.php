<?php
/**
 * Created by PhpStorm.
 * User: Богдан
 * Date: 14.12.2016
 * Time: 21:45
 */

// src/Portal/PortalBundle/Entity/Channel.php
namespace Portal\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Portal\PortalBundle\Entity\Channel
 *
 * @ORM\Table(name="channel")
 * @ORM\Entity(repositoryClass="Portal\PortalBundle\Entity\ChannelRepository")
 */
class Channel {
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Portal\PortalBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Portal\PortalBundle\Entity\User", inversedBy="channels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    protected $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Portal\PortalBundle\Entity\User", mappedBy="followedChannels")
     */
    private $follower;

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
     * Set name
     *
     * @param string $name
     * @return Channel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Channel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set user
     *
     * @param \Portal\PortalBundle\Entity\User $user
     * @return Channel
     */
    public function setUser(\Portal\PortalBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Portal\PortalBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->follower = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add follower
     *
     * @param \Portal\PortalBundle\Entity\User $follower
     * @return Channel
     */
    public function addFollower(\Portal\PortalBundle\Entity\User $follower)
    {
        $this->follower[] = $follower;

        return $this;
    }

    /**
     * Remove follower
     *
     * @param \Portal\PortalBundle\Entity\User $follower
     */
    public function removeFollower(\Portal\PortalBundle\Entity\User $follower)
    {
        $this->follower->removeElement($follower);
    }

    /**
     * Get follower
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollower()
    {
        return $this->follower;
    }
}
