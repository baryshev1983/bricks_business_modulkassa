# Ассоциация

Для выполнения ассоциации (связки) магазина с розничной точкой, используется метод `GatewayInterface::associate`, принимающий сгенерированную в личном кабинете ключевую пару и идентификатор розничной точки. В случае успех, метод возвращает экземпляр `Auth\AuthKeyInterface`, содержащий ключевую пару для дальнейшего взаимодействия с онлайн-кассой.

**Важно**: данный метод обновляет ключевую пару и должен быть выполнен единожды с сохранением результата.

Пример:

```php
namespace MyPackage;

use Bricks\Business\ModulKassa\GuzzleGateway;

$gateway = new GuzzleGateway([
    'url' => 'https://service.modulpos.ru/api/fn',
]);

$auth = $gateway->associate('login', 'password', '44682f49-664d-42f0-9966-c56fd4493d63');

$gateway->setAuthKey(
    $auth->getUserName(),
    $auth->getPassword()
);

...
```

# Запрос статуса подключения

Метод `GatewayInterface::status` позволяет запросить статус подключения розничной точки.

Пример:

```php
namespace MyPackage;

use Bricks\Business\ModulKassa\GuzzleGateway;
use Bricks\Business\ModulKassa\Auth\StatusInterface;

$gateway = new GuzzleGateway([
    'url' => 'https://service.modulpos.ru/api/fn',
]);
$gateway->setAuthKey('login', 'password');

if($gateway->status()->getStatus() === StatusInterface::STATUS_READY){
    ...
}
```

# Регистрация документа

Для регистрации электронного чека используется метод `GatewayInterface::doc`, принимающий экземпляр `Document\DocumentInterface`.

Пример:

```php
namespace MyPackage;

use Bricks\Business\ModulKassa\GuzzleGateway;
use Bricks\Business\ModulKassa\Document\DocumentInterface;
use Bricks\Business\ModulKassa\Document\Document;
use Bricks\Business\ModulKassa\Document\InventPositionInterface;
use Bricks\Business\ModulKassa\Document\InventPosition;
use Bricks\Business\ModulKassa\Document\MoneyPositionInterface;
use Bricks\Business\ModulKassa\Document\MoneyPosition;
use DateTime;

$gateway = new GuzzleGateway([
    'url' => 'https://service.modulpos.ru/api/fn',
]);
$gateway->setAuthKey('login', 'password');

$document = new Document(
    '1',
    new DateTime,
    '1',
    DocumentInterface::TYPE_SALE,
    [
        new InventPosition(
            'Product name',
            5,
            1,
            InventPositionInterface::VAT_NO
        )
    ],
    [
        new MoneyPosition(
            MoneyPositionInterface::TYPE_CARD,
            5
        )
    ],
    'artur-mamedbekov@yandex.ru'
);
$gateway->doc($document);
```

# Проверка состояния документа

Метод `GatewayInterface::docStatus` позволяет проверить текущее состояние регистрации электронного чека.

Пример:

```php
namespace MyPackage;

use Bricks\Business\ModulKassa\GuzzleGateway;
use Bricks\Business\ModulKassa\Document\DocumentStatusInterface;

$gateway = new GuzzleGateway([
    'url' => 'https://service.modulpos.ru/api/fn',
]);
$gateway->setAuthKey('login', 'password');

$status = $gateway->docStatus('5');
if($status->getStatus() === DocumentStatusInterface::STATUS_COMPLETED){
    ...
}
```
