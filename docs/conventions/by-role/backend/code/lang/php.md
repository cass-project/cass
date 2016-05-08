Стандарты кода - PHP
====================

- Обязателен отступ в 1 строку перед `return`
- Не используйте никакие header-комментарии в начале файла или класса
– Добавляйте пробел в Return type declarations: `public function getRequest(): ServerRequestInterface`
- Всегда указывайте область видимости (`public`, `protected`, `private`) методов и свойств класса
– Не используйте выравнивание в массивах (`"foo"     => "bar"` -> `"foo" => "bar"`)
- Название свойств классов, переменных, названия классов, методов и функций должны быть в формате *camelCase*: `$myCollection`, `$this->profileId`, `isProfileInitialized()`
- Ключи в JSON-ответах должны быть в формате *underscore*: `in_initialized`, `profile_id`, `attachment_ids`

Один класс - не всегда один файл
--------------------------------

- Разрешено использовать в файле дефиниции сразу нескольких классов/интерфейсов.
- Еще более приветствуется использование анонимных классов (новая фича PHP7: [http://php.net/manual/en/language.oop5.anonymous.php](http://php.net/manual/en/language.oop5.anonymous.php)

Комментарии
-----------

- Комментарии нежелательны. В вашем коде не должно быть комментариев.
- Типизация переменных (для IDE) выполняйте в той же строчке, что и сам код:

    `$sharedConfigService = $container->get(ConfigService::class); /** @var ConfigService $sharedConfigService */`
- Типизация свойств в классах выполняйте стандартно, в несколько строчек:
    /**
     * @var ContainerInterface
     */
    private $container;
    
Null coalesce operator
----------------------
- Не используйте конструкцию `isset($arr['foo']) ? $arr['foo'] : null`. 
- Используйте Null Coalesce Operator: `$arr['foo'] ?? null`
- [http://php.net/manual/ru/migration70.new-features.php#migration70.new-features.null-coalesce-op](http://php.net/manual/ru/migration70.new-features.php#migration70.new-features.null-coalesce-op)
- [http://www.lornajane.net/posts/2015/new-in-php-7-null-coalesce-operator](http://www.lornajane.net/posts/2015/new-in-php-7-null-coalesce-operator)
    
Doctrine2
---------

- Инжектирование `EntityManager` в сервисы, миддлвари и прочий клиентский код *строго запрещено*.
- Вместо `EntityManager` инжектируйте непосредственно репозитории.

Doctrine2, Entity: Filter&Validation convention
-----------------------------------------------

1. **Фильтрация** данных производится в сеттерах сущностях
2. **Валидация** данных производится в отдельных классах-валидаторах