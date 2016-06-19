# The Local Times

##


###### This is web application for, in which user can publish article and download them as PDF file. The user can register and have access to publish article and delete it 



Setup Guide:
 * Please check this website for server requirements https://laravel.com/docs/5.2#server-requirements
 * Place the extracted contents to root web accessible folder
 * Run below command
```
$   composer update && composer install
```

 * Enable php gd Extension
 * Give writable permissions to 'storage' folders
 * Give writable permissions to 'public' folders
 * Make sure that your php executable is in your path/environment variables
 * Open .env file and add the database credentials and SMTP mail details without which the application may fail
 * Run below command
```
$   php artisan migrate
```

 * Change the APP_URL as same as your domain path
   For eg. if the domain name is http://example.com, then set it as http://example.com
 * Run below command
 ```
 $ php artisan optimize
 ```
 
 * Now access your domain, you should see the application