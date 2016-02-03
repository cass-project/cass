cd /vagrant/www/app
php -S 0.0.0.0:3000 server.php &
cd /swagger/swagger-ui/dist
php -S 0.0.0.0:3001 &
