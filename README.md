# Slotegrator

### How to run
1. Clone the source: ```git clone https://github.com/idetinkin/slotegator ./```
2. Change permissions for runtime folders: 
```
chmod 777 -R app/frontend/runtime
chmod 777 -R app/console/runtime
```
3. Run Docker: ```docker-compose up -d```
4. Connect to the docker container "php": ```docker-compose exec php bash```

#### Inside the docker container run:
1. Update composer: ```composer update```
1. Initialize config: ```./init --env=Development --overwrite=All --delete=All```
1. Apply database migrations: ```./yii migrate```

The website now is available by http://localhost:8100/

To use it, you need to Signup and then to Login

### Commands available inside the docker container "php"
* ```./yii prize/deliver-thing 5``` - set status to Delivered for the prize thing with ID=5
* ```./yii prize/deliver-money-batch 3``` - deliver 3 oldest money prizes
* ```php vendor/bin/codecept run frontend/tests/unit/components/prize/prizeHelpers/MoneyPrizeHelperTest``` - run unit tests
