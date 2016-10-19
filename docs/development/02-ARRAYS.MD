02-ARRAYS
=========

В проекте доступна "сахарная" библиотека для работы с массивами, объектами, строками и.т.д..:

- [https://github.com/cocur/chain)](https://github.com/cocur/chain)

Используйте ее, например, для Map-Reduce:

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
