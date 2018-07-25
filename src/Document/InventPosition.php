<?php
namespace Bricks\Business\ModulKassa\Document;

use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class InventPosition implements InventPositionInterface{
  private $name;

  private $price;

  private $quantity;

  private $barcode;

  private $vatTag;

  private $discSum;

  public function __construct(
    $name,
    $price,
    $quantity,
    $vatTag,
    $barcode = null,
    $discSum = null
  ){
    if(!in_array($vatTag, [
      InventPositionInterface::VAT_NO,
      InventPositionInterface::VAT_0,
      InventPositionInterface::VAT_10,
      InventPositionInterface::VAT_18,
      InventPositionInterface::VAT_10_110,
      InventPositionInterface::VAT_18_118,
    ])){
      throw new InvalidArgumentException(
        sprintf('Undefined vat tag "%s".', $vatTag)
      );
    }

    $this->name = $name;
    $this->price = $price;
    $this->quantity = $quantity;
    $this->vatTag = $vatTag;
    $this->barcode = $barcode;
    $this->discSum = $discSum;
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
  public function getPrice(){
    return $this->price;
  }

  /**
   * {@inheritdoc}
   */
  public function getQuantity(){
    return $this->quantity;
  }

  /**
   * {@inheritdoc}
   */
  public function getBarcode(){
    return $this->barcode;
  }

  /**
   * {@inheritdoc}
   */
  public function getVatTag(){
    return $this->vatTag;
  }

  /**
   * {@inheritdoc}
   */
  public function getDiscSum(){
    return $this->discSum;
  }

  /**
   * {@inheritdoc}
   */
  public function toJson(){
    return sprintf(
      '{"name": "%s", "price": %01.2f, "quantity": %01.3f, "vatTag": %s%s%s}',
      $this->getName(),
      $this->getPrice(),
      $this->getQuantity(),
      $this->getVatTag(),
      !is_null($this->getBarcode())?
        sprintf(', "barcode": "%s"', $this->getBarcode())
        : '',
      !is_null($this->getDiscSum())?
        sprintf(', "discSum": %01.2f', $this->getDiscSum())
        : ''
    );
  }
}
