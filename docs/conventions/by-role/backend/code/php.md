Стандарты кода - PHP
========================

Комментарии
-----------

- 1. Комментарии нежелательны. В вашем коде не должно быть комментариев.

- 2. Типизация переменных (для IDE) выполняйте в той же строчке, что и сам код:

    $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */

- 3. Типизация свойств в классах выполняйте стандартно, в несколько строчек:

    /**
     * @var ContainerInterface
     */
    private $container;