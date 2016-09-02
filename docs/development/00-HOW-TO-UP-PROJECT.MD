00-HOW-TO-UP-PROJECT.MD
=======================

1. `git pull && git submodule init && git submodule update && git submodule status`
2. Установите Vagrant: [https://www.vagrantup.com/]()
3. Установите VirtualBox: [https://www.virtualbox.org/]()
4. Перейдите в директорию $PROJECT_ROOT
5. Скопируйте Vagrant-file:
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.unix.dist Vagrantfile` (для Linux/OSX)
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.windows.dist Vagrantfile` (для Windows)
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.sf.dist Vagrantfile` (вы хотите дождаться выхода HL3, пока у вас пересобирается фронтэнд)
6. Выполните `vagrant up dev`
    - Если вы используете Windows и используете файл `Vagrantfile.windows.dist`, то необходимо запускать эту команду от администратора
6. Зайдите на виртуальную машину: `vagrant ssh dev`
7. Выполните команду: `sudo -i`, `vm-init.sh`
8. После выполнения проверьте работоспособность, открыв в браузере:
 - Проект: [http://127.0.0.1:8080/]()
 - Backend-документацию: [http://127.0.0.1:8080/api-docs/]()

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