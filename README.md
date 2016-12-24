# Cap Sniffer Api
Cap sniffer api is an api build in Silex to get training plan of running
# Prerequisites
Install composer to load dependencies
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '61069fe8c6436a4468d0371454cf38a812e451a14ab1691543f25a9627b97ff96d8753d92a00654c21e2212a5ae1ff36') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
# Installation
Start by cloning this repository:
```
$ git clone git@github.com:nbremont/cap-sniffer-api.git
```
Then, you can install the dependencies:
```
composer install