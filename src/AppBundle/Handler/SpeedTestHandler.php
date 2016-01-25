<?php

/**
 * Created by PhpStorm.
 * User: Francesco
 * Date: 22/01/2016
 * Time: 08:06
 */

namespace AppBundle\Handler;

    use Doctrine\Common\Persistence\ObjectManager;
    use AppBundle\Model\SpeedTestInterface;
    use AppBundle\Form\SpeedTestType;
    use Symfony\Component\Form\FormFactoryInterface;
    use AppBundle\Exception\InvalidFormException;

class SpeedTestHandler implements SpeedTestHandlerInterface {

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

    public function getAvgHourly(){
        $now = new \DateTime();
        $startDay = $now->setTime(0,0,0);
        $endDay = $now->setTime(23,59,59);
        return $this->repository->getAvgHourly($startDay,$endDay);
    }

    public function getTopProviders($limit = 3){
        $now = new \DateTime();
        $month = $now->sub(new \DateInterval("P1M"));
        return $this->repository->findFastestProviderByDate($month, $limit);
    }

    public function getLatest($limit = 5){
        $now = new \DateTime();
        $now->setTime(0,0,0);
        return $this->repository->findLatestByDate($now, $limit);
    }

    public function getTopMonth($limit = 5){
        $now = new \DateTime();
        $month = $now->sub(new \DateInterval("P1M"));
        return $this->repository->findFastestByDate($month, $limit);
    }

    public function getTopWeek($limit = 5){
        $now = new \DateTime();
        $week = $now->sub(new \DateInterval("P1W"));
        return $this->repository->findFastestByDate($week, $limit);
    }

    public function post(array $parameters){
        $test = $this->createSpeedTest();

        return $this->processForm($test, $parameters, 'POST');
    }

    public function put(SpeedTestInterface $test, array $parameters){
        return $this->processForm($test, $parameters, 'PUT');
    }

    public function patch(SpeedTestInterface $test, array $parameters){
        return $this->processForm($test, $parameters, 'PATCH');
    }

    public function delete($id){
        $test = $this->repository->find($id);
        $this->om->remove($test);
        $this->flush();
    }

    /**
     * @param SpeedTestInterface $user
     * @param array $parameters
     * @param string $method
     * @return SpeedTestInterface|mixed
     * @throws InvalidFormException
     */
    private  function processForm(SpeedTestInterface $test, array $parameters, $method = 'PUT'){

        $form = $this->formFactory->create(new SpeedTestType(), $test, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if($form->isValid()){

            $test = $form->getData();
            $this->om->persist($test);
            $this->om->flush($test);

            return $test;
        }
        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createSpeedTest()
    {
        return new $this->entityClass();
    }

}