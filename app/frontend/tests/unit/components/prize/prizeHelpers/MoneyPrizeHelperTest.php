<?php
namespace frontend\tests\unit\components\prize\prizeHelpers;

use Codeception\Test\Unit;
use frontend\components\prize\prizeHelpers\MoneyPrizeHelper;
use Mockery;

class MoneyPrizeHelperTest extends Unit
{
    protected function _after()
    {
        Mockery::close();
    }

    public function testCalcPointsFromMoney()
    {
        $toPointsCoefficient = 2;
        $moneyValue = 100;

        $moneyPrizeHelper = Mockery::mock(MoneyPrizeHelper::class . '[getValue,getConvertToPointsCoefficient]');
        $moneyPrizeHelper->shouldReceive('getValue')->andReturn($moneyValue);
        $moneyPrizeHelper->shouldReceive('getConvertToPointsCoefficient')->andReturn($toPointsCoefficient);

        $actualPointsValue = $moneyPrizeHelper->calcPointsFromMoney();
        $expectedPointsValue = 50;
        $this->assertEquals($expectedPointsValue, $actualPointsValue);
    }

    public function testCalcPointsFromMoneyWithNotIntegerResultOfDivision()
    {
        $toPointsCoefficient = 2;
        $moneyValue = 101;

        $moneyPrizeHelper = Mockery::mock(MoneyPrizeHelper::class . '[getValue,getConvertToPointsCoefficient]');
        $moneyPrizeHelper->shouldReceive('getValue')->andReturn($moneyValue);
        $moneyPrizeHelper->shouldReceive('getConvertToPointsCoefficient')->andReturn($toPointsCoefficient);

        $actualPointsValue = $moneyPrizeHelper->calcPointsFromMoney();
        $expectedPointsValue = 50;
        $this->assertEquals($expectedPointsValue, $actualPointsValue);
    }
}