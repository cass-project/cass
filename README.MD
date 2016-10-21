CASS
====

CASS - это рабочее название проекта.

Yoozer – брендовое название проекта.

Не используйте нигде кроме исключительных случаях название "yoozer" в качестве чего-либо вообще.

ВАЖНО: Для пользователей IDE от JetBrains
-----------------------------------------

Для того, чтобы JetBrains не индексировал автосгененированный бандл при каждой его пересборке, щелкните правой кнопкой 
на директории `$PROJECT_ROOT/src/www/app/dist/bundles` и исключите директорию из индекса: `Mouse 2 Click` > `Mark Directory As` > `Excluded`

Как поднять проект
------------------

Мы используем Vagrant: [https://www.vagrantup.com/]() для поднятия виртуальных машин.

### Создание виртуальной машины

1. Установите Vagrant: [https://www.vagrantup.com/]()
2. Установите VirtualBox: [https://www.virtualbox.org/]()
3. С помощью консоли перейдите в директорию проекта (далее `$PROJECT_ROOT`)
4. `git pull && git submodule init && git submodule update && git submodule status`
5. Скопируйте Vagrant-file:
    - `cp ./support-files/vagrant-files/unix/Vagrantfile .` (для Linux/OSX)
    - `cp ./support-files/vagrant-files/windows/Vagrantfile .` (для Windows)
    - `cp ./support-files/vagrant-files/sf/Vagrantfile .` (Shared Folders)
6. Выполните `vagrant up`
    - Если вы используете Windows и используете файл `./support-files/vagrant-files/windows/Vagrantfile`, то необходимо 
      запускать эту команду от администратора
6. Зайдите на виртуальную машину: `vagrant ssh`
7. Выполните команду: `sudo vm-init.sh`

### Сборка фронтенда

Сборка фронтенда производится в отдельном порядке на хостовой (реальной) машине.

1. Установите Node.JS (Latest): [https://nodejs.org/en/]()
2. Установить `n`: 
```
    sudo npm install -g n
    sudo n 5.11.1
```
3. Установить webpack, typings: `sudo npm install -g typings webpack`
4. Перейдите в директорию фронтенда: `{PROJECT_ROOT}/src/frontend`
5. Выполните установку тайпингсов: `typings install`
6. Соберите фронтенд: `webpack --progress`

### Проверка работоспобности

1. После выполнения проверьте работоспособность, открыв в браузере:
 - Проект: [http://127.0.0.1:8080/]()
 - Backend-документацию: [http://127.0.0.1:8080/api-docs/]()
 
### Разворачивание тестовых данных

`cass-console stage:demo:migrate`

Предупреждение: данная команда будет выполняться очень долго (от 30 минут).

Основные консольные утилиты
---------------------------

- `sudo vm-init.sh` – инициализирует виртуальную машину и разворачивает проект. Использовать ее нужно только один раз.
- `sudo vm-migrate.sh` – миграция; обновляет конфигурационные файлы виртуальной машины и перезапускает сервисы
- `sudo vm-reset.sh` – удаляет mysql- и mongodb-базу
- `sudo vm-backend-test.sh` – юнит-тестирование бэкенда. Используйте ее, если есть сомнения в работоспособности бэкенда
- `cass-console.sh` – консольная утилита самого проекта; предоставляет ряд сервисных инструментов и инструмент для
поднятия тестовых данных.

Обновление проекта
------------------
– `git pull && git submodule init && git submodule update && git submodule status`
- Для обновления проекта используйте команду `vm-migrate.sh`
- Для полного ресета состояния проекта используйте `vm-reset.sh`
- Для поднятия демонстрационных данных (WARNING: очень много!) выполните команду `vm-stage.sh`

При наличии проблем, связанных с использованием SMB-конфигурации:
-----------------------------------------------------------------

- Выполните следующую команду: `net config server /autodisconnect:-1`
- Если у вас все еще наблюдаются проблемы, то см. [https://www.vagrantup.com/docs/synced-folders/smb.html]()

При наличии проблем, связанных с использованием NFS-конфигурации:
-----------------------------------------------------------------

- [https://www.vagrantup.com/docs/synced-folders/nfs.html]()