<?php

/**
 * REST API для вывода списка валют
 *
 */

namespace App\Controller\Rest\v1;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use App\Services\CurrencyService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractFOSRestController {
    private $currencyService = null;

    public function __construct(CurrencyService $currencyService) {
        $this->currencyService = $currencyService;
    }


    public function index() {
        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
        ]);
    }

    /**
     * Вывод списка валют
     *
     * @param Request $request
     * @return View
     * @throws \Exception
     */

    public function list(Request $request) {

        if (
            (! preg_match('/^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[012])\.(19|20)\d\d$/', $request->query->get('from'))
                || ! preg_match('/^(0[1-9]|[12][0-9]|3[01])\.(0[1-9]|1[012])\.(19|20)\d\d$/', $request->query->get('to'))
            )
             && ($request->query->get('from') || $request->query->get('to'))
        ) {
            return View::create([], Response::HTTP_BAD_REQUEST);
        }
        if (empty($request->query->get('from')) && empty($request->query->get('to'))) {
            $dateFrom = null;
            $dateTo = null;
        } else {
            $dateFrom = new \DateTime($request->query->get('from'));
            $dateTo = new \DateTime($request->query->get('to'));
        }

        $currencyList = $this->getDoctrine()
            ->getRepository(Currency::class)
            ->findByFilter($dateFrom, $dateTo, $request->query->get('valuteID'));
        if (0 === count($currencyList)) {
            return View::create([], Response::HTTP_OK);

        }

        return View::create($currencyList, Response::HTTP_OK);
    }
}
