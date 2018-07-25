<?php
namespace Bricks\Business\ModulKassa\UniTest\Document;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Document\DocumentInterface;
use Bricks\Business\ModulKassa\Document\Document;
use Bricks\Business\ModulKassa\Document\InventPositionInterface;
use Bricks\Business\ModulKassa\Document\InventPosition;
use Bricks\Business\ModulKassa\Document\MoneyPositionInterface;
use Bricks\Business\ModulKassa\Document\MoneyPosition;
use DateTime;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class DocumentTest extends TestCase{
  public function testToJson(){
    $inventPositions = [
      new InventPosition(
        'name',
        5,
        2,
        InventPositionInterface::VAT_18
      )
    ];
    $moneyPositions = [
      new MoneyPosition(
        MoneyPositionInterface::TYPE_CARD,
        10
      )
    ];

    $obj = new Document(
      '1',
      new DateTime('2018-07-14T14:58:00+03:00'),
      '2',
      DocumentInterface::TYPE_SALE,
      $inventPositions,
      $moneyPositions,
      'artur-mamedbekov@yandex.ru',
      null,
      true,
      'http://callback.com'
    );

    $json = $obj->toJson();
    $inventPositionJson = $inventPositions[0]->toJson();
    $moneyPositionJson = $moneyPositions[0]->toJson();

    $this->assertEquals(
      '{"id": "1", "checkoutDateTime": "2018-07-14T14:58:00+03:00", "docNum": "2", "docType": "SALE", "email": "artur-mamedbekov@yandex.ru", "inventPositions": [' . $inventPositionJson . '], "moneyPositions": [' . $moneyPositionJson . '], "printReceipt": true, "responseUrl": "http://callback.com"}',
      $json
    );
  }

  public function testConstructor_shouldThrowExceptionIfUndefinedType(){
    $this->expectException(InvalidArgumentException::class);

    new Document(
      '1',
      new DateTime('2018-07-14T14:58:00+03:00'),
      '2',
      'foo'
    );
  }
}
