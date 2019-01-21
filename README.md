#### run server
php artisan serve

### set up controller npm css  .... 
php artisan make:controller PagesController
   
npm install
npm run dev  

//migrate database from tinker
php artisan make:controller PostController
php artisan make:model Post -m
php artisan migrate  

//make resources controller
php artisan make:controller PostsController --resource

//reauire collective for form 
https://laravelcollective.com/docs/master/html
composer require "laravelcollective/html":"^5.4.0"   
// require edit
https://github.com/UniSharp/laravel-ckeditor
composer require unisharp/laravel-ckeditor
....
// make image controller
php artisan make:migration add_cover_image_to_posts
php artisan migrate  
php artisan storage:link

//make auth
php artisan make:auth

//make user
php artisan make:migration add_user_id_to_posts

### shell
php artisan tinker

App\Post::count()

$post = new App\Post();
$post->title= 'Post One';
$post->body= 'This is Post Body One';
$post->save();

$post = new App\Post();
$post->title= 'Post Two';
$post->body= 'This is Post Body Two';
$post->save();




#### create a project ( version 5.7)
composer create-project --prefer-dist laravel/laravel demo

### install Laravel globally
https://getcomposer.org/doc/00-intro.md

### test Laravel
composer
php artisan --version
//Laravel Framework 5.8-dev
### reference
[1] [Laravel - Installation](https://www.tutorialspoint.com/laravel/laravel_installation.htm)
[2] [Laravel From Scratch](https://www.youtube.com/watch?v=EU7PRmCpx-0&list=PLillGF-RfqbYhQsN5WMXy6VsDMKGadrJ-)
