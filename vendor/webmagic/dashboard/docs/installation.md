# Installation

Webmagic Dashboard is an opensource packages available in packagist

## Install the package
Call ``composer require webmagic/dashboard`` to install the package.

As alternative add package to ``composer.json`` file
```json
    ...
   "require": {
           "webmagic/dashboard": "3.1.*"
       },
    ...
```

You can also use development branch. In this case you need to add the next
```json
    ...
    "require": {
           "webmagic/dashboard": "v3.1.x-dev"
       },
    ...
```

Call ``composer update`` after the package adding

## Publishing assets and other
After the package installed you have few possibilities to publish assets

For publishing minimal files (assets and configuration file) use the next command
```bash
php artisan vendor:publish --tag=webmagic/dashboard::min
```
Call this command for publishing all files together with views and translations
```bash
 php artisan vendor:publish --tag=webmagic/dashboard::all
```
Also you can call standard Laravel publish function and choose needed option from the list
```bash
php artisan vendor:publish
``` 

## Assets updating
You may need to updated assets if you had previous version of the package. For doing this call this command
```bash
php artisan dashboard:assets-update
```

## Configuration
After the configuration file published you have possibility to change some common dashboard options. 
The most complex of the options is ``menu`` option. This option gives possibility to fully configure the left sidebar menu. 
See the [main menu description](main-menu) for more details