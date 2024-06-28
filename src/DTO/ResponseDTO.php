<?php

namespace App\DTO;

class ResponseDTO
{

    public function __construct(
        readonly private string $transaction,
        private string $date,
        readonly private string $amount,
        readonly private string $currency,
        readonly private string $cardBin
    ) {
        $this->date = (new \DateTime($date))->format(\DateTime::ATOM);
    }

    /**
     * @return string
     */
    public function getTransaction(): string
    {
        return $this->transaction;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getCardBin(): string
    {
        return $this->cardBin;
    }

}