Конфигурация
============

- Все файлы, находящиеся в $BUNDLE_CONFIG_DIR/*.config.php автоматически подключаются перед стартом работы, 
и мерджатся в один глобальный конфиг приложения

- Дополнительно, поверх этой конфигурации подключается (если есть) конфиг ./src/backend/provide/provide.config.php

- После этого вся конфигурация приложения доступна через сервис `SharedConfigService`

Пример: конфигурация doctrine2
------------------------------

#### `./src/backend/bundles/DataBundle/config/doctrine.config.php`

```
    <?php
    return [
        'doctrine2' => [
            'connection_options'=> [
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'dbname'   => 'cass_development',
                'user'     => 'root',
                'password' => '1234'
            ],
            'isDevMode' => true
        ]
    ];
```

#### `DataBundle\src\Factory\DoctrineEntityManagerFactory`

```
    // ....
        $config = $sharedConfigService->get('doctrine2');
        $doctrineConfig = Setup::createAnnotationMetadataConfiguration($entitySourceDirs, $config['isDevMode']);
   // ...
```


