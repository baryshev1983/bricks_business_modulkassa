<?php
namespace Bricks\Business\ModulKassa\UniTest\Document;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Document\DocumentStatusInterface;
use Bricks\Business\ModulKassa\Document\DocumentStatus;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class DocumentStatusTest extends TestCase{
  public function testFromJson(){
    $data = [
      'status' => DocumentStatusInterface::STATUS_QUEUED,
      'fnState' => 'foo',
    ];
    $json = json_encode($data);

    $auth = DocumentStatus::fromJson($json);
    $this->assertEquals($data['status'], $auth->getStatus());
    $this->assertEquals($data['fnState'], $auth->getFnState());
  }

  public function testConstructor_shouldThrowExceptionIfUndefinedStatus(){
    $this->expectException(InvalidArgumentException::class);

    new DocumentStatus('foo', 'bar');
  }
}
