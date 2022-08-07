## Laravel のインストール

Laravel のインストールをします。以下のコマンドを入力して実行します。インストールが完了したら、`cd` コマンドでインストールした Laravel のプロジェクトルートに移動します。

```
// Laravel のインストール
laravel new project_name --git
```

```
// プロジェクトルートへ移動
cd project_name
```

プロジェクトルードへ移動したら、.env ファイルを開きデータベースの設定を行います。

## Laravel Breeze のインストール

Laravel での認証機能パッケージ Laravel Breeze のインストールを行います。以下のコマンドでインストールします。

```
composer require laravel/breeze
```

インストールしたら、スカフォールドと NPM 関連のインストールをコマンドで実行します。また、マイグレーションも同時に実行します。

```
php artisan breeze:install

npm install

npm run dev

php artisan migrate
```

### トップページの設定

`RouteServiceProvider.php` を開き以下のように編集

```diff
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
-    public const HOME = '/dashboard';
+    public const HOME = '/';
```

`web.php` を編集

```diff
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
-   return view('welcome');
+   return view('home');
});

- Route::get('/dashboard', function () {
-     return view('dashboard');
- })->middleware(['auth'])->name('dashboard');
```

`resources\views\welcome.blade.php` のファイル名を `home.blade.php` に変更

サンプルの ZIP ファイルを Udemy から DL して解凍。`blog_template` フォルダをまるごと `public` フォルダにコピー。 

`public\blog_template\index.html` 内のコードをコピーして、`resources\views\home.blade.php` に貼り付け。

このままでは、ページを表示された際にＣＳＳやＪＳのパスが通らないので `{{ asset('...') }}` という構文を追加してパスを編集する。

< 例 >

```diff
- <link rel="stylesheet" href="css/style.css">

+ <link rel="stylesheet" href="{{ asset('blog_template/css/style.css') }}">
```

画像の URI も同様に `blog_template/` を追加してパスが通るようにする。 

```diff
- <a href="#" class="blog-img" style="background-image: url(images/blog-1.jpg);"></a>

+ <a href="#" class="blog-img" style="background-image: url(blog_template/images/blog-1.jpg);"></a>
```

## マスターレイアウトの作成とシングルページの作成

マスターレイアウトのファイルを作成するため `resources\views\main_layouts\master.blade.php` を作成。

`resources\views\home.blade.php` から以下の部分を切り取りして `master.blade.php` を以下のように編集。

```html
<!DOCTYPE HTML>
<html>
    <head>
        // ...

        @yield('custom_css')

    </head>
    <body>

        <div id="page">
            <nav class="colorlib-nav" role="navigation">
                // ...
            </nav>
            <aside id="colorlib-hero">
                <div class="flexslider">
                    <ul class="slides">

                    </ul>
                </div>
            </aside>

            @yield('content')

            <div id="colorlib-subscribe" class="subs-img" style="background-image: url(blog_template/images/img_bg_2.jpg);" data-stellar-background-ratio="0.5">
                // ...
            </div>
            <footer id="colorlib-footer">
                // ...
            </footer>
        </div>

        <div class="gototop js-top">
            <a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
        </div>

        <!-- jQuery -->
        <script src="{{ asset('blog_template/js/jquery.min.js') }}"></script>
        // ...

        @yield('custom_js')

    </body>
</html>
```

`resources\views\home.blade.php` は以下のように編集

```html
@extends('main_layouts.master')

@section('title', 'My blog | Home')

@section('content')
<div class="colorlib-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                // ...
            </div>

            <!-- SIDEBAR: start -->
            <div class="col-md-4 animate-box">
                <div class="sidebar">
                    // ...
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

シングルページも同様に作成する。`resources\views\post.blade.php` を新規に作成して `public\blog_template\single.html` のテンプレートを参考にしながら以下のように編集する。

```html
@extends('main_layouts.master')

@section('title', 'My blog | This is single post')

@section('content')
<div class="colorlib-classes">
    <div class="container">
        // ...
    </div>
</div>
@endsection
```

画像の URI も同様に `blog_template/` を追加してパスが通るようにする。 

```diff
- <a href="#" class="blog-img" style="background-image: url(images/blog-1.jpg);"></a>

+ <a href="#" class="blog-img" style="background-image: url(blog_template/images/blog-1.jpg);"></a>
```

`web.php` にシングルページ用のルート定義を追加。名前付きルートも同時に作成。

```php
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/post', function () {
    return view('post');
})->name('post');
```

## コンタクトページと About ページの作成

コンタクトページと About ページの作成のため `resources\views`に `contact.blade.php` と `about.blade.php` を作成。

作成したら、`resources\views\contact.blade.php` に  `public\blog_template\contact.html` の内容をコピー。また、`resources\views\about.blade.php` に `public\blog_template\contact.html` の内容をコピー。

2つのファイルにコピーしたら、Blade ファイルとして活用するために以下のように編集。

```html:about.blade.php
@extends('main_layouts.master')

@section('title', 'Myblog | About')

@section('content')
<div id="colorlib-counter" class="colorlib-counters">
    // ...
</div>

<div class="colorlib-about">
    // ...
</div>
@endsection
```

```html:contact.blade.php
@extends('main_layouts.master')

@section('title', 'Myblog | Contact')

@section('content')
<div class="colorlib-contact">
    // ...
</div>
@endsection
```

ルートに About ページ と Contact ページを記述

```php:web
// ...

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
```

`master.blade.php` を開いて メニューに名前付きルートとゲスト用のログインページ情報を追加。

```diff
# master.blade.php

 <nav class="colorlib-nav" role="navigation">
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
-                   <div id="colorlib-logo"><a href="index.html">Blog</a></div>
+                   <div id="colorlib-logo"><a href="{{ route('home') }}">Blog</a></div>
                </div>
                <div class="col-md-10 text-right menu-1">
                    <ul>
-                       <li><a href="index.html">Home</a></li>
+                       <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="has-dropdown">
-                          <a href="courses.html">Categories</a>
+                            <a href="">Categories</a>
                            <ul class="dropdown">
                                <li><a href="#">Programming</a></li>
                                <li><a href="#">Games</a></li>
                                <li><a href="#">Soft Skills</a></li>
                            </ul>
                        </li>
-                       <li><a href="about.html">About</a></li>
+                       <li><a href="{{ route('about') }}">About</a></li>
-                       <li><a href="contact.html">Contact</a></li>
+                       <li><a href="{{ route('contant') }}">Contact</a></li>

+                       @guest
-                       <li class="btn-cta"><a href="#"><span>Sign in</span></a></li>
+                       <li class="btn-cta"><a href="{{ route('login') }}"><span>Sign in</span></a></li>
+                       @endguest

+                       @auth
+                       <li class="btn-cta"><a href="#"><span>Admin</span></a></li>
+                       @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
 </nav>
```

ブラウザで表示を確認する。ここで、認証済みの際のメニュー欄に表示するユーザーのドロップダウンメニューを追加する。`master.blade.php` を以下のように編集。

```diff
// ...

<div class="top-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div id="colorlib-logo"><a href="{{ route('home') }}">Blog</a></div>
            </div>
            <div class="col-md-10 text-right menu-1">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
-                   <li class="has-dropdown">
-                       <a href="">Categories</a>
-                       <ul class="dropdown">
-                           <li><a href="#">Programming</a></li>
-                           <li><a href="#">Games</a></li>
-                           <li><a href="#">Soft Skills</a></li>
-                       </ul>
-                   </li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>

                    @guest
                    <li class="btn-cta"><a href="{{ route('login') }}"><span>Sign in</span></a></li>
                    @endguest

                    @auth                   
-                   <li class="btn-cta"><a href="#"><span>Admin</span></a></li>
+                   <li class="has-dropdown">
+                       <a href="">{{ auth()->user()->name }} <span class="caret"></span></a>
+                       <ul class="dropdown">
+                           <li>
+                               <a
+                                   onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();"
+                                   href="{{ route('logout') }}">Logout</a>
+
+                               <form id="nav-logout-form" action=" {{ route('logout') }}" method="POST">
+                                   @csrf
+                               </form>
+                           </li>
+                       </ul>
+                   </li>
                    @endauth
```

## ユーザーとロールのリレーション

ユーザーとロール（役割）のリレーションを行います。まずは `Role` モデルと Role モデルのマイグレーションファイルを以下のコマンドで作成します。

```
php artisan make:model Role -m
```

作成されたマイグレーションファイル `create_roles_table.php` を開いて以下のように編集してください。

```diff
return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
+           $table->boolean('status')->default(1);
+           $table->string('name');
            $table->timestamps();
        });
    }
```

次に、すでにある `users` テーブルに Role モデルに関連するカラムを追加します。以下のコマンドで `users` テーブルにカラムを追加するマイグレーションファイルを作成します。

```
php artisan make:migration add_role_id_to_users --table=users
```

作成された `add_role_id_to_users.php` ファイルを開き、User テーブルにカラム情報の追加を行います。

```diff
return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
+           $table->boolean('status')->default(1);
+           $table->foreignId('role_id')->constrained();
        });
    }
```

各モデルにリレーション情報を書き込みます。

```diff
// User.php

// ...
class User extends Authenticatable
{
    // ...

+   public function role()
+   {
+       return $this->belongsTo(Role::class);
+   }
```

```diff
// Role.php

// ...
class Role extends Model
{
    use HasFactory;

+   public function users()
+   {
+       return $this->hasMany(User::class);
+   }
```

ユーザーの登録テストを追加するため シーダー情報を追記します。`DatabaseSeeder.php` を開いて以下のように編集します。

```diff
public function run()
{
    // ...

+   $role = Role::create([
+       'name' => 'author',
+   ]);

+   $role->users()->create([
+       'name' => 'admin',
+       'email' => 'admin@example.com',
+       'password' => Hash::make('password'),
+       'status' => 1,
+   ]);
}
```

## Post モデルとマイグレーションファイルの作成

```
php artisan make:model Post -m
```

`database\migrations\2022_08_02_160845_create_posts_table.php` を編集

```diff
// ...

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
+           $table->string('title');
+           $table->string('slug');
+           $table->string('excerpt');
+           $table->text('body');
+
+           $table->foreignId('user_id')->constrained();
+           $table->timestamps();
        });
    }
```

`app\Models\Post.php` にリレーション情報を追加

```diff
class Post extends Model
{
    use HasFactory;

+   public function author()
+   {
+       return $this->belongsTo(User::class, 'user_id');
+   }
```

`app\Models\User.php` にもリレーション関連を追加

```diff
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // ...

+   public function role()
+   {
+       return $this->belongsTo(Role::class);
+   }
+
+   public function posts()
+   {
+       return $this->hasMany(Post::class);
+   }
```

`database\seeders\DatabaseSeeder.php` に シーダーを追記

```diff
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $role = Role::create([
            'name' => 'author',
        ]);

-       $role->users()->create([
+       $user = $role->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

+       $user->posts()->create([
+           'title' => 'This is title',
+           'slug' => 'This is slug',
+           'excerpt' => 'This is excerpt',
+           'body' => 'This is content',
+       ]);
    }
```

## Category モデルとマイグレーションファイルの作成

Category モデルとマイグレーションファイルの作成のためコマンドを入力

```
php artisan make:model Category -m
```

作成された `app\Models\Category.php` を以下のように編集。

```diff
class Category extends Model
{
    use HasFactory;

+   protected $fillable = [
+       'name', 'slug',
+   ];

+   public function posts()
+   {
+       return $this->hasMany(Post::class);
+   }
}
```

作成された `database\migrations\2022_08_03_060126_create_categories_table.php` を以下のように編集。

```diff
// ...

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
+           $table->string('name');
+           $table->string('slug')->unique();
            $table->timestamps();
        });
    }
```

`posts` テーブルに外部キーの `category_id` を持たせるために新規に posts テーブル更新用のマイグレーションファイルをコマンドで作成

```
php artisan make:migration add_category_id_to_posts --table=posts
```

作成された `database\migrations\2022_08_03_060616_add_category_id_to_posts.php` ファイルを以下のように編集。

```diff
return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
+          $table->foreignId('category_id')->constrained();
        });
```

`category_id` をシーダーファイルに含ませるためにシーダーファイルを編集

```diff
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $role = Role::create([
            'name' => 'author',
        ]);

+       $category = Category::create([
+           'name' => 'Education',
+           'slug' => 'education'
+       ]);

        $user = $role->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
+           'category_id' => 1,
        ]);
```

## Tag モデルと Post モデルとのリレーション

タグ機能を作成するため以下のコマンドを入力。

```
php artisan make:model Tag -m
```

作成された `app\Models\Tag.php` を以下のように編集

```diff
class Tag extends Model
{
    use HasFactory;

+   protected $fillable = [
+       'name'
+   ];

+   public function posts()
+   {
+       return $this->belongsToMany(Post::class);
+   }
}
```

作成されたマイグレーションファイル `create_tags_table.php` も以下のように編集

```diff
// ...

return new class extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
+           $table->string('name');
            $table->timestamps();
        });
    }
```

多対多用のテーブルのマイグレーションファイルを作成させるため以下のコマンドを入力

```
php artisan make:migration create_post_tag_table --create=post_tag
```

`create_post_tag_table.php` マイグレーションファイルが作成されるので以下のように編集

```diff
// ...
return new class extends Migration
{
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
+           $table->foreignId('post_id')->constrained();
+           $table->foreignId('tag_id')->constrained();
            $table->timestamps();
        });
    }
```

シーダーファイルの編集。タグ名やユーザーロール等の設定をもう一度確認。以下のように編集。

```php
// ...

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ロール名の初期設定
        $role1 = Role::query()->create([
            'name' => 'user',
        ]);
        $role2 = Role::query()->create([
            'name' => 'author',
        ]);
        $role3 = Role::query()->create([
            'name' => 'admin',
        ]);

        // タグ名の初期設定
        $tag1 = Tag::query()->create([
            'name' => 'php',
        ]);
        $tag2 = Tag::query()->create([
            'name' => 'c++',
        ]);
        $tag3 = Tag::query()->create([
            'name' => 'ruby',
        ]);

        // カテゴリ名の初期設定
        $category = Category::create([
            'name' => 'Education',
            'slug' => 'education'
        ]);

        // ユーザー情報の登録
        $user = $role2->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        // 記事情報の登録
        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

        // タグと記事のリレーション設定
        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
```

## コメントテーブルの作成

Comment モデルとマイグレーションファイル作成するためのコマンドを以下のように入力する

```
php artisan make:model Comment -m
```

作成された `app\Models\Comment.php` を以下のように編集。

Comment モデルは 
- Post モデルに対して `1対多` の関係
- User モデルに対しては `1対多` の関係



```diff
// ...

class Comment extends Model
{
    use HasFactory;

+   protected $fillable = [
+       'the_comment', 'user_id', 'post_id',
+   ];
+
+   public function post()
+   {
+       return $this->belongsTo(Post::class);
+   }
+
+   public function user()
+   {
+       return $this->belongsTo(User::class);
+   }
}
```

作成された `create_comments_table.php` ファイルを以下のように編集

```diff
// ...

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
+           $table->string('the_comment');
+           $table->foreignId('user_id')->constrained()->cascadeOnDelete();
+           $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
```

リレーションの設定のため `User.php` を編集

```diff
class User extends Authenticatable
{
    // ...

+   public function comments()
+   {
+       return $this->hasMany(Comment::class);
+   }
}
```

`Post.php` についても以下のように編集

```diff
class Post extends Model
{
    // ...

+   public function comments()
+   {
+       return $this->hasMany(Comment::class);
+   }
}
```

`database\seeders\DatabaseSeeder.php` を編集

```diff
// ...

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ...

        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

+       $post->comments()->create([
+           'the_comment' => '1st subaru',
+           'user_id' => $user->id,
+       ]);

+       $post->comments()->create([
+           'the_comment' => '2st subaru',
+           'user_id' => $user->id,
+       ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
```

## Image モデルとリレーションの作成

Image モデルとマイグレーションファイルの作成のため以下のコマンドを入力

```
php artisan make:model Image -m
```

作成された `app\Models\Image.php` を以下のように編集

```diff
// ...

class Image extends Model
{
    use HasFactory;

+   protected $fillable = [
+       'name', 'extension', 'path',
+   ];

+   public function imageable()
+   {
+       return $this->morphTo();
+   }
}
```

作成された `create_images_table.php` を以下のように編集

```diff
// ...

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
+           $table->string('name');
+           $table->string('extension');
+           $table->string('path');

+           $table->unsignedBigInteger('imageable_id');
+           $table->string('imageable_type');

            $table->timestamps();
        });
    }

    // ...
}
```

Post モデルに Image モデルとのリレーション情報を記入

```diff
class Post extends Model
{
    // ...

+   public function image()
+   {
+       return $this->morphOne(image::class, 'imageable');
+   }
}
```

User モデルにも Image モデルとリレーション情報を記入。

```diff
class User extends Authenticatable
{
    // ...

    protected $fillable = [
        'name',
        'email',
        'password',
+       'role_id',
    ];

    // ...

+   public function image()
+   {
+       return $this->morphOne(Image::class, 'imageable');
+   }
}
```

次に `app\Http\Controllers\Auth\RegisteredUserController.php` を開いて以下のように編集

```diff
class RegisteredUserController extends Controller
{
    // ...

    public function store(Request $request)
    {

+       $role = Role::where('name', 'user')->first();
+       if ($role == null) {
+           $role = Role::create([
+               'name' => 'user',
+           ]);
+           $role_id = $role->id;
+       } else {
+           $role_id = $role->id;
+       }

        // ...

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
+           'role_id' => $role_id,
        ]);

        // ...
    }
}
```

`create_posts_table.php` を以下のように編集

```diff
return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
-           $table->string('slug');
+           $table->string('slug')->unique();
            $table->string('excerpt');
            $table->text('body');

            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }
}
```

シーダーファイルに情報を記入

```diff
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ...

+       $post->image()->create([
+           'name' => 'random file',
+           'extension' => 'jpg',
+           'path' => '/image/random_file.jpg',
+       ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
```

## ホームページの記事表示

ホームのコントローラーを作成するため以下のコマンドを入力

```
php artisan make:controller HomeController
```

`app\Http\Controllers\HomeController.php` が作成されるので以下のように編集

```diff
class HomeController extends Controller
{
    public function index()
    {

+       $posts = Post::query()
+           ->withCount('comments')
+           ->get();
+
+       return view('home', compact('posts'));
    }
}
```

`resources\views\home.blade.php` を編集。@foreach で記事を展開。

```diff
    // ...

    @section('content')

    <div class="colorlib-blog">
        <div class="container">
            <div class="row">
                <div class="col-md-8 posts-col">

+                   @foreach ($posts as $post )
                    <div class="block-21 d-flex animate-box post">
                        <a href="#" class="blog-img" style="background-image: url(blog_template/images/blog-1.jpg);"></a>
                        <div class="text">
+                           <h3 class="heading"><a href="#">{{ $post->title }}</a></h3>
+                           <p class="excerpt">{{ $post->excerpt }}</p>
                            <div class="meta">
+                               <div class="date"><a href="#"><span class="icon-calendar"></span> {{ $post->created_at->diffForHumans() }}</a></div>
+                               <div class=""><a href="#"><span class="icon-user2"></span> {{ $post->author->name }}</a></div>
+                               <div class="comments-count"><a href="#"><span class="icon-chat"></span> {{ $post->comments_count }}</a></div>
                            </div>
                        </div>
                    </div>
+                   @endforeach

                </div>
                
                // ...
```

## 記事情報の画像を表示

サムネイル画像のデータを `storage/app/publick` フォルダに保存した画像を表示するために以下のコマンドを入力

```
php artisan storage:link
```

`public` フォルダ直下に `storage/app/public` のショートカットフォルダができるので `storage/app/public`に `images` フォルダを作成してサムネイル画像を保存。

`resources\views\home.blade.php` を編集。サムネイル画像を表示する。

```diff
    // ...

    @foreach ($posts as $post )
    <div class="block-21 d-flex animate-box post">
-       <a href="#" class="blog-img" style="background-image: url(blog_template/images/blog-1.jpg);"></a>
+       <a href="#" class="blog-img" style="background-image: url({{ asset('storage/' . $post->image->path ) }});"></a>
        <div class="text">
            <h3 class="heading"><a href="#">{{ $post->title }}</a></h3>
            <p class="excerpt">{{ $post->excerpt }}</p>
            <div class="meta">
                <div class="date"><a href="#"><span class="icon-calendar"></span> {{ $post->created_at->diffForHumans() }}</a></div>
                <div class=""><a href="#"><span class="icon-user2"></span> {{ $post->author->name }}</a></div>
                <div class="comments-count"><a href="#"><span class="icon-chat"></span> {{ $post->comments_count }}</a></div>
            </div>
        </div>
    </div>
    @endforeach
```

`database\seeders\DatabaseSeeder.php` を編集

```diff
// ...

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        // ...

        $post->comments()->create([
            'the_comment' => '1st subaru',
            'user_id' => $user->id,
        ]);

        $post->comments()->create([
            'the_comment' => '2st subaru',
            'user_id' => $user->id,
        ]);

+       $post->image()->create([
+           'name' => 'post file',
+           'extension' => 'jpg',
+           'path' => 'images/' . rand(0, 10) . '.jpg',
+       ]);

+       $user->image()->create([
+           'name' => 'user file',
+           'extension' => 'jpg',
+           'path' => 'images/' . rand(0, 10) . '.jpg',
+       ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
```

シーダーを有効にするために `php artisan migrate:fresh --seed` コマンドでデータベースを初期化する

## 最新の記事の表示

サイドに最新の記事を表示するための処理をする。`app\Http\Controllers\HomeController.php` を編集

```diff
class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::query()
            ->withCount('comments')
            ->get();

+       $recent_posts = Post::query()
+           ->latest()
+           ->take(5)
+           ->get();

+       return view('home', compact('posts', 'recent_posts'));
    }
}
```

サイドエリアの部分は @foreach を使用して最新の記事を繰返し処理する。`home.blade.php` を編集

```html

    // ...

    <div class="side">
        <h3 class="sidebar-heading">Recent Blog</h3>

        @foreach ($recent_posts as $recent_post)
        <div class="f-blog">
            <a href="blog.html" class="blog-img" style="background-image: url({{ asset('storage/' . $recent_post->image->path ) }});">
            </a>
            <div class="desc">
                <p class="admin"><span>{{ $recent_post->created_at->diffForHumans() }}</span></p>
                <h2><a href="blog.html">{{ Str::limit( $recent_post->title, 20, '...') }}</a></h2>
                <p>{{ $recent_post->excerpt }}</p>
            </div>
        </div>
        @endforeach

    </div>
```

## サイドバー 「カテゴリー」と「タグ」の表示

`resources\views\home.blade.php` を編集。サイドバーに位置するカテゴリーの表示エリアの編集をする。以下のように @foreach ディレクティブを使用してループ処理を行う。また、タグ表示エリアの編集も同ファイルで行う。

```diff
    // ...

    <div class="col-md-4 animate-box">
        <div class="sidebar">
            <div class="side">
                <h3 class="sidebar-heading">Categories</h3>

                <div class="block-24">
                    <ul>
+                        @foreach ($categories as $category)
+                        <li><a href="#">{{ $category->name }} <span>{{ $category->posts_count }}</span></a></li>
+                        @endforeach
                    </ul>
                </div>
            </div>

            // ...

            <div class="side">
                <h3 class="sidbar-heading">Tags</h3>
                <div class="block-26">
                    <ul>
+                       @foreach ($tags as $tag)
+                       <li><a href="#">{{ $tag->name }}</a></li>
+                       @endforeach
                    </ul>
                </div>
            </div>

            // ...
```

`HomeController.php` に編集を行う。サイドバーのカテゴリーエリア用の Category モデルのインスタンスを、またタグエリア用の Tag モデルのインスタンスを `home.blade.php` に渡す処理を行う。

```diff
// ...

class HomeController extends Controller
{
    public function index()
    {
        // ...

+       $categories = Category::query()
+           ->withCount('posts')
+           ->orderBy('posts_count', 'desc')
+           ->get();
+
+       $tags = Tag::query()
+           ->take(50)
+           ->get();
+
-       return view('home', compact('posts', 'recent_posts'));
+       return view('home', compact(
+           'posts',
+           'recent_posts',
+           'categories',
+           'tags',
+       ));
}
```

## トップページのページネーション

トップページの記事一覧表示画面で記事数が多くなった場合に備えてページネーションの処理を記述していく。`home.blade.php` を開いて編集。ページネーションの表示記述とともに、@forelse を使用して記事がなかった場合の処理も同時に記述する。

```diff
 // ...

 @section('content')
 <div class="colorlib-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8 posts-col">

+               @forelse ($posts as $post )
                <div class="block-21 d-flex animate-box post">
                    <a href="#" class="blog-img" style="background-image: url({{ asset('storage/' . $post->image->path ) }});"></a>
                    <div class="text">
                        <h3 class="heading"><a href="#">{{ $post->title }}</a></h3>
                        <p class="excerpt">{{ $post->excerpt }}</p>
                        <div class="meta">
                            <div class="date"><a href="#"><span class="icon-calendar"></span> {{ $post->created_at->diffForHumans() }}</a></div>
                            <div class=""><a href="#"><span class="icon-user2"></span> {{ $post->author->name }}</a></div>
                            <div class="comments-count"><a href="#"><span class="icon-chat"></span> {{ $post->comments_count }}</a></div>
                        </div>
                    </div>
                </div>
+               @empty
+               <p>There are no posts to show.</p>
+               @endforelse

+               {{ $posts->links() }}

            </div>

            // ...
```
`HomeController.php` を編集する

```diff
// ...

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::query()
            ->withCount('comments')
+           ->paginate(5);

        // ...
```

ページネーションの出力を `resources` フォルダに展開して編集できるようにするために以下のコマンドを入力

```
php artisan vendor:publish
```

今回は、ページネーション関するファイルを出力できれば良いので `  Tag: laravel-pagination` が表示されている番号を入力する。

ページネーションの出力データは標準では Tailwind CSS が採用されいてる。 `resources\views\vendor\pagination\tailwind.blade.php` を見てみるとページネーションの出力時のコードをみることができる。また、Tailwind CSS の以外で出力したい場合は `app\Providers\AppServiceProvider.php` を編集して Bootstrap 等のフレームワークに変更することも可能。

```diff
<?php

namespace App\Providers;

+ use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // ...

    public function boot()
    {
+       Paginator::useBootstrap();
    }
}
```