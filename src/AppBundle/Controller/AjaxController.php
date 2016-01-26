<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\ComparaWebService;
use AppBundle\Exception\InvalidFormException;

class AjaxController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/save-result", name="save_result")
     * @Method("POST")
     */
    public function saveResultAction(Request $request)
    {
        try {
            $speedTest = $this->container->get('app.speed_test.handler')->post(
                $request->request->all()
            );

            return new JsonResponse(['id' => $speedTest->getId()]);
        } catch (InvalidFormException $e) {
            return new JsonResponse(['error' => $e->getMessage()], '403');
        }
    }

    /**
     * @param Request $request
     * @Route("/get-specific-offers", name="get_specific_offers")
     * @Method("POST")
     */
    public function getSpecificOffersAction(Request $request)
    {
        if (!($speedtest = $this->container->get('app.speed_test.handler')->get($request->get('id')))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.', $request->get('id')));
        }

        return $this->render('controller/ajax/specificOffers.html.twig', [
            'adsl_speedtest' => $speedtest,
            'tariffs' => []
        ]);
    }

    /**
     * @param Request $request
     * @Route("/get-coverage-offers", name="get_coverage_offers")
     * @Method("POST")
     */
    public function getCoverageOffersAction(Request $request)
    {

        //check request for additional data
        $webservice = new ComparaWebService($this->get('csa_guzzle.client.copertura'));
        $offers = $webservice->findVerify($request->get('comune'), $request->get('particella'), $request->get('indirizzo'), $request->get('civico'));
        $error = ($offers === false);
        return new JsonResponse(array(
            'error' => $error,
            'template' => $this->renderView('controller/ajax/coverageOffers.html.twig', [
                'offers' => $offers['providers']
            ]),
            'lineQuality' => $offers['lineQuality'],
            'distance' => $offers['distance'],
            'offers' => $offers
        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("find/city", name="find_city")
     * @Method("GET")
     */
    public function findCityAction(Request $request)
    {

        $webservice = new ComparaWebService($this->get('csa_guzzle.client.copertura'));
        $cities = $webservice->findCities($request->get('city'));
        $typeahead = array();
        foreach ($cities['result'] as $city) {
            $typeahead[] = ['name' => $city, 'value' => $city, 'tokens' => [$city]];
        }
        return new JsonResponse($typeahead);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("find/street", name="find_street")
     * @Method("GET")
     */
    public function findStreetAction(Request $request)
    {
        $webservice = new ComparaWebService($this->get('csa_guzzle.client.copertura'));
        $streets = $webservice->findStreets($request->get('city'), $request->get('street'));
        $typeahead = array();
        foreach ($streets['result'] as $street) {
            $street['name'] = $street['toponomastica'];
            $street['value'] = $street['toponomastica'];
            $street['tokens'] = [$street['toponomastica']];
            $typeahead[] = $street;
        }
        return new JsonResponse($typeahead);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("find/civic", name="find_civic")
     * @Method("GET")
     */
    public function findCivicAction(Request $request)
    {
        $webservice = new ComparaWebService($this->get('csa_guzzle.client.copertura'));
        $civics = $webservice->findCivics($request->get('city'), $request->get('street'), $request->get('civic'), $request->get('particella'));
        $typeahead = array();
        //transform results before returing it
        foreach ($civics['result'] as $civic) {
            $typeahead[] = ['name' => $civic, 'value' => $civic, 'tokens' => [$civic]];
        }
        return new JsonResponse($typeahead);

    }

    /**
     * @return JsonResponse
     * @Route("get-avg-hourly", name="get_avg_hourly")
     * @Method("GET")
     */
    public function getAvgHourlyAction()
    {
        //$chartData = $this->container->get('app.speed_test.handler')->getAvgHourly();
        $chartData = $this->getAvgHourlyMockup();
        return new JsonResponse($chartData);

    }

    private function getAvgHourlyMockup()
    {
        return json_decode('[{"download":19.09,"upload":1.95,"dtf":"00:00"},{"download":8.9,"upload":0.67,"dtf":"01:00"},{"download":8.31,"upload":0.68,"dtf":"02:00"},{"download":10.33,"upload":0.88,"dtf":"04:00"},{"download":9.43,"upload":0.83,"dtf":"06:00"},{"download":10.58,"upload":1.65,"dtf":"07:00"},{"download":18.16,"upload":1.52,"dtf":"08:00"},{"download":14.81,"upload":2.37,"dtf":"09:00"},{"download":12.52,"upload":2.11,"dtf":"10:00"},{"download":12.76,"upload":1.86,"dtf":"11:00"},{"download":16.8,"upload":2.36,"dtf":"12:00"},{"download":12.27,"upload":1.8,"dtf":"13:00"},{"download":15.04,"upload":2.51,"dtf":"14:00"},{"download":18.04,"upload":4.07,"dtf":"15:00"}]', true);
    }

}
