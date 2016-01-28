<?php
/*
 * If you're tired of all these overengeniered stuff you can manually run development server with command like:
 *
 *      php -S localhost:3000 server.php
 *
 * You also need to setup your environment so @see /support-files/vagrant/vagrant-bootstrap.sh
 */

define('LB_BOOTSTRAP_WWW_DIRECTORY', __DIR__);

class LBBootstrapServer
{
    const WWW_DIRECTORY = __DIR__;
    const BACKEND_PREFIX = 'backend';

    private $whiteList = [
        'favicon.ico'
    ];

    public function run() {
        if(preg_match('/\/public\//', $_SERVER["REQUEST_URI"]) || in_array($_SERVER["REQUEST_URI"], $this->whiteList)) {
            return false;
        }else if(preg_match(sprintf('/^\/%s\//', self::BACKEND_PREFIX), $_SERVER['REQUEST_URI'])) {
            require_once sprintf('%s/backend.php', self::WWW_DIRECTORY);
        }else{
            require_once sprintf('%s/frontend.html', self::WWW_DIRECTORY);
        }

        return true;
    }
}

return (new LBBootstrapServer())->run();