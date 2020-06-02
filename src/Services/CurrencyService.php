<?php

/**
 * Сервис обработки валют
 *
 */

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

    /**
     * CurrencyService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager){
        $this->em = $entityManager;
        $this->currencyRepository = $entityManager->getRepository(Currency::class);
    }

    /**
     * Вывод списка валют с фильтрацией
     *
     * @param array $filters
     * @return array|null
     */

    public function list(array $filters = []): ?array
    {
        return $this->em->getRepository(Currency::class)->findBy($filters);
    }

    /**
     * Создание записи валюты
     *
     * @param array $params
     * @return Currency
     * @throws \Exception
     */
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

    /**
     * Очистка таблицы валют
     */

    public function deleteAll(): void
    {
        $this->currencyRepository->deleteAll();
    }

    /**
     * Будущий валидатор
     * @param array $params
     * @return bool
     */

    public function validate(array $params) {
        return true;
    }

}