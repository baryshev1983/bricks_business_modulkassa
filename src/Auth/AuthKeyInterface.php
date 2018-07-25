<?php
namespace Bricks\Business\ModulKassa\Auth;

use Bricks\Business\ModulKassa\JsonUnserializableInterface;

/**
 * Ключ аутентификации.
 *
 * @author Artur Sh. Mamedbekov
 */
interface AuthKeyInterface extends JsonUnserializableInterface{
  /**
   * @return string Логин пользователя.
   */
  public function getUserName();

  /**
   * @var string Пароль пользователя.
   */
  public function getPassword();

  /**
   * @return string Имя пользователя.
   */
  public function getName();

  /**
   * @return string Адрес пользователя.
   */
  public function getAddress();
}
