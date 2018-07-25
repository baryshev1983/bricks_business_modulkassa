<?php
namespace Bricks\Business\ModulKassa\Document;

use Bricks\Business\ModulKassa\JsonUnserializableInterface;

/**
 * Статус обработки документа.
 *
 * @author Artur Sh. Mamedbekov
 */
interface DocumentStatusInterface extends JsonUnserializableInterface{
  /**
   * Принят в очередь на обработку.
   */
  const STATUS_QUEUED = 'QUEUED';

  /**
   * Получен кассой для печати.
   */
  const STATUS_PENDING = 'PENDING';

  /**
   * Фискализован.
   */
  const STATUS_PRINTED = 'PRINTED';

  /**
   * Результат фискализации отправлен в сервис-источник.
   */
  const STATUS_COMPLETED = 'COMPLETED';

  /**
   * Ошибка при фискализации.
   */
  const STATUS_FAILED = 'FAILED';

  /**
   * @see self::STATUS_*
   *
   * @return string Статус обработки.
   */
  public function getStatus();

  /**
   * @return string Текущее состояние ФН.
   */
  public function getFnState();
}
