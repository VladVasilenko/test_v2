<?php

namespace App\Interfaces\PriceValidator;

interface ChangePriceValidatorInterface
{
    /**
     * Отклонение цены не должно быть больше допустимого значения (%)
     *
     * @param  float  $new новая цена, которую будем проверять на отклонение
     * @param  float  $out текущая цена
     * @return bool
     */
    public function diffPrice(float $new, float $out): bool;

    /**
     * Результат отклонения в %
     *
     * @return float
     */
    public function getDeviation(): float;
}
