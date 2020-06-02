<?php

namespace App\Controller\Web;

use App\Services\CurrencyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    private $currencyService = null;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @Route("/", name="currency")
     */
    public function index()
    {
        return $this->render('currency/index.html.twig', [
            'controller_name' => 'CurrencyController',
            'currency_list' => $this->currencyService->list()
        ]);
    }

    /**
     * @param $params
     * @return \App\Entity\Currency
     * @throws \Exception
     */

    public function new($params) {
        return $this->currencyService->new($params);
    }
}
