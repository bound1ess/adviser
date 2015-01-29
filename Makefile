tests: ; vendor/bin/phpunit
code-coverage: ; vendor/bin/phpunit --coverage-html=coverage/
boot-server: ; php -S localhost:8000 -t coverage/
build-phar: ; vendor/bin/box build ; chmod +x builds/adviser.phar
