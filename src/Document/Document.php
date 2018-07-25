<?php
namespace Bricks\Business\ModulKassa\Document;

use DateTime;
use InvalidArgumentException;

class Document implements DocumentInterface{
  private $id;

  private $checkoutDateTime;

  private $docNum;

  private $docType;

  private $isPrintReceipt;

  private $email;

  private $phone;

  private $inventPositions;

  private $moneyPositions;

  private $responseUrl;

  public function __construct(
    $id,
    DateTime $checkoutDateTime,
    $docNum,
    $docType,
    $inventPositions = [],
    $moneyPositions = [],
    $email = null,
    $phone = null,
    $isPrintReceipt = false,
    $responseUrl = null
  ){
    if(!in_array($docType, [
      DocumentInterface::TYPE_SALE,
      DocumentInterface::TYPE_RETURN
    ])){
      throw new InvalidArgumentException(
        sprintf('Undefined doc type "%s".', $docType)
      );
    }

    $this->id = $id;
    $this->checkoutDateTime = $checkoutDateTime;
    $this->docNum = $docNum;
    $this->docType = $docType;
    $this->inventPositions = array_filter($inventPositions, function($candidate){
      return $candidate instanceof InventPositionInterface;
    });
    $this->moneyPositions = array_filter($moneyPositions, function($candidate){
      return $candidate instanceof MoneyPositionInterface;
    });
    $this->email = $email;
    $this->phone = $phone;
    $this->isPrintReceipt = $isPrintReceipt;
    $this->responseUrl = $responseUrl;
  }

  /**
   * Добавление товара в чек.
   *
   * @param InventPositionInterface $inventPosition Добавляемый товар.
   */
  public function addInventoryPosition(InventPositionInterface $inventPosition){
    $this->inventPositions[] = $inventPositions;
  }

  /**
   * Добавление способа платежа в чек.
   *
   * @param MoneyPositionInterface $moneyPosition Добавляемый способ платежа.
   */
  public function addMoneyPosition(MoneyPositionInterface $moneyPosition){
    $this->moneyPosition[] = $moneyPosition;
  }

  /**
   * {@inheritdoc}
   */
  public function getId(){
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getCheckoutDateTime(){
    return $this->checkoutDateTime;
  }

  /**
   * {@inheritdoc}
   */
  public function getDocNum(){
    return $this->docNum;
  }

  /**
   * {@inheritdoc}
   */
  public function getDocType(){
    return $this->docType;
  }

  /**
   * {@inheritdoc}
   */
  public function isPrintReceipt(){
    return $this->isPrintReceipt;
  }

  /**
   * {@inheritdoc}
   */
  public function getEmail(){
    return $this->email;
  }

  /**
   * {@inheritdoc}
   */
  public function getPhone(){
    return $this->phone;
  }

  /**
   * {@inheritdoc}
   */
  public function getInventPositions(){
    return $this->inventPositions;
  }

  /**
   * {@inheritdoc}
   */
  public function getMoneyPositions(){
    return $this->moneyPositions;
  }

  /**
   * {@inheritdoc}
   */
  public function getResponseUrl(){
    return $this->responseUrl;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"id": "%s", "checkoutDateTime": "%s", "docNum": "%s", "docType": "%s", "email": "%s", "inventPositions": [%s], "moneyPositions": [%s], "printReceipt": %s%s}',
      $this->getId(),
      $this->getCheckoutDateTime()->format('c'),
      $this->getDocNum(),
      $this->getDocType(),
      !is_null($this->getEmail())? $this->getEmail() : $this->getPhone(),
      implode(
        ', ',
        array_map(function(InventPositionInterface $inventPosition){
          return $inventPosition->toJson();
        }, $this->getInventPositions())
      ),
      implode(
        ', ',
        array_map(function(MoneyPositionInterface $moneyPosition){
          return $moneyPosition->toJson();
        }, $this->getMoneyPositions())
      ),
      $this->isPrintReceipt()? 'true' : 'false',
      !is_null($this->getResponseUrl())?
        sprintf(', "responseUrl": "%s"', $this->getResponseUrl())
        : ''
    );
  }
}
