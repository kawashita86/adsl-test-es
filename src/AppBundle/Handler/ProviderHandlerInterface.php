<?php
/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:07
 */
namespace AppBundle\Handler;

use AppBundle\Model\ProviderInterface;

interface ProviderHandlerInterface {
    public function get($id);

    public function post(array $parameters);

    public function put(ProviderInterface $provider, array $parameters);

    public function patch(ProviderInterface $provider, array $parameters);

    public function all($limit = 5, $offset = 0);
}