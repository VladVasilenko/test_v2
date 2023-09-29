<?php

namespace Tests\Unit\Services\PriceValidator;

use App\Services\PriceValidator\ChangePriceValidator;
use ErrorException;
use PHPUnit\Framework\TestCase;

class ChangePriceValidatorTest extends TestCase
{

    /**
     * @return void
     * @dataProvider getPricesDataProvider
     * @throws \ErrorException
     */
    public function testDiffPrice(
        float $acceptableDeviation,
        float $new,
        float $out,
        bool $result,
        float $realDeviation
    ) {
        /** @var ChangePriceValidator $validator */
        $validator = resolve(ChangePriceValidator::class, ['acceptableDeviation' => $acceptableDeviation]);

        $this->assertSame($result, $validator->diffPrice($new, $out));
        $this->assertEqualsWithDelta($realDeviation, $validator->getDeviation(), 0.99);
    }

    /**
     * @return void
     * @throws ErrorException
     */
    public function testWrongCallMethod() {
        /** @var ChangePriceValidator $validator */
        $validator = resolve(ChangePriceValidator::class, ['acceptableDeviation' => 20]);
        $this->expectException(ErrorException::class);
        $validator->getDeviation();

    }


    public function getPricesDataProvider()
    {
        return [
            [
                'acceptableDeviation' => 20,
                'new' => 50,
                'out' => 25,
                'result' => false,
                'realDeviation' => 100
            ],
            [
                'acceptableDeviation' => 10,
                'new' => 100,
                'out' => 120,
                'result' => false,
                'realDeviation' => 16
            ],
            [
                'acceptableDeviation' => 20,
                'new' => 100,
                'out' => 120,
                'result' => true,
                'realDeviation' => 16
            ]
        ];
    }
}
