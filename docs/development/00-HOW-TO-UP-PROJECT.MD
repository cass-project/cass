00-HOW-TO-UP-PROJECT.MD
=======================

1. Установите Vagrant: [https://www.vagrantup.com/]()
2. Установите VirtualBox: [https://www.virtualbox.org/]()
3. Перейдите в директорию $PROJECT_ROOT
4. Скопируйте Vagrant-file:
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.unix.dist Vagrantfile` (для Linux/OSX)
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.windows.dist Vagrantfile` (для Windows)
    - `cp ./support-files/vagrant-files/dev/Vagrantfile.sf.dist Vagrantfile` (вы хотите дождаться выхода HL3, пока у вас пересобирается фронтэнд)
5. Выполните `vagrant up`
    - Если вы используете Windows и используете файл `Vagrantfile.windows.dist`, то необходимо запускать эту команду от администратора
6. Зайдите на виртуальную машину: `vagrant ssh`
8. Выполните команду: `vm-init`
9. После выполнения проверьте работоспособность, открыв в браузере:
 - Проект: [http://127.0.0.1:8080/]()
 - Backend-документацию: [http://127.0.0.1:8080/api-docs/]()

`chown ERR`
-----------
Не выполняйте команды `vm-init`, `vm-server-update`, `vm-project-update` с администраторсками правами! (`sudo`)

Обновление проекта
------------------
- При изменении конфигирации (`./src/support-files/env/$ENV/root`) для обновления VM используйте команду `vm-server-update`
- Для пересборки/обновления проекта используйте команду `vm-project-update`

При наличии проблем, связанных с использованием SMB-конфигурации:
-----------------------------------------------------------------

- Выполните следующую команду: `net config server /autodisconnect:-1`
- Если у вас все еще наблюдаются проблемы, то см. [https://www.vagrantup.com/docs/synced-folders/smb.html]()

При наличии проблем, связанных с использованием NFS-конфигурации:
-----------------------------------------------------------------

- [https://www.vagrantup.com/docs/synced-folders/nfs.html]()