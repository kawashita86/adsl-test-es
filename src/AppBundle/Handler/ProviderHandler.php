<?php

/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:06
 */

namespace AppBundle\Handler;

    use Doctrine\Common\Persistence\ObjectManager;
    use AppBundle\Model\ProviderInterface;
    use AppBundle\Form\ProviderType;
    use Symfony\Component\Form\FormFactoryInterface;
    use AppBundle\Exception\InvalidFormException;

class ProviderHandler implements ProviderHandlerInterface {

    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory){

        $this->om = $om;
        $this->entityClass= $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    public function get($id){
        return $this->repository->find($id);
    }

    public function all($limit = 5, $offset = 0){
        return $this->repository->findBy([], null, $limit, $offset);;
    }

    public function post(array $parameters){
        $provider = $this->createProvider();

        return $this->processForm($provider, $parameters, 'POST');
    }

    public function put(ProviderInterface $provider, array $parameters){
        return $this->processForm($provider, $parameters, 'PUT');
    }

    public function patch(ProviderInterface $provider, array $parameters){
        return $this->processForm($provider, $parameters, 'PATCH');
    }

    public function delete($id){
        $test = $this->repository->find($id);
        $this->om->remove($test);
        $this->flush();
    }

    /**
     * @param ProviderInterface $provider
     * @param array $parameters
     * @param string $method
     * @return ProviderInterface|mixed
     * @throws InvalidFormException
     */
    private  function processForm(ProviderInterface $provider, array $parameters, $method = 'PUT'){

        $form = $this->formFactory->create(new ProviderType(), $provider, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if($form->isValid()){

            $test = $form->getData();
            $this->om->persist($provider);
            $this->om->flush($provider);

            return $provider;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createProvider()
    {
        return new $this->entityClass();
    }

}