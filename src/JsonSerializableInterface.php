<?php
namespace Bricks\Business\ModulKassa;

/**
 * Интерфейс, описывающий сериализуемые в JSON классы.
 *
 * @author Artur Sh. Mamedbekov
 */
interface JsonSerializableInterface{
  /**
   * @return string JSON-представление объекта.
   */
  public function toJson();
}
