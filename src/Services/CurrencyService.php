<?php


namespace App\Services;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class CurrencyService
{
    /**
     * @var CurrencyRepository
     */
    private $em;
    private $currencyRepository;

    public function __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
        $this->currencyRepository = $entityManager->getRepository(Currency::class);
    }

    public function list(array $filters = []): ?array
    {
        return $this->em->getRepository(Currency::class)->findBy($filters);
    }

    public function new(array $params): Currency
    {
        if (! $this->validate($params)) {
            throw new \Exception('Wrong params');
        }

        $currency = new Currency();
        $currency->setCharCode($params['char_code']);
        $currency->setDate($params['date']);
        $currency->setName($params['name']);
        $currency->setNumCode($params['num_code']);
        $currency->setValue($params['value']);
        $currency->setValuteID($params['value_id']);
        $this->em->persist($currency);
        $this->em->flush();

        return $currency;
    }

    public function deleteAll(): void
    {
        $this->currencyRepository->deleteAll();
    }

    public function validate(array $params) {
        return true;
    }

}