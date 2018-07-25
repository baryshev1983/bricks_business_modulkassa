<?php
namespace Bricks\Business\ModulKassa\Auth;

/**
 * @author Artur Sh. Mamedbekov
 */
class AuthKey implements AuthKeyInterface{
  private $userName;

  private $password;

  private $name;

  private $address;

  /**
   * {@inheritdoc}
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }

    return new self(
      $json->userName,
      $json->password,
      $json->name,
      $json->address
    );
  }

  public function __construct($userName, $password, $name, $address){
    $this->userName = $userName;
    $this->password = $password;
    $this->name = $name;
    $this->address = $address;
  }

  /**
   * {@inheritdoc}
   */
  public function getUserName(){
    return $this->userName;
  }

  /**
   * {@inheritdoc}
   */
  public function getPassword(){
    return $this->password;
  }

  /**
   * {@inheritdoc}
   */
  public function getName(){
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function getAddress(){
    return $this->address;
  }
}
