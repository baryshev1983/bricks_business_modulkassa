<?php
namespace Bricks\Business\ModulKassa\Document;

use Bricks\Business\ModulKassa\JsonSerializableInterface;
use DateTime;

/**
 * Электронный чек.
 *
 * @author Artur Sh. Mamedbekov
 */
interface DocumentInterface extends JsonSerializableInterface{
  /**
   * Продажа.
   */
  const TYPE_SALE = 'SALE';

  /**
   * Возврат.
   */
  const TYPE_RETURN = 'RETURN';

  /**
   * @return string Идентификатор документа.
   */
  public function getId();

  /**
   * @return DateTime Дата создания документа.
   */
  public function getCheckoutDateTime();

  /**
   * @return string Номер документа.
   */
  public function getDocNum();

  /**
   * @see self::TYPE_*
   *
   * @return string Тип документа.
   */
  public function getDocType();

  /**
   * @return bool true - если необходима печать бумажного чека.
   */
  public function isPrintReceipt();

  /**
   * @return string|null Email покупателя.
   */
  public function getEmail();

  /**
   * @return string|null Телефон покупателя.
   */
  public function getPhone();

  /**
   * @return InventPositionInterface[] Список товаров чека.
   */
  public function getInventPositions();

  /**
   * @return MoneyPositionInterface[] Список оплат чека.
   */
  public function getMoneyPositions();

  /**
   * @return string|null URL для подтверждения успешной фискализации.
   */
  public function getResponseUrl();
}
