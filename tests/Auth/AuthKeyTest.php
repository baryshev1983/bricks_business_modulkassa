<?php
namespace Bricks\Business\ModulKassa\UniTest\Auth;

use PHPUnit\Framework\TestCase;
use Bricks\Business\ModulKassa\Auth\AuthKey;

/**
 * @author Artur Sh. Mamedbekov
 */
class AuthKeyTest extends TestCase{
  public function testFromJson(){
    $data = [
      'userName' => 'login',
      'password' => 'pass',
      'name' => 'name',
      'address' => 'address',
    ];
    $json = json_encode($data);

    $auth = AuthKey::fromJson($json);
    $this->assertEquals($data['userName'], $auth->getUserName());
    $this->assertEquals($data['password'], $auth->getPassword());
    $this->assertEquals($data['name'], $auth->getName());
    $this->assertEquals($data['address'], $auth->getAddress());
  }
}
