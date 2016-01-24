<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:07
 */
namespace AppBundle\Handler;

use AppBundle\Model\SpeedTestInterface;

interface SpeedTestHandlerInterface {
    public function get($id);

    public function post(array $parameters);

    public function put(SpeedTestInterface $test, array $parameters);

    public function patch(SpeedTestInterface $test, array $parameters);

    public function all($limit = 5, $offset = 0);
}