<?php

namespace OpenTickets\Tickets\Domain\ValueObject\DiscountType;

use OpenTickets\Tickets\Domain\ValueObject\Basket;
use OpenTickets\Tickets\Domain\ValueObject\Price;

class Percentage implements DiscountTypeInterface
{
    /**
     * @var int
     */
    private $percentage;

    /**
     * Percentage constructor.
     * @param int $percentage
     */
    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    public function apply(Basket $to): Price
    {
        return $to->getPreDiscountTotal()->multiply($this->percentage / 100);
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }
}
