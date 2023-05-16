
- php >= 7.4
- composer install
- edit .env file
- php artisan clear:cache
- php artisan optimize


 change public path => root path

- root\server.php  => index
- root\resources\views\vendor\adminlte\plugin.blade.php  => +/public/
- root\resources\views\vendor\adminlte\master.blade.php  => +/public/
- root\resources\views\vendor\adminlte\auth\login.blade.php => +/public/
- root\config\adminlte.php => +/public/

ex add plugin

php artisan adminlte:plugins install --plugin=tempusdominusBootstrap4