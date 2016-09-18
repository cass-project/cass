Стандарты кода - javascript
===========================

- Обязателен отступ в 1 строку перед `return`
- Не используйте никакие header-комментарии в начале файла 
- Использование `var` нежелательно. Используйте `let` либо `const`. См.: [http://madhatted.com/2016/1/25/let-it-be](http://madhatted.com/2016/1/25/let-it-be)
- Важно: const - ​это не константы!​ См.:
    - EN: [https://mathiasbynens.be/notes/es6-const](https://mathiasbynens.be/notes/es6-const)
    - RU: [http://frontender.info/const-immutability/#codeconstcodesozdatneizmenyaemuyusvyazy](http://frontender.info/const-immutability/#codeconstcodesozdatneizmenyaemuyusvyazy)

Фигурные скобки
---------------

- В классах, интерфейсах: открываюшая фигурная скобка на новой строке
- В методах, коллбэках, функциях: открывающая фигурная скобка на той же строке
- Существуют исключения: 
  * В REST-сервисах в методах открывающая фигурная скобка находится на новой строке