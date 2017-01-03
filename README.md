# Cap Sniffer Api
Cap sniffer api is an api build in Silex to get training plan of running

# Installation
Start by cloning this repository:
```
$ git clone git@github.com:unikorp/cap-sniffer-api.git
```

Build app with docker:
```
docker-compose up -d
```

Then, you can install the dependencies (connect on php container first):
```
composer install
```

Update config params in `resources/config/prod.php`

# Api
Got to the url api doc: [http://localhost:8080/api/doc](http://localhost:8080/api/doc)
