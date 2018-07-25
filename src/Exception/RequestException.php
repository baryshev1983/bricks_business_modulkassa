<?php
namespace Bricks\Business\ModulKassa\Exception;

use Bricks\Business\ModulKassa\JsonUnserializableInterface;
use DateTime;
use RuntimeException;

/**
 * @author Artur Sh. Mamedbekov
 */
class RequestException extends RuntimeException implements JsonUnserializableInterface{
  /**
   * @var string Наименование ошибки.
   */
  private $error;

  /**
   * @var string Вызванный метод.
   */
  private $path;

  /**
   * @var DateTime Дата вызова.
   */
  private $date;

  public static function fromJson($json){
    if(is_string($json)){
      $json = json_decode($json);
    }
    
    return new self(
      $json->error,
      $json->status,
      $json->message,
      $json->path,
      new DateTime($json->timestamp)
    );
  }

  public function __construct(
    $error,
    $status,
    $message,
    $path,
    DateTime $date
  ){
    parent::__construct(
      sprintf('%s:%s "%s" to %s', $status, $error, $message, $path),
      $status
    );
    $this->error = $error;
    $this->path = $path;
    $this->date = $date;
  }

  /**
   * @return string Наименование ошибки.
   */
  public function getError(){
    return $this->error;
  }

  /**
   * @return string Вызованый метод.
   */
  public function getPath(){
    return $this->path;
  }

  /**
   * @return DateTime Дата вызова.
   */
  public function getDate(){
    return $this->date;
  }
}
