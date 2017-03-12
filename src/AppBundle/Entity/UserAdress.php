<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;

/**
 * UserAdress
 *
 * @ORM\Table(name="user_adress")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserAdressRepository")
 */
class UserAdress
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="vestigings_id", type="integer")
     */
    private $vestigingsId;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vestigingen")
     * @ORM\JoinColumn(name="vestigings_id", referencedColumnName="id")
     */
    private $vestigingenId;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, unique=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=12)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserAdress
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return UserAdress
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return UserAdress
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return UserAdress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return UserAdress
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserAdress
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set vestigingsId
     *
     * @param integer $vestigingsId
     *
     * @return UserAdress
     */
    public function setVestigingsId($vestigingsId)
    {
        $this->vestigingsId = $vestigingsId;

        return $this;
    }

    /**
     * Get vestigingsId
     *
     * @return integer
     */
    public function getVestigingsId()
    {
        return $this->vestigingsId;
    }

    /**
     * Set vestiging
     *
     * @param \AppBundle\Entity\Vestigingen $vestiging
     *
     * @return UserAdress
     */
    public function setVestiging(\AppBundle\Entity\Vestigingen $vestiging = null)
    {
        $this->vestiging = $vestiging;

        return $this;
    }

    /**
     * Get vestiging
     *
     * @return \AppBundle\Entity\Vestigingen
     */
    public function getVestiging()
    {
        return $this->vestiging;
    }

    /**
     * Set vestigingen
     *
     * @param \AppBundle\Entity\Vestigingen $vestigingen
     *
     * @return UserAdress
     */
    public function setVestigingen(\AppBundle\Entity\Vestigingen $vestigingen = null)
    {
        $this->vestigingen = $vestigingen;

        return $this;
    }

    /**
     * Get vestigingen
     *
     * @return \AppBundle\Entity\Vestigingen
     */
    public function getVestigingen()
    {
        return $this->vestigingen;
    }

    /**
     * Set vestigingenId
     *
     * @param \AppBundle\Entity\Vestigingen $vestigingenId
     *
     * @return UserAdress
     */
    public function setVestigingenId(\AppBundle\Entity\Vestigingen $vestigingenId = null)
    {
        $this->vestigingenId = $vestigingenId;

        return $this;
    }

    /**
     * Get vestigingenId
     *
     * @return \AppBundle\Entity\Vestigingen
     */
    public function getVestigingenId()
    {
        return $this->vestigingenId;
    }
}
