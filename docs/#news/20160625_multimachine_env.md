**Vagrant: multi-machine envinroment**

В вагрант-конфигурацию добавлены multi-machine envinroment, т.е. возмоджность создавать разные виртуальные машины, имитирующие разные среды (dev, stage, production).

Необходимо пересоздать машины из-за обратной несовместимости vm-* инструментов

Также изменился способ вызова vagrant up, vagrant halt, vagrant ssh и.т.д..:

БЫЛО: vagrant ssh
СТАЛО: vagrant dev ssh