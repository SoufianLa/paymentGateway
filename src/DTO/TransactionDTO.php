<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionDTO
{

    public function __construct(
        #[Assert\GreaterThanOrEqual(1)]
        #[Assert\Type('integer')]
        #[Assert\NotBlank]
        readonly private int $amount,
        #[Assert\Currency]
        #[Assert\NotBlank]
        readonly private string $currency,
        #[Assert\Luhn]
        #[Assert\NotBlank]
        readonly private string $cardNumber,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^(0[1-9]|1[0-2])$/')]
        readonly private string $cardExpMonth,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\d{4}$/')]
        readonly private string $cardExpYear,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\d{3,4}$/')]
        readonly private string $cardCvv
    ) {

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
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @return string
     */
    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }

    /**
     * @return string
     */
    public function getCardExpYear(): string
    {
        return $this->cardExpYear;
    }



    /**
     * @return string
     */
    public function getCardCvv(): string
    {
        return $this->cardCvv;
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'cardNumber' => $this->getCardNumber(),
            'cardExpMonth' => $this->getCardExpMonth(),
            'cardExpYear' => $this->getCardExpYear(),
            'cardCvv' => $this->getCardCvv(),
        ];
    }


}