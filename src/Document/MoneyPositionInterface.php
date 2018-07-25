<?php
namespace Bricks\Business\ModulKassa\Document;

use Bricks\Business\ModulKassa\JsonSerializableInterface;

/**
 * Список оплат, применяемых на чек.
 *
 * @author Artur Sh. Mamedbekov
 */
interface MoneyPositionInterface extends JsonSerializableInterface{
  /**
   * Безналичная оплата.
   */
  const TYPE_CARD = 'CARD';

  /**
   * Оплата наличными.
   */
  const TYPE_CASH = 'CASH';

  /**
   * @see self::TYPE_*
   *
   * @return string Тип оплаты.
   */
  public function getPaymentType();

  /**
   * @return float Сумма выбранного типа оплаты.
   */
  public function getSum();
}
