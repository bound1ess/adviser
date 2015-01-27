tests: ; vendor/bin/phpunit --testdox
code-coverage: ; vendor/bin/phpunit --coverage-html=coverage/
boot-server: ; php -S localhost:8000 -t coverage/
build-phar: ; box build -v ; chmod +x builds/adviser.phar
