04-API-DOCS.MD
==============

О документации REST API
-----------------------

- Все публичное и доступное для фронтенд-разработчиков REST API должно быть задокументировано.

- Мы используем Swagger в качестве инструмента документирования / отображения документации REST API

- Вся документация по REST API описывается в одном JSON-ответе нашего сервера.

Как добавить новую документацию?
--------------------------------

В каждом бандле можно создать директорию `api-docs`, в которой вы можете:

- Создать файл `global.yml`, чье содержимое мерждится в корень всего JSON-конфига документации.

- Создать директорию `paths`, `definitions` и.т.д.. и размещать в произвольной файловой структуре `*.yml`-конфигурации, 
которые мерджатся в `/{PREFIX}` JSON-конфига документации. Данное поведение (меджр с префиксом) сохраняется только для
первого уровня директории: все вложенные в поддиректории файлы мерджатся в тот же самый префикс.

Ссылки
------

- API Docs: [http://127.0.0.1:8080/api-docs/](http://127.0.0.1:8080/api-docs/)

- OpenAPI Specification: [https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md](https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md)

- Swagger Editor: [http://editor.swagger.io/#/](http://editor.swagger.io/#/)

- Swagger Editor, Paste JSON: [http://127.0.0.1:8080/backend/api/debug/api-docs/api-docs.json](http://127.0.0.1:8080/backend/api/debug/api-docs/api-docs.json)