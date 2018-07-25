<?php
namespace Bricks\Business\ModulKassa;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Bricks\Business\ModulKassa\Auth\AuthKey;
use Bricks\Business\ModulKassa\Auth\Status;
use Bricks\Business\ModulKassa\Document\DocumentInterface;
use Bricks\Business\ModulKassa\Document\Document;
use Bricks\Business\ModulKassa\Document\DocumentStatus;
use InvalidArgumentException;
use RuntimeException;
use Bricks\Business\ModulKassa\Exception\RequestException;

/**
 * @author Artur Sh. Mamedbekov
 */
class GuzzleGateway implements GatewayInterface{
  /**
   * @var array Опции подключения.
   */
  private $options;

  /**
   * @var ClientInterface HTTP клиент.
   */
  private $client;

  public function __construct(array $options, ClientInterface $client = null){
    if(!isset($options['url'])){
      throw new InvalidArgumentException('Not set url option');
    }
    if(is_null($client)){
      $client = new Client;
    }

    $this->options = $options;
    $this->client = $client;
  }

  /**
   * Выполняет запрос.
   *
   * @param string $method Метод вызова.
   * @param string $uri Целевой URI.
   * @param array $options [optional] Параметры запроса.
   *
   * @see ClientInterface::request
   *
   * @throws RuntimeException
   *
   * @return ResponseInterface Ответ.
   */
  protected function sendRequest($method, $uri, array $options = []){
    try{
      return $this->client->request($method, $uri, $options);
    }
    catch(GuzzleRequestException $excep){
      if(is_null($excep->getResponse())){
        throw new RuntimeException('Undefined error', 0, $excep);
      }
      else{
        $response = $excep->getResponse();
        $body = (string) $response->getBody();

        if(
          isset($response->getHeader('Content-Type')[0])
          && $response->getHeader('Content-Type')[0] == 'application/json'
        ){
          throw RequestException::fromJson($body);
        }
        else{
          throw new RuntimeException(
            sprintf(
              '%s %s: %s',
              $response->getReasonPhrase(),
              $response->getStatusCode(),
              $body
            ),
            $response->getStatusCode(),
            $excep
          );
        }
      }
    }
  }

  /**
   * Выполняет запрос с данными для авторизации.
   *
   * @param string $method Метод вызова.
   * @param string $uri Целевой URI.
   * @param array $options [optional] Параметры запроса.
   *
   * @see ClientInterface::request
   *
   * @throws RuntimeException
   *
   * @return ResponseInterface Ответ.
   */
  protected function sendAuthRequest($method, $uri, array $options = []){
    if(!isset($this->options['username'])){
      throw new RuntimeException('UserName not set for auth');
    }
    if(!isset($this->options['password'])){
      throw new RuntimeException('Password not set for auth');
    }

    return $this->sendRequest(
      $method,
      $uri,
      array_merge(
        $options,
        [
          'auth' => [
            $this->options['username'],
            $this->options['password'],
          ],
        ]
      )
    );
  }

  /**
   * Устанавливает ключ аутентификации подключения.
   *
   * @param string $username Логин.
   * @param string $password Пароль.
   */
  public function setAuthKey($username, $password){
    $this->options['username'] = $username;
    $this->options['password'] = $password;
  }

  /**
   * {@inheritdoc}
   */
  public function associate($login, $password, $retailPointId){
    return AuthKey::fromJson(
      $this->sendRequest(
        'POST',
        sprintf(
          '%s/v1/associate/%s',
          $this->options['url'],
          $retailPointId
        ),
        [
          'auth' => [
            $login,
            $password
          ],
        ]
      )->getBody()->getContents()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function status(){
    return Status::fromJson(
      $this->sendAuthRequest(
        'GET',
        sprintf(
          '%s/v1/status',
          $this->options['url']
        )
      )->getBody()->getContents()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function doc(DocumentInterface $document){
    return DocumentStatus::fromJson(
      $this->sendAuthRequest(
        'POST',
        sprintf(
          '%s/v1/doc',
          $this->options['url']
        ),
        [
          'headers' => [
            'Content-Type' => 'application/json',
          ],
          'body' => $document->toJson(),
        ]
      )->getBody()->getContents()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function docStatus($documentId){
    return DocumentStatus::fromJson(
      $this->sendAuthRequest(
        'GET',
        sprintf(
          '%s/v1/doc/%s/status',
          $this->options['url'],
          $documentId
        )
      )->getBody()->getContents()
    );
  }
}
