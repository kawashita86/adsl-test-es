<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:08
 */

namespace AppBundle\Model;

interface SpeedTestInterface {

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return SpeedTest
     */
    public function setIpAddress($ipAddress);

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress();

    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return SpeedTest
     */
    public function setProvider($provider);

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider();

    /**
     * Set downloadSpeed
     *
     * @param integer $downloadSpeed
     *
     * @return SpeedTest
     */
    public function setDownloadSpeed($downloadSpeed);

    /**
     * Get downloadSpeed
     *
     * @return int
     */
    public function getDownloadSpeed();

    /**
     * Set uploadSpeed
     *
     * @param integer $uploadSpeed
     *
     * @return SpeedTest
     */
    public function setUploadSpeed($uploadSpeed);

    /**
     * Get uploadSpeed
     *
     * @return int
     */
    public function getUploadSpeed();

    /**
     * Set ping
     *
     * @param integer $ping
     *
     * @return SpeedTest
     */
    public function setPing($ping);

    /**
     * Get ping
     *
     * @return int
     */
    public function getPing();

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return SpeedTest
     */
    public function setLatitude($latitude);

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude();

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return SpeedTest
     */
    public function setLongitude($longitude);

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude();

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return SpeedTest
     */
    public function setTimestamp($timestamp);

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp();

    /**
     * Set city
     *
     * @param string $city
     *
     * @return SpeedTest
     */
    public function setCity($city);

    /**
     * Get city
     *
     * @return string
     */
    public function getCity();

    /**
     * Set takenTestId
     *
     * @param string $takenTestId
     *
     * @return SpeedTest
     */
    public function setTakenTestId($takenTestId);

    /**
     * Get takenTestId
     *
     * @return string
     */
    public function getTakenTestId();



}