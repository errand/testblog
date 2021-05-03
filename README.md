# testblog
Symfony test blog app

1. Clone repository: **git clone https://github.com/errand/testblog.git**
2. Move to folder: **cd testblog**
3. Update composer bundles: **composer update**
4. Start docker container: **docker-compose up**
5. Migrate database: **symfony console doctrine:migrations:migrate** (or **mysql db < testblog.sql**) 
6. load fixtures: **symfony console doctrine:fixtures:load**
7. **Yarn install** (npm install)
8. Compile assets: **symfony run yarn encore prod** (install yarn if not installed)

Admin credentials:
/admin
admin
123
