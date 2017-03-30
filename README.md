<h3>Система обмена дисками</h3>
<hr>
1. Для развертывания сайта необходимо скачать и распаковать архив в корневую папку на хостинге.

2. В конфигурациях сервера прописать путь папке /web, чтобы она стала корнем сайта
Например: для сервера Apache2 конфигурация выглядит так:
<hr>
```html<VirtualHost *:80>
    ServerAdmin admin@example.com
    ServerName mysite.ru
    ServerAlias www.mysite.ru
    DocumentRoot /var/www/mysite.ru/web
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>```
</pre>
<hr>

3. Импортировать дамп базы данных из файла db.sql

4. В файле /config/db.php указать данные для подключения к базе данных
Пример:
<hr>
<pre>
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=имя_базы_данных',
    'username' => 'имя_пользователя',
    'password' => 'пароль',
    'charset' => 'utf8',
];
</pre>
<hr>

5. В файле /web/.htaccess прописать следующее содержимое:
<hr>
<pre>
Options +FollowSymLinks
IndexIgnore */*
RewriteEngine on

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

RewriteRule . index.php
</pre>
<hr>
