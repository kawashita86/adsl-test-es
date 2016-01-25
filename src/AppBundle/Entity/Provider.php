<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 *
 * @ORM\Table(name="provider")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProviderRepository")
 */
class Provider
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="string", length=255, nullable=true)
     */
    private $shortDescription;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * @var integer
     *
     * @ORM\Column(name="id_provider", type="integer", nullable=true)
     */
    private $idProvider;

    /**
     * @var string
     *
     * @ORM\Column(name="api", type="string", length=20, nullable=true)
     */
    private $api;

    /**
     * @var string
     *
     * @ORM\Column(name="offers_link", type="string", length=255, nullable=true)
     */
    private $offersLink;

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
     * @return Provider
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
     * @return Provider
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
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Provider
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Provider
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set idProvider
     *
     * @param string $idProvider
     * @return Provider
     */
    public function setIdProvider($idProvider)
    {
        $this->idProvider = $idProvider;

        return $this;
    }

    /**
     * Get idProvider
     *
     * @return string
     */
    public function getIdProvider()
    {
        return $this->idProvider;
    }

    /**
     * Set api
     *
     * @param string $api
     * @return Provider
     */
    public function setApi($api)
    {
        $this->api = $api;

        return $this;
    }

    /**
     * Get api
     *
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * Set offersLink
     *
     * @param string $offersLink
     * @return Provider
     */
    public function setOffersLink($offersLink)
    {
        $this->offersLink = $offersLink;

        return $this;
    }

    /**
     * Get offersLink
     *
     * @return string
     */
    public function getOffersLink()
    {
        return $this->offersLink;
    }


}
