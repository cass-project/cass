**Frontend: Session**

На фронтенде вместо AuthService, CurrentAccountService, CurrentProfileService и прочих Current* теперь появился специальный сервис **Session**, который хранит информацию и методы о текущей сессии.

Просьба при дальнейшей разрабокте избавляться от CurrentAccountService и использовать Session.