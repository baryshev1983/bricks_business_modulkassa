<?php
namespace Bricks\Business\ModulKassa;

use Bricks\Business\ModulKassa\Auth\AuthKeyInterface;
use Bricks\Business\ModulKassa\Auth\StatusInterface;
use Bricks\Business\ModulKassa\Document\DocumentInterface;
use Bricks\Business\ModulKassa\Document\DocumentStatusInterface;
use RuntimeException;
use Bricks\Business\ModulKassa\Exception\RequestException;

/**
 * Интерфейс шлюза взаимодействия с МодульКассой.
 *
 * @author Artur Sh. Mamedbekov
 */
interface GatewayInterface{
  /**
   * Инициализирует подключение.
   *
   * @param string $login Логин инициализации.
   * @param string $password Пароль инициализации.
   * @param string $retailPointId Идентификатор продавца.
   *
   * @throws RuntimeException
   * @throws RequestException
   *
   * @return AuthKeyInterface Ключ аутентификации.
   */
  public function associate($login, $password, $retailPointId);

  /**
   * Получение статуса подключения кассы.
   *
   * @throws RuntimeException
   * @throws RequestException
   *
   * @return StatusInterface Статус подключения.
   */
  public function status();

  /**
   * Регистрация документа прихода или расхода.
   *
   * @param DocumentInterface $document Регистрируемый документ.
   *
   * @throws RuntimeException
   * @throws RequestException
   *
   * @return DocumentStatusInterface Статус обработки документа.
   */
  public function doc(DocumentInterface $document);

  /**
   * Получение статуса обработки документа.
   *
   * @param string $documentId Идентификатор целевого документа.
   *
   * @throws RuntimeException
   * @throws RequestException
   *
   * @return DocumentStatusInterface Статус обработки документа.
   */
  public function docStatus($documentId);
}
