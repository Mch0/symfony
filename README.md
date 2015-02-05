> sudo mkdir tgw

> sudo git clone https://github.com/Mch0/symfony.git tgw/

> php composer.phar install ou curl -sS https://getcomposer.org/installer | php

> php composer.phar update

> dans la base de donné CREATE DATABASE tgw

> dans tgw créer .htacces

> SetEnv SHORT_OPEN_TAGS 0
  SetEnv REGISTER_GLOBALS 0
  SetEnv MAGIC_QUOTES 0
  SetEnv SESSION_AUTOSTART 0
  SetEnv ZEND_OPTIMIZER 1
  SetEnv PHP_VER 5_3
  SetEnv SESSION_USE_TRANS_SID 0

  <IfModule mod_rewrite.c>
      RewriteEngine On
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteRule ^(.*)$ web/$1 [QSA,L]

  </IfModule>

  > tgw/web/.htacces

  >  #RewriteRule .? %{ENV:BASE}/app.php [L]
        RewriteRule .? %{ENV:BASE}/app_dev.php [L]