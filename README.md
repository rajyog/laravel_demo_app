# laravel_demo_app
 
# Some useful CMD commands

**Move one directory to another directory**

H:

**This command list directory names are available in current position**

dir

**Move one directory to another directory**

cd xampp/htdocs

# Laravel CRUD Operation

**How to create laravel project**

composer create-project laravel/laravel laravel_demo

**Move to the project directory**

cd laravel_demo


**Configure database to the .env file**

DB_DATABASE=laravel_demo<br>
DB_USERNAME=root<br>
DB_PASSWORD=root<br>

**Error reporting block in php**

ini_set('display_errors', '1');<br>
ini_set('display_startup_errors', '1');<br>
error_reporting(E_ALL);<br>

**Run Laravel project**

php artisan serve

**how to run laravel project without public folder**

Rename server.php in your Laravel root folder to index.php<br>
Copy the .htaccess file from /public directory to your Laravel root folder.

**create database in phpmyadmin**

laravel_demo

**Migrate database**

php artisan migrate

**Now create a custom controller**

php artisan make:controller CustomAuthController

**After add below namespaces**

use Hash;<br>
use Session;<br>
use App\Models\User;<br>
use Illuminate\Support\Facades\Auth;<br>

Then copy Custom auth controller from file<br>

**Then open routes/web.php file**

Add controller name in file

use App\Http\Controllers\CustomAuthController;

**Copy below route in web.php file**

Route::get('dashboard', [CustomAuthController::class, 'dashboard']); <br>
Route::get('login', [CustomAuthController::class, 'index'])->name('login');<br>
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');<br> 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');<br>
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');<br> 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');<br>




https://www.itsolutionstuff.com/post/laravel-8-multi-auth-authentication-tutorialexample.html

https://www.cloudways.com/blog/create-laravel-blade-layout/

https://www.positronx.io/laravel-custom-authentication-login-and-registration-tutorial/

https://www.positronx.io/php-laravel-crud-operations-mysql-tutorial/

https://www.positronx.io/create-multi-auth-authentication-in-laravel/

https://www.tutsmake.com/laravel-8-crud-example-tutorial/






