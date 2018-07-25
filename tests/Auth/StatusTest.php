<?php
namespace Bricks\Business\ModulKassa\UniTest\Auth;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Auth\StatusInterface;
use Bricks\Business\ModulKassa\Auth\Status;
use DateTime;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class StatusTest extends TestCase{
  public function testFromJson(){
    $data = [
      'status' => StatusInterface::STATUS_READY,
      'statusDateTime' => '2018-07-14T14:38:00+03:00',
    ];
    $json = json_encode($data);

    $auth = Status::fromJson($json);
    $this->assertEquals($data['status'], $auth->getStatus());
    $this->assertEquals($data['statusDateTime'], $auth->getStatusDateTime()->format('c'));
  }

  public function testConstructor_shouldThrowExceptionIfUndefinedStatus(){
    $this->expectException(InvalidArgumentException::class);

    new Status('foo', new DateTime);
  }
}
