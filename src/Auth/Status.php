<?php
namespace Bricks\Business\ModulKassa\Auth;

use DateTime;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class Status implements StatusInterface{
  private $status;

  private $statusDateTime;

  /**
   * {@inheritdoc}
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }

    return new self(
      $json->status,
      new DateTime($json->dateTime)
    );
  }

  public function __construct($status, DateTime $statusDateTime){
    if(!in_array($status, [
      StatusInterface::STATUS_READY,
      StatusInterface::STATUS_ASSOCIATED,
      StatusInterface::STATUS_FAILED
    ])){
      throw new InvalidArgumentException(
        sprintf('Undefined status "%s".', $status)
      );
    }

    $this->status = $status;
    $this->statusDateTime = $statusDateTime;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatus(){
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function getStatusDateTime(){
    return $this->statusDateTime;
  }
}
