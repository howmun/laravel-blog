<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    DB::listen(function ($query) {
        // logger($query->sql); // obstructed
        logger($query->sql, $query->bindings); //show the value of ?
    });

    // $files = File::files(resource_path("posts"));
    # array_map approach
    // $posts = array_map(function ($file) {
    //     $document = YamlFrontMatter::parseFile($file);
    //     return new Post(
    //         $document->title,
    //         $document->excerpt,
    //         $document->date,
    //         $document->body(),
    //         $document->slug
    //     );
    // }, $files);

    // foreach ($files as $file) {

    //     $document = YamlFrontMatter::parseFile($file);

    //     $posts[] = new Post(
    //         $document->title,
    //         $document->excerpt,
    //         $document->date,
    //         $document->body(),
    //         $document->slug
    //     );
    // }

    return view('posts', [
        // 'posts' => Post::all() // has n+1 problem
        'posts' => Post::with('category')->get() // solved n+1
    ]);
});

// Route::get('/posts/{post}', function ($id) {
// Route::get('/posts/{post}', function (Post $post) { # get post by id
Route::get('/posts/{post:slug}', function (Post $post) { #get post by slug
    // $post = Post::find($slug);
    // ddd($post);
    return view('post', [
        // 'post' => Post::find($id)
        'post' => $post
    ]);
});
// $path = __DIR__ . "/../resources/posts/{$slug}.html";

// if (!file_exists($path)) {
//     // ddd('file not exists');
//     // abort(404);
//     return redirect('/');
// }

# can just put 5 for 5 seconds instead of now()->addSeconds(5)
# the function () use () is before php 7.4, after that got arrow function d
// $post = cache()->remember("posts.{$slug}", now()->addSeconds(5), function () use ($path) {
//     var_dump('missed cached!');
//     return file_get_contents($path);
// });

# Arrow function style
// $post = cache()->remember(
//     "posts.{$slug}",
//     now()->addSeconds(5),
//     fn () =>
//     file_get_contents($path)
// );

// return view('post', [
//     'post' => $post
// ]);
# where capital or small A to Z char, or underscore or dash (escape - since it could mean A-Z)
# + means could be multiple
//})->where('post', '[A-z_\-]+'); #constraint with reg expression

Route::get('categories/{category:slug}', function (Category $category) {
    // ddd($category);
    return view('posts', [
        'posts' => $category->posts
    ]);
});
