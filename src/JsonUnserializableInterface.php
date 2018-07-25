<?php
namespace Bricks\Business\ModulKassa;

/**
 * Интерфейс, описывающий десериализуемые из JSON классы.
 *
 * @author Artur Sh. Mamedbekov
 */
interface JsonUnserializableInterface{
  /**
   * Формирует объект из JSON.
   *
   * @param string|stdClass $json Исходный JSON.
   *
   * @return self Экземпляр класса.
   */
  public static function fromJson($json);
}
