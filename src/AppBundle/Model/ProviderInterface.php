<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:08
 */

namespace AppBundle\Model;

interface ProviderInterface {

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return Provider
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set description
     *
     * @param string $description
     * @return Provider
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();
    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Provider
     */
    public function setShortDescription($shortDescription);
    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription();

    /**
     * Set active
     *
     * @param boolean $active
     * @return Provider
     */
    public function setActive($active);

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive();

    /**
     * Set idProvider
     *
     * @param string $idProvider
     * @return Provider
     */
    public function setIdProvider($idProvider);

    /**
     * Get idProvider
     *
     * @return string
     */
    public function getIdProvider();

    /**
     * Set api
     *
     * @param string $api
     * @return Provider
     */
    public function setApi($api);

    /**
     * Get api
     *
     * @return string
     */
    public function getApi();

    /**
     * Set offersLink
     *
     * @param string $offersLink
     * @return Provider
     */
    public function setOffersLink($offersLink);

    /**
     * Get offersLink
     *
     * @return string
     */
    public function getOffersLink();


}