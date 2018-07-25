<?php
namespace Bricks\Business\ModulKassa\Auth;

use Bricks\Business\ModulKassa\JsonUnserializableInterface;
use DateTime;

/**
 * Статус подключения.
 *
 * @author Artur Sh. Mamedbekov
 */
interface StatusInterface{
  /**
   * Готов к работе.
   */
  const STATUS_READY = 'READY';

  /**
   * Подключение установлено, но статус готовности кассы не известен.
   */
  const STATUS_ASSOCIATED = 'ASSOCIATED';

  /**
   * Проблемы при получении статуса фискализации.
   */
  const STATUS_FAILED = 'FAILED';

  /**
   * @see self::STATUS_*
   *
   * @return string Статус готовности.
   */
  public function getStatus();

  /**
   * @return DateTime Дата получения статуса готовности.
   */
  public function getStatusDateTime();
}
