<?php
namespace Bricks\Business\ModulKassa\UniTest\Document;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Document\MoneyPositionInterface;
use Bricks\Business\ModulKassa\Document\MoneyPosition;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class StatusTest extends TestCase{
  public function testToJson(){
    $obj = new MoneyPosition(
      MoneyPositionInterface::TYPE_CARD,
      1
    );

    $json = $obj->toJson();

    $this->assertEquals(
      '{"paymentType": "CARD", "sum": 1.00}',
      $json
    );
  }

  public function testConstructor_shouldThrowExceptionIfUndefinedPaymentType(){
    $this->expectException(InvalidArgumentException::class);

    new MoneyPosition('foo', 1);
  }
}
