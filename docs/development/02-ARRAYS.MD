02-ARRAYS
=========

В проекте доступны две "сахарные" библиотеки для работы с массивами, объектами, строками и.т.д..:

- [http://anahkiasen.github.io/underscore-php/](http://anahkiasen.github.io/underscore-php/)

- [https://github.com/cocur/chain)](https://github.com/cocur/chain)

Используйте их, например, для Map-Reduce:

```
            Chain::create(scandir($dir))
                ->filter(function($input) use ($dir) {
                    return is_file($dir.'/'.$input);
                })
                ->filter(function($input) use ($dir) {
                    return preg_match('/\.config.php$/', $input);
                })
                ->map(function($input) use ($dir) {
                    return require $dir.'/'.$input;
                })
                ->reduce(function($carry, $config) use ($sharedConfigService) {
                    $sharedConfigService->merge($config);
                })
            ;
```
