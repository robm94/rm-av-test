<p align="center">Kanye quotes test app</p>

## Install/Setup

Requires Docker to be install to run application:

(If in Windows you will need to run the following commands in WSL ubuntu terminal)


1. Download repo run `git clone https://github.com/robm94/rm-av-test.git`
2. Enter the folder run `cd rm-av-test`
3. Run composer install `docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs`
4. Start containers `./vendor/bin/sail up -d`
5. Run migrations `./vendor/bin/sail artisan migrate`
6. install npm packages `./vendor/bin/sail npm install`
7. Build CSS and JS `./vendor/bin/sail npm run build`

Open http://localhost use registration form to create account and login

## Testing

Once logged in you can use the refresh and next button to hit the 2 API endpoints and see the quotes list change.

To execute feature and unit tests run `./vendor/bin/sail test`

To see the test code coverage run `./vendor/bin/sail test --coverage`

If you want to test the endpoints in postman you can get the token on the quotes page once logged in (displayed below quotes list)

Endpoints:

5 random cached quotes `http://localhost/api/quotes`

Refresh source and return 5 random quotes  `http://localhost/api/quotes/refresh`
