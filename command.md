# Create Applicatio
composer create-project laravel/laravel application-name
# Run Application
>>php artisan serve --port=8888

# Route in app
- [routes/web.php]
Get Route
Post Route
Route to View
Route to Function
Route and Redirect

# Views 
- [resource/views/]
blade layout
add section as different page
Default errors view for error handling

# Database setup 
in .env file change the DB_CONNECTION=mysql veriables values
to setup database

## Create and Edit Migration

>>php artisan make:migration migration_name

open file from database/migrations and edit schema structure
after successfull edit of schema

run file
>>php artisan migrate

to re run updated migration file first get back to orginal stage
>> php artisan migrate:rollback 
 
and then re run migrate code

# Model
in Models folder add how schema will be read

Your Table name should be in plural and Model name in sigular

>> php artisan make:model table

If not then have to add table name in Model
>> public $table="table_name";
    public $timestamps = false;

# Change of Composer
add requiremnt in composer.json
then to update composer.lock file run

composer update

Or run only
composer require requirement_file

composer remove reliese/laravel

# Seeder 

>> php artisan make:seeder UserSeeder

>> php artisan db:seed --class UserSeeder

# Controller

>> php artisan make:controller UserController

# Middleware

>> php artisan make:middleware UserAuth

# Static function
// if this function use in blade header we have to add a static before the function

this func may need to access the value in Others of main blade

