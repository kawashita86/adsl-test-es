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
        foreach($streets['result'] as $street) {
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
        $civics = $webservice->findCivics($request->get('city'), $request->get('street'),$request->get('civic'), $request->get('particella'));
        $typeahead = array();
        //transform results before returing it
        foreach ($civics['result'] as $civic) {
            $typeahead[] = ['name' => $civic, 'value' => $civic, 'tokens' => [$civic]];
        }
        return new JsonResponse($typeahead);

    }

}
