# testblog
Symfony test blog app

Clone repository: git clone https://github.com/errand/testblog.git
Move to folder: cd testblog
Update composer bundles: composer update
Start docker container: docker-compose up
Migrate database: symfony console doctrine:migrations:migrate or mysql db < testblog.sql
OR
load fixtures
symfony console doctrine:fixtures:load
Yarn install (npm install)
Compile assets: symfony run yarn encore prod (install yarn if not installed)

Admin credentials:
/admin
admin
123
