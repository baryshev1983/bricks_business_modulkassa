<?php
namespace Bricks\Business\ModulKassa\Document;

use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class MoneyPosition implements MoneyPositionInterface{
  private $paymentType;

  private $sum;

  public function __construct($paymentType, $sum){
    if(!in_array($paymentType, [
      MoneyPositionInterface::TYPE_CARD,
      MoneyPositionInterface::TYPE_CASH
    ])){
      throw new InvalidArgumentException(
        sprintf('Undefined payment type "%s".', $paymentType)
      );
    }

    $this->paymentType = $paymentType;
    $this->sum = $sum;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getPaymentType(){
    return $this->paymentType;
  }

  /**
   * {@inheritdoc}
   */
  public function getSum(){
    return $this->sum;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"paymentType": "%s", "sum": %01.2f}',
      $this->getPaymentType(),
      $this->getSum()
    );
  }
}
