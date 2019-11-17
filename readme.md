
## Parent Aps task
<h1>Steps</h1>
- git clone https://github.com/atarekk/parent_aps.git
- cd project_name
- composer update
- cp .env.example .env
- chmod 777 -R storage
- add database config in .env file
- to make migration : php artisan migrate
- to create email and password to access api : php artisan make:seeder UserTableSeeder
- you should run the passport:install command. This command will create the encryption keys needed to generate secure access tokens
- to run dev server : php artisan serve
- use login route to get token (email :admin@admin.com / password:password)
