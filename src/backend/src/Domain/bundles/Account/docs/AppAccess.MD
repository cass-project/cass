AppAccess
=========

Каждый аккаунт может быть подключен к определенным администраторским приложениям.

На данный момент администраторских приложений 3:

- admin – CASS.Admin
- reports – CASS.Reports
- feedback – CASS.Feedback

Для того, чтобы подключить пользователя к приложению, необходимо добавить запись в таблицу account_app_acccess:

    {account_id}, {appAdmin}, {appFeedback}, {appReports}