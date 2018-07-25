<?php
namespace Bricks\Business\ModulKassa\UniTest\Document;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Document\InventPositionInterface;
use Bricks\Business\ModulKassa\Document\InventPosition;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class InventPositionTest extends TestCase{
  public function testToJson(){
    $obj = new InventPosition(
      'name',
      5,
      2,
      InventPositionInterface::VAT_NO,
      '123',
      1
    );

    $json = $obj->toJson();

    $this->assertEquals(
      '{"name": "name", "price": 5.00, "quantity": 2.000, "vatTag": 1105, "barcode": "123", "discSum": 1.00}',
      $json
    );
  }

  public function testConstructor_shouldThrowExceptionIfUndefinedVat(){
    $this->expectException(InvalidArgumentException::class);

    new InventPosition(
      'name',
      1,
      1,
      'foo'
    );
  }
}
