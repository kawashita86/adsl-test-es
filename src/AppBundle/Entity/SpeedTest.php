<?php

namespace AppBundle\Entity;

use AppBundle\Model\SpeedTestInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * SpeedTest
 *
 * @ORM\Table(name="speed_test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpeedTestRepository")
 */
class SpeedTest implements SpeedTestInterface
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
     * @ORM\Column(name="ip_address", type="string", length=20)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="provider", type="string", length=255)
     */
    private $provider;

    /**
     * @var int
     *
     * @ORM\Column(name="download_speed", type="integer")
     */
    private $downloadSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="upload_speed", type="integer")
     */
    private $uploadSpeed;

    /**
     * @var int
     *
     * @ORM\Column(name="ping", type="integer")
     */
    private $ping;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=40)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=40)
     */
    private $longitude;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=true)
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100)
     */
    private $city;

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
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return SpeedTest
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return SpeedTest
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set downloadSpeed
     *
     * @param integer $downloadSpeed
     *
     * @return SpeedTest
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;

        return $this;
    }

    /**
     * Get downloadSpeed
     *
     * @return int
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * Set uploadSpeed
     *
     * @param integer $uploadSpeed
     *
     * @return SpeedTest
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;

        return $this;
    }

    /**
     * Get uploadSpeed
     *
     * @return int
     */
    public function getUploadSpeed()
    {
        return $this->uploadSpeed;
    }

    /**
     * Set ping
     *
     * @param integer $ping
     *
     * @return SpeedTest
     */
    public function setPing($ping)
    {
        $this->ping = $ping;

        return $this;
    }

    /**
     * Get ping
     *
     * @return int
     */
    public function getPing()
    {
        return $this->ping;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return SpeedTest
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return SpeedTest
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return SpeedTest
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return SpeedTest
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
     * SpeedTest constructor.
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime("now");
    }
}

