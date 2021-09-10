## Website : Aion private server
This is a Website to manage your Aion private server on any version.

### Installation :

0. Execute : ```composer install``` on the project root

1. Create a ```.env``` file to the project root

```
APP_ENV         = production
APP_DEBUG       = false
APP_KEY         = H3vhkJ12XDwU7MQHfAY2yh7pucgndLZc
APP_URL         = https://server-aion.com
PUSHBULLET_KEY  =

DB_HOST_GS        = localhost
DB_DATABASE_GS    = aion_gs
DB_USERNAME_GS    = root
DB_PASSWORD_GS    = root

DB_HOST_LS        = localhost
DB_DATABASE_LS    = aion_ls
DB_USERNAME_LS    = root
DB_PASSWORD_LS    = root

DB_HOST_WS        = localhost
DB_DATABASE_WS    = aion_ws
DB_USERNAME_WS    = root
DB_PASSWORD_WS    = root

CACHE_DRIVER    = file
SESSION_DRIVER  = file
QUEUE_DRIVER    = sync

MAIL_DRIVER      = smtp
MAIL_HOST        = mailtrap.io
MAIL_PORT        = 2525
MAIL_USERNAME    = null
MAIL_PASSWORD    = null
```

2. Update ```APP_KEY``` on your .env file

3. Update ```APP_URL``` on your .env file

4. Update ```DB_HOST_GS | DB_HOST_LS | DB_HOST_WS``` and other for have access to databases. (You need create empty database for the website)

4. You have a config files : ```cp config/aion.exemple.php config/aion.php```

5. Execute : ```php artisan migrate```

6. After having execute the command, all databases have been modified.

7. Execute : ```php artisan db:seed```

8. After having execute the command, a sample data (news, slides) have been added.

9. Execute ```npm install``` and then ```gulp```

10. After having execute the command, all assets have been created and compile

### Apache :
The framework ships with a public/.htaccess file that is used to allow URLs without index.php. If you use Apache to serve your Laravel application, be sure to enable the mod_rewrite module.

If the .htaccess file that ships with Laravel does not work with your Apache installation, try this one:
```
Options +FollowSymLinks
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

### Nginx :
On Nginx, the following directive in your site configuration will allow "pretty" URLs:
```
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### Command .shop
There is an exemple on the WIKI : [right here](https://github.com/)

### Command .preview
There is an exemple on the WIKI : [right here](https://github.com/)

### Support :

If you have a issue, you can create a issue on github.
