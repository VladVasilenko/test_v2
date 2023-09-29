<?php

namespace App\Services\PriceValidator;

use App\Interfaces\PriceValidator\ChangePriceValidatorInterface;
use ErrorException;

class ChangePriceValidator implements ChangePriceValidatorInterface
{
    /**
     * @var float
     */
    private float $acceptableDeviation;

    /**
     * @var float
     */
    private float $deviation;

    /**
     * @var bool
     */
    private bool $hasDeviation = false;

    /**
     * @param  float  $acceptableDeviation
     */
    public function __construct(float $acceptableDeviation)
    {
        $this->acceptableDeviation = $acceptableDeviation;
    }

    /**
     * @inheritdoc
     */
    public function diffPrice(float $new, float $out): bool
    {
        $this->deviation = abs($new / $out - 1) * 100;

        $this->hasDeviation = true;

        return !($this->deviation > $this->acceptableDeviation);
    }

    /**
     * @inheritdoc
     * @throws ErrorException
     */
    public function getDeviation(): float
    {
        if (!$this->hasDeviation) {
            throw new ErrorException('Неверное проектирование интерфейса, так делать низя!!!!');
        }

        return $this->deviation;
    }
}
