05-AUTH.MD
==========

1. Все URL с маской `/backend/api/protected/*` предпринимают попытки аутентификации и в случае невозможности аутентификации завершают работу
приложения и выдают JSON-ответ с ошибкой.

3. Для доступа к информации о текущем аккаунте на бэкенде: инжектируйте сервис `CASS\Domain\Bundles\Auth\Service\CurrentAccountService` и вызовите
 метод `getAccount()`. 
 
4. Для доступа к информации о текущем аккаунте на фронтенде: используйте сервис `AuthService`, `AuthToken`. Информация о текущем 
пользователе и api-ключе хранится в `AuthToken`