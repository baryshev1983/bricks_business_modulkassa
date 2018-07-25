<?php
namespace Bricks\Business\ModulKassa\Document;

use Bricks\Business\ModulKassa\JsonSerializableInterface;

/**
 * Товар на оплату в чеке.
 *
 * @author Artur Sh. Mamedbekov
 */
interface InventPositionInterface extends JsonSerializableInterface{
  /**
   * НДС не облагается.
   */
  const VAT_NO = 1105;

  /**
   * НДС 0%.
   */
  const VAT_0 = 1104;

  /**
   * НДС 10%.
   */
  const VAT_10 = 1103;

  /**
   * НДС 18%.
   */
  const VAT_18 = 1102;

  /**
   * НДС 10/110.
   */
  const VAT_10_110 = 1107;

  /**
   * НДС 18/118.
   */
  const VAT_18_118 = 1106;

  /**
   * @return string Наименование товара.
   */
  public function getName();

  /**
   * @return float Цена позиции товара.
   */
  public function getPrice();

  /**
   * @return float Количество товара.
   */
  public function getQuantity();

  /**
   * @return string|null Штрихкод товара.
   */
  public function getBarcode();

  /**
   * @see self::VAT_*
   *
   * @return int Тег НДС согласно ФЗ-54.
   */
  public function getVatTag();

  /**
   * @return float|null Сумма скидки.
   */
  public function getDiscSum();
}
