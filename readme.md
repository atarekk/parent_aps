
## Parent Aps task
<h1>Steps</h1>
- git clone https://github.com/atarekk/parent_aps.git <br>
- cd project_name <br>
- composer update <br>
- cp .env.example .env <br>
- chmod 777 -R storage <br>
- add database config in .env file <br>
- to make migration : php artisan migrate <br>
- to create email and password to access api : php artisan make:seeder UserTableSeeder <br>
- you should run the passport:install command. This command will create the encryption keys needed to generate secure access tokens <br>
- to run dev server : php artisan serve <br>
- get postman collection <a href="https://drive.google.com/open?id=1S8xDXy7UY0EDyGYdB23u1zTwhBd0V9Tm">Postman collection</a>
- use login route to get token (email :admin@admin.com / password:password) <br>
