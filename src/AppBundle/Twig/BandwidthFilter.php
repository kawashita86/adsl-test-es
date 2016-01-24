<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 23/01/2016
 * Time: 18:33
 */
namespace AppBundle\Twig;


class BandwidthFilter extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('bandwidth_filter', array($this, 'bandwidthFilter')),
        );
    }

    public function bandwidthFilter($bandwidth)
    {
        return number_format($bandwidth/1000, 2, '.', '');
    }

    public function getName()
    {
        return 'bandwidth_filter';
    }
}