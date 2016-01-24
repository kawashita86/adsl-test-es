<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Utils\ComparaWebService;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('controller/default/index.html.twig',
            ['activity' => $this->getActivityBlock(),
             'top_providers' => $this->getTopPositions()
            ]
        );
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/adsl-result/{result_hash}", name="adsl_result", requirements={"result_hash": "\w+"})
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function adslResultAction($result_hash, Request $request)
    {
        //calls to get information from entity
        if (!($speedtest = $this->container->get('app.speed_test.handler')->get($result_hash))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $result_hash));
        }

        return $this->render('controller/default/adslResult.html.twig', [
           'adsl_speedtest' => $speedtest,
           'activity' => $this->getActivityBlock(),
           'top_providers' => $this->getTopPositions(),
           'tariffs' => []
        ]);
    }

    /**
     * @Route("adsl-compare", name="adsl_compare")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function adslCompareAction()
    {
        $webservice = new ComparaWebService($this->get('csa_guzzle.client.comparasemplice'));
        $offers = $webservice->getComparator();
        //$offers = $webservice->mockComparator(); //mock
        return $this->render('controller/default/adslCompare.html.twig', [
           'offers' => $offers
        ]);
    }

    /**
     * @param Request $request
     * @Route("/about-us", name="about_us")
     */
    public function aboutUsAction(Request $request)
    {

    }

    /**
     * @return array
     * Utility method to group all the information for the lastResults block
     */
    private function getActivityBlock(){
        $speed_test_handler = $this->container->get('app.speed_test.handler');
        $today = $speed_test_handler->getLatest();
        $topweek = $speed_test_handler->getTopWeek();
        $topmonth = $speed_test_handler->getTopMonth();
        return ['today' => $today, 'topweek' => $topweek, 'topmonth' => $topmonth];
    }

    /**
     * @return mixed
     * Utility method to group all the information for the topProviders block
     */
    private function getTopPositions(){
        $speed_test_handler = $this->container->get('app.speed_test.handler');
        return $speed_test_handler->getTopProviders();
    }
}
