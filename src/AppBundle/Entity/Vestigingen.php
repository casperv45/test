<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vestigingen
 *
 * @ORM\Table(name="vestigingen")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VestigingenRepository")
 */
class Vestigingen
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
     * @var string
     *
     * @ORM\Column(name="vestiging", type="string", length=255, unique=true)
     */
    private $vestigingsplaats;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefoon", type="string", length=30, nullable=true)
     */
    private $telefoon;

    /**
     * @var string
     *
     * @ORM\Column(name="adres", type="string", length=255, nullable=true)
     */
    private $adres;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=15, nullable=true)
     */
    private $postcode;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    public function __toString() {
        return $this->getVestigingsplaats();
    }


    /**
     * Set vestiging
     *
     * @param string $vestiging
     *
     * @return Vestigingen
     */
    public function setVestiging($vestiging)
    {
        $this->vestiging = $vestiging;

        return $this;
    }

    /**
     * Get vestiging
     *
     * @return string
     */
    public function getVestiging()
    {
        return $this->vestiging;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Vestigingen
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefoon
     *
     * @param string $telefoon
     *
     * @return Vestigingen
     */
    public function setTelefoon($telefoon)
    {
        $this->telefoon = $telefoon;

        return $this;
    }

    /**
     * Get telefoon
     *
     * @return string
     */
    public function getTelefoon()
    {
        return $this->telefoon;
    }

    /**
     * Set adres
     *
     * @param string $adres
     *
     * @return Vestigingen
     */
    public function setAdres($adres)
    {
        $this->adres = $adres;

        return $this;
    }

    /**
     * Get adres
     *
     * @return string
     */
    public function getAdres()
    {
        return $this->adres;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Vestigingen
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set vestigingsplaats
     *
     * @param string $vestigingsplaats
     *
     * @return Vestigingen
     */
    public function setVestigingsplaats($vestigingsplaats)
    {
        $this->vestigingsplaats = $vestigingsplaats;

        return $this;
    }

    /**
     * Get vestigingsplaats
     *
     * @return string
     */
    public function getVestigingsplaats()
    {
        return $this->vestigingsplaats;
    }
}
