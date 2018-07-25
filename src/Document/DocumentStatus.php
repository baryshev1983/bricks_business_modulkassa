<?php
namespace Bricks\Business\ModulKassa\Document;

use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class DocumentStatus implements DocumentStatusInterface{
  private $status;

  private $fnState;

  /**
   * {@inheritdoc}
   */
  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }

    return new self(
      $json->status,
      $json->fnState
    );
  }

  public function __construct($status, $fnState){
    if(!in_array($status, [
      DocumentStatusInterface::STATUS_QUEUED,
      DocumentStatusInterface::STATUS_PENDING,
      DocumentStatusInterface::STATUS_PRINTED,
      DocumentStatusInterface::STATUS_COMPLETED,
      DocumentStatusInterface::STATUS_FAILED,
    ])){
      throw new InvalidArgumentException(
        sprintf('Undefined status "%s".', $status)
      );
    }

    $this->status = $status;
    $this->fnState = $fnState;
  }

  public function getStatus(){
    return $this->status;
  }

  public function getFnState(){
    return $this->fnState;
  }
}
