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

## 個別記事の表示

個別記事を表示するためのコントローラーを以下のコマンドを入力して作成

```
php artisan make:controller PostController
```

次に `routes/web.php` を開いて編集

```diff
// ...

Route::get('/post/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');
```

作成された `PostController.php` を編集

```php
// ...

class PostController extends Controller
{
    public function show(Post $post)
    {
        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $tags = Tag::query()
            ->take(50)
            ->get();

        return view('post', compact(
            'post',
            'recent_posts',
            'categories',
            'tags',
        ));
    }
}
```

`post.blade.php` のサイドバーエリアをコンポーネント化する作業を行うため以下のように編集。
また、`home.blade.php` も同様に編集

```diff
    // ...

    <!-- SIDEBAR: start -->
    <div class="col-md-4 animate-box">
        <div class="sidebar">
+           <x-blog.side-categories :categories="$categories" />

+           <x-blog.side-recent-posts :recentPosts="$recent_posts" />

+           <x-blog.side-tags :tags="$tags" />
        </div>
    </div>
```

`x タグ` に対応する Blade ファイルを作成。 `resources\views\components` に `blog` フォルダを作成して、 `side-categories.blade.php`, `side-recent-posts.blade.php` , `side-tags.blade.php` を作成する


// side-categories.blade.php

```html
@props(['categories'])

<div class="side">
    <h3 class="sidebar-heading">Categories</h3>

    <div class="block-24">
        <ul>
            @foreach ($categories as $category)
            <li><a href="#">{{ $category->name }} <span>{{ $category->posts_count }}</span></a></li>
            @endforeach
        </ul>
    </div>
</div>
```

// side-recent-posts.blade.php

```html
@props(['recentPosts'])

<div class="side">
    <h3 class="sidebar-heading">Recent Blog</h3>

    @foreach ($recentPosts as $recent_post)
    <div class="f-blog">
        <a href="{{ route('posts.show', $recent_post) }}" class="blog-img" style="background-image: url({{ asset('storage/' . $recent_post->image->path ) }});">
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

// side-tags.blade.php

```html
@props(['tags'])

<div class="side">
    <h3 class="sidbar-heading">Tags</h3>
    <div class="block-26">
        <ul>
            @foreach ($tags as $tag)
            <li><a href="#">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
```

## 個別記事のコメント関連の処理

個別記事のコメント表示の処理を行う。`PostController.php` を編集。

```diff
class PostController extends Controller
{
     // ...

+    public function addComment(Post $post)
+    {
+        $attributes = request()->validate([
+            'the_comment' => 'required|min:10:max:300',
+        ]);
+
+        $attributes['user_id'] = auth()->id();
+        $comment = $post->comments()->create($attributes);
+
+        return redirect('/post/' . $post->slug . '#comment_' . $comment->id)
+            ->with('success', 'Comment has been added.');
+     }
}
```

`resources\views\post.blade.php` を編集。コメントの表示部分をループ処理して表示する。

```diff
    // ...

    <div class="row row-pb-lg animate-box">
        <div class="col-md-12">
+            <h2 class="colorlib-heading-2">{{ count($post->comments) }} Comments</h2>
+            
+            @foreach($post->comments as $comment)
+            <div id="comment_{{ $comment->id }}" class="review">
+                <div
+                    class="user-img"
+                    style="background-image: url({{ $comment->user->image ? asset('storage/' . $comment->user->image->path. '') : 'https://images.assetsdelivery.com/compings_v2/salamatik/salamatik1801/salamatik180100019.jpg'  }});"></div>
+                <div class="desc">
+                    <h4>
+                        <span class="text-left">{{ $comment->user->name }}</span>
+                        <span class="text-right">{{ $comment->created_at->diffForHumans() }}</span>
+                    </h4>
+                    <p>{{ $comment->the_comment }}</p>
+                    <p class="star">
+                        <span class="text-left"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
+                    </p>
+                </div>
+            </div>
+            @endforeach

        </div>
    </div>
```

また、コメントの投稿エリアも以下のように編集する。

```diff
    // ...

   <div class="row animate-box">
       <div class="col-md-12">

+           <h2 class="colorlib-heading-2">Say something</h2>

+           @auth
+           <form method="POST" action="{{ route('posts.add_comment', $post) }}">
+               @csrf
+               <div class="row form-group">
+                   <div class="col-md-12">
+                       <!-- <label for="message">Message</label> -->
+                       <textarea name="the_comment" id="the_comment" cols="30" rows="10" class="form-control" placeholder="Say something about us"></textarea>
+                   </div>
+               </div>
+               <div class="form-group">
+                   <input type="submit" value="Post Comment" class="btn btn-primary">
+               </div>
+           </form>
+           @endauth
+
+           @guest
+           <p class="lead"><a href="{{ route('login') }}">Login </a> OR <a href="{{ route('register') }}">Register</a> to write comments</p>
+           @endguest
+
       </div>
   </div>
```

ルートを編集。 `routes/web.php` を以下のように編集。

```diff
Route::get('/post/{post:slug}', [PostController::class, 'show'])
    ->name('posts.show');

+ Route::post('/post/{post:slug}', [PostController::class, 'addComment'])
+     ->name('posts.add_comment');
```

## 個別記事のコメントのステータスメッセージ

コメントを投稿したあとにメッセージが登録されたかを表示するステータスメッセージ欄を表示する。

`resources\views\post.blade.php` を以下のように編集

```diff
    // ...

    <div class="row animate-box">
        <div class="col-md-12">

+           <x-blog.message :status="'success'" />

            <h2 class="colorlib-heading-2">Say something</h2>

            @auth
            <form method="POST" action="{{ route('posts.add_comment', $post) }}">
                @csrf
                <div class="row form-group">
```

また、xタグに対応する blade ファイルを作成する。`resources\views\components\blog` 内に `message.blade.php` を作成して以下のように編集

```html
@props(['status'])

@if(session()->has($status))
<div class="alert alert-{{ $status == 'success' ? 'info' : 'danger' }}">
    {{ session($status) }}
</div>
@endif
```

## About ページの表示

About ページを表示をする処理を行う。まず AboutController を作成する。以下のコマンドでコントローラーを作成。

```
php artisan make:controller AboutController --invokable
```

作成された `app\Http\Controllers\AboutController.php` を編集。

```diff
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke(Request $request)
    {
+       return view('about');
    }
}
```

`routes\web.php` を編集

```diff
- Route::get('/about', function () {
-     return view('about');
- })->name('about');

+ Route::get('/about', AboutController::class)->name('about');
```

## Contact ページの送信機能

Contact ページの送信機能を実装するために以下のコマンドを入力

```
php artisan make:controller ContactController
```

作成された `app\Http\Controllers\ContactController.php` を以下のように編集

```diff
// ...

class ContactController extends Controller
{
+    public function create()
+    {
+        return view('contact');
+    }
+
+    public function store(Request $request)
+    {
+        $validated = $request->validate([
+            'first_name' => 'required',
+            'last_name' => 'required',
+            'email' => 'required',
+            'subject' => 'nullable|min:5|max:50',
+            'message' => 'required|min:5|max:500',
+        ]);
+
+        Contact::query()->create($validated);
+
+        return redirect()->route('contact.create')
+            ->with('success', 'Your Message has been sent');
+    }
}
```

続けて、モデルとマイグレーションファイルを作成するためのコマンドを入力

```
php artisan make:model Contact -m
```

作成された `app\Models\Contact.php` を以下のように編集

```diff
// ...

class Contact extends Model
{
    use HasFactory;

+   protected $guarded = [];
}
```

また、作成された `create_contacts_table.php` を以下のように編集

```diff
    // ...

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
+               $table->string('first_name');
+               $table->string('last_name');
+               $table->string('email');
+               $table->string('subject');
+               $table->text('message');
                $table->timestamps();
            });
        }

        // ...
    }
```

`resources\views\contact.blade.php` を以下のように編集

```diff

        // ...

        <div class="row">
            <div class="col-md-12">
                <h2>Message Us</h2>
            </div>
            <div class="col-md-6">
+               <form autocomplete="off" method="POST" action="{{ route('contact.store') }}">
+                   @csrf
                    <div class="row form-group">
                        <div class="col-md-6">
                            <!-- <label for="fname">First Name</label> -->
+                           <x-blog.form.input value='{{ old("first_name") }}' placeholder='Your Firstname' name="first_name" />
                        </div>
                        <div class="col-md-6">
                            <!-- <label for="lname">Last Name</label> -->
+                           <x-blog.form.input value='{{ old("last_name") }}' placeholder='Your Lastname' name="last_name" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- <label for="email">Email</label> -->
+                           <x-blog.form.input value='{{ old("email") }}' placeholder='Your Email' type='email' name="email" />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- <label for="subject">Subject</label> -->
+                           <x-blog.form.input value='{{ old("subject") }}' required='false' name="subject" placeholder='Your Subject' />
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- <label for="message">Message</label> -->
+                           <x-blog.form.textarea value='{{ old("message") }}' placeholder='What you want to tell us.' name="message" />
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Send Message" class="btn btn-primary">
                    </div>
                </form>

+               <x-blog.message :status="'success'" />
            </div>
            <div class="col-md-6">
                <div id="map" class="colorlib-map"></div>
            </div>
        </div>

        // ...
```

`resources\views\components\blog` に新規に `form\input.blade.php` ファイルを作成して以下のように編集

```html
@props(['type' => 'text' , 'name', 'placeholder','required' => 'true','value'])

<input
       type="{{ $type }}"
       id="{{ $name }}"
       name="{{ $name }}"
       value="{{ $value }}"
       placeholder="{{ $placeholder }}"
       class=" form-control"
       {{ $required=='true' ? 'required' : '' }}>

@error($name)
<small class=" text-danger">{{ $message }}</small>
@enderror
```

同フォルダに `textarea.blade.php` も作成して以下のように編集

```html
@props(['name', 'placeholder', 'value'])

<textarea
          rows="5"
          required
          id="{{ $name }}"
          name='{{ $name }}'
          class="form-control"
          placeholder="{{ $placeholder }}">{{ $value }}</textarea>

@error($name)
<small class="text-danger">{{ $message }}</small>
@enderror
```

`web.php` を編集

```diff
- Route::get('/contact', function () {
-     return view('contact');
- })->name('contact');

+ Route::get('/contact', [ContactController::class, 'create'])
+     ->name('contact.create');

+ Route::post('/contact', [ContactController::class, 'store'])
+     ->name('contact.store');
```

`master.blade.php` を編集

```diff
- <li><a href="{{ route('contact') }}">Contact</a></li>
+ <li><a href="{{ route('contact.create') }}">Contact</a></li>
```

## マークダウン対応のメールを送信

コンタクトページからメッセージを送信するときにマークダウンのテンプレートをもとにメールを送信する処理をする。メールを送信するために以下のコマンドを入力

```
php artisan make:mail ContactMail --markdown=emails.contact
```

`--markdown` オプションで指定のマークダウン用の Blade ファイルを作成することができる。上記のコマンドでは  `resources\views\emails\contact.blade.php` にファイルが自動的に作成される。また `app\Mail\ContactMail.php` にもファイルが作成される。

作成された `app\Mail\ContactMail.php` を編集

```diff
    // ...

    class ContactMail extends Mailable
    {
        use Queueable, SerializesModels;

+       public $firstname;
+       public $secondname;
+       public $email;
+       public $subject;
+       public $message;

+       public function __construct($firstname, $secondname, $email, $subject, $message)
        {
+           $this->firstname = $firstname;
+           $this->secondname = $secondname;
+           $this->email = $email;
+           $this->subject = $subject;
+           $this->message = $message;
        }

        public function build()
        {
            return $this->markdown('emails.contact');
        }
    }
```

`resources\views\emails\contact.blade.php` も編集

```html
@component('mail::message')
# Visitor Message

Some Visitor Left a message:
<br><br>
Firstname: {{ $firstname }}
<br>
Secondname: {{ $secondname }}
<br>
Email: {{ $email }}
<br>
Subject: {{ $subject }}
<br>
Message: {{ $message }}

@component('mail::button', ['url' => ''])
View Message
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
```

`app\Http\Controllers\ContactController.php` を編集

```diff
<?php

namespace App\Http\Controllers;

+ use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
+ use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'subject' => 'nullable|min:5|max:50',
            'message' => 'required|min:5|max:500',
        ]);

        Contact::query()->create($validated);

+       Mail::to("admin@example.com")
+           ->send(new ContactMail(
+               $validated['first_name'],
+               $validated['last_name'],
+               $validated['email'],
+               $validated['subject'],
+               $validated['message']
+           ));

        return redirect()->route('contact.create')
            ->with('success', 'Your Message has been sent');
    }
}
```

`.env` ファイルにメールを送信テストするための設定をする

## Ajax でコンタクトフォームの情報をメール送信させる

コンタクトフォームの記入した情報を Ajax で送信してメールも送信させる。

`app\Http\Controllers\ContactController.php` を以下ように編集

```php
<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = array();
        $data['success'] = 0;
        $data['errors'] = [];
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'subject' => 'nullable|min:5|max:50',
            'message' => 'required|min:5|max:500',
        ];
        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            $data['errors']['first_name'] = $validated->errors()->first('first_name');
            $data['errors']['last_name'] = $validated->errors()->first('last_name');
            $data['errors']['email'] = $validated->errors()->first('email');
            $data['errors']['subject'] = $validated->errors()->first('subject');
            $data['errors']['message'] = $validated->errors()->first('message');
        } else {
            $attributes = $validated->validated();
            Contact::create($attributes);

            Mail::to('admin@example.com')->send(new ContactMail(
                $attributes['first_name'],
                $attributes['last_name'],
                $attributes['email'],
                $attributes['subject'],
                $attributes['message']
            ));
            $data['success'] = 1;
            $data['message'] = 'Thank you for contacting with us';
        }
        return response()->json($data);
    }
}
```

`resources\views\contact.blade.php` を以下のように編集

```diff
    // ...

    @section('content')
+   <div class='global-message info d-none'></div>

    <div class="colorlib-contact">
        <div class="container">

            // ...

            <div class="row">
                <div class="col-md-12">
                    <h2>Message Us</h2>
                </div>
                <div class="col-md-6">
+                   <form onsubmit="return false;" autocomplete="off" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-6">
                                <!-- <label for="fname">First Name</label> -->
                                <x-blog.form.input value='{{ old("first_name") }}' placeholder='Your Firstname' name="first_name" />
+                               <small class='error text-danger first_name'></small>
                            </div>
                            <div class="col-md-6">
                                <!-- <label for="lname">Last Name</label> -->
                                <x-blog.form.input value='{{ old("last_name") }}' placeholder='Your Lastname' name="last_name" />
+                               <small class='error text-danger last_name'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="email">Email</label> -->
                                <x-blog.form.input value='{{ old("email") }}' placeholder='Your Email' type='email' name="email" />
+                               <small class='error text-danger email'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="subject">Subject</label> -->
                                <x-blog.form.input value='{{ old("subject") }}' required='false' name="subject" placeholder='Your Subject' />
+                               <small class='error text-danger subject'></small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <!-- <label for="message">Message</label> -->
                                <x-blog.form.textarea value='{{ old("message") }}' placeholder='What you want to tell us.' name="message" />
+                               <small class='error text-danger message'></small>
                            </div>
                        </div>
                        <div class="form-group">
+                           <input type="submit" value="Send Message" class="btn btn-primary send-message-btn">
                        </div>
                    </form>

                    <x-blog.message :status="'success'" />
                </div>
                <div class="col-md-6">
                    <div id="map" class="colorlib-map"></div>
                </div>
            </div>
        </div>
    </div>
    @endsection

+    @section('custom_js')
+
+    <script>
+        $(document).on("click", '.send-message-btn', (e) => {
+            e.preventDefault();
+            let $this = e.target;
+            
+            let csrf_token = $($this).parents("form").find("input[name='_token']").val()
+            let first_name = $($this).parents("form").find("input[name='first_name']").val()
+            let last_name = $($this).parents("form").find("input[name='last_name']").val()
+            let email = $($this).parents("form").find("input[name='email']").val()
+            let subject = $($this).parents("form").find("input[name='subject']").val()
+            let message = $($this).parents("form").find("textarea[name='message']").val()
+            let formData = new FormData();
+            formData.append('_token', csrf_token);
+            formData.append('first_name', first_name);
+            formData.append('last_name', last_name);
+            formData.append('email', email);
+            formData.append('subject', subject);
+            formData.append('message', message);
+            $.ajax({
+                url: "{{ route('contact.store') }}",
+                data: formData,
+                type: 'POST',
+                dataType: 'JSON',
+                processData:false,
+                contentType: false,
+                success: function(data){
+                    
+                    if(data.success)
+                    {
+                        $(".global-message").addClass('alert , alert-info')
+                        $(".global-message").fadeIn()
+                        $(".global-message").text(data.message)
+                        clearData($($this).parents("form"), ['first_name', 'last_name', 'email', 'subject', 'message']);
+                        setTimeout(() => {
+                            $(".global-message").fadeOut()
+                        }, 5000);
+                    }
+                    else 
+                    {
+                        for (const error in data.errors)
+                        {
+                            $("small."+error).text(data.errors[error]);
+                        }
+                    }
+                }
+            })
+        })
+    </script>
+
+    @endsection
```

Ajax での送信に対応するスタイルシートとJSファイルを読み込ませるため `resources/views/main_layouts/master.blade.php
` を編集

```diff
    <!DOCTYPE HTML>
    <html>
        <head>
            // ...
+           <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">

            // ...
+           <script src="{{ asset('js/functions.js') }}"></script>
            @yield('custom_js')
        </body>
    </html>
```

`message.blade.php` を編集

```diff
    @props(['status'])

    @if(session()->has($status))
+   <div class="alert alert-{{ $status == 'success' ? 'info' : 'danger' }} global-message {{ $status == 'success' ? 'info' : 'error' }} ">
        {{ session($status) }}
    </div>
    @endif
```

`post.blade.php` を以下のように編集

```diff
                // ...

                <!-- SIDEBAR: start -->
                <div class="col-md-4 animate-box">
                    <div class="sidebar">
                        <x-blog.side-categories :categories="$categories" />

                        <x-blog.side-recent-posts :recentPosts="$recent_posts" />

                        <x-blog.side-tags :tags="$tags" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

+   @section('custom_js')
+
+   <script>
+       setTimeout(() => {
+           $(".global-message").fadeOut();
+       }, 5000);
+   </script>
+
+   @endsection
```

`public\css\mystyle.css` を新規に作成し以下のように編集

```css
.global-message {
    position: fixed;
    bottom: 10px;
    right: 10px;
    min-width: 500px;
    border-radius: 50px;
    color: #fff;
    z-index: 2;
}

.global-message.info {
    background: #4586ff;
}

.global-message.error {
    background: #d81d1d;
}
```

`public\js\functions.js` を新規に作成し以下のように編集

```js
let clearData = (parent, elements) => {

    elements.forEach(element => {
        $(parent).find("[name='" + element + "']").val('')
    });

}
```

## カテゴリーとタグページの作成

カテゴリーページ及びタグページの作成をする。まず、CategoryController と TagController 作成する。以下のコマンドを入力。

```
php artisan make:controller CategoryController

php artisan make:controller TagController
```

作成された `CategoryController.php` を開いて以下のように編集

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::withCount('posts')->paginate(100)
        ]);
    }

    public function show(Category $category)
    {
        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $tags = Tag::query()
            ->take(50)
            ->get();

        return view('categories.show', [
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,

            'category' => $category,
            'posts' => $category->posts()->paginate(10),
        ]);
    }
}
```

`app\Http\Controllers\TagController.php` も同様に編集

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
    }

    public function show(Tag $tag)
    {
        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $tags = Tag::query()
            ->take(50)
            ->get();

        return view('tags.show', [
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,

            'posts' => $tag->posts()->paginate(10),
            'tag' => $tag,
        ]);
    }
}
```

上記コントローラーに対応する Blade を作成。`resources\views\categories\index.blade.php`、`resources\views\categories\show.blade.php`、`resources\views\tags\show.blade.php` をそれぞれ作成。

`resources\views\categories\index.blade.php`

```html
@extends('main_layouts.master')

@section('title', 'Categories | Home')

@section('content')

<div class="colorlib-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12 categories-col">

                <div class='row'>

                    @forelse($categories as $category)
                    <div class='col-md-3'>


                        <div class="block-21 d-flex animate-box post">

                            <div class="text">
                                <h3 class="heading"><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></h3>
                                <div class="meta">
                                    <div><a class='date' href="#"><span class="icon-calendar"></span> {{ $category->created_at->diffForHumans() }}</a></div>
                                    <div><a href="#"><span class="icon-user2"></span> {{ $category->user->name }}</a></div>

                                    <div class="posts-count">
                                        <a href="{{ route('categories.show', $category) }}">
                                            <span class="icon-tag"></span> {{ $category->posts_count }}
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    @empty
                    <p class='lead'>There are no categories to show.</p>
                    @endforelse

                </div>

                {{ $categories->links() }}

            </div>

        </div>
    </div>
</div>

@endsection
```

`resources\views\categories\show.blade.php`

```html
@extends('main_layouts.master')

@section('title', $category->name . ' Category | MyBlog')

@section('content')

<div class="colorlib-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8 posts-col">

                @forelse($posts as $post)

                <div class="block-21 d-flex animate-box post">
                    <a
                       href="{{ route('posts.show', $post) }}"
                       class="blog-img"
                       style="background-image: url({{ asset('storage/' . $post->image->path. '')  }});"></a>
                    <div class="text">
                        <h3 class="heading"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                        <p class="excerpt">{{ $post->excerpt }}</p>
                        <div class="meta">
                            <div><a class='date' href="#"><span class="icon-calendar"></span> {{ $post->created_at->diffForHumans() }}</a></div>
                            <div><a href="#"><span class="icon-user2"></span> {{ $post->author->name }}</a></div>
                            <div class="comments-count">
                                <a href="{{ route('posts.show', $post) }}#post-comments">
                                    <span class="icon-chat"></span> {{ $post->comments_count }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class='lead'>There are no posts related to this category.</p>

                @endforelse

                {{ $posts->links() }}

            </div>

            <!-- SIDEBAR: start -->
            <div class="col-md-4 animate-box">
                <div class="sidebar">

                    <x-blog.side-categories :categories="$categories" />

                    <x-blog.side-recent-posts :recentPosts="$recent_posts" />

                    <x-blog.side-tags :tags="$tags" />

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
```

`resources\views\tags\show.blade.php`

```html
@extends('main_layouts.master')

@section('title', $tag->name . ' Tag | MyBlog')

@section('content')

<div class="colorlib-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8 posts-col">

                @forelse($posts as $post)

                <div class="block-21 d-flex animate-box post">
                    <a
                       href="{{ route('posts.show', $post) }}"
                       class="blog-img"
                       style="background-image: url({{ asset('storage/' . $post->image->path. '')  }});"></a>
                    <div class="text">
                        <h3 class="heading"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                        <p class="excerpt">{{ $post->excerpt }}</p>
                        <div class="meta">
                            <div><a class='date' href="#"><span class="icon-calendar"></span> {{ $post->created_at->diffForHumans() }}</a></div>
                            <div><a href="#"><span class="icon-user2"></span> {{ $post->author->name }}</a></div>
                            <div class="comments-count">
                                <a href="{{ route('posts.show', $post) }}#post-comments">
                                    <span class="icon-chat"></span> {{ $post->comments_count }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class='lead'>There are no posts related to this tag.</p>

                @endforelse

                {{ $posts->links() }}

            </div>

            <!-- SIDEBAR: start -->
            <div class="col-md-4 animate-box">
                <div class="sidebar">

                    <x-blog.side-categories :categories="$categories" />

                    <x-blog.side-recent-posts :recentPosts="$recent_posts" />

                    <x-blog.side-tags :tags="$tags" />

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
```

また、サイドバー等の ブレードファイルの調整も行っていく。

`resources\views\components\blog\side-categories.blade.php`

```diff
@props(['categories'])

<div class="side">
    <h3 class="sidebar-heading">Categories</h3>

    <div class="block-24">
        <ul>
            @foreach ($categories as $category)
+           <li><a href="{{ route('categories.show', $category) }}">{{ $category->name }} <span>{{ $category->posts_count }}</span></a></li>
            @endforeach
        </ul>
    </div>
</div>
```

`resources\views\components\blog\side-tags.blade.php`

```diff
@props(['tags'])

<div class="side">
    <h3 class="sidbar-heading">Tags</h3>
    <div class="block-26">
        <ul>
            @foreach ($tags as $tag)
+           <li><a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
```

`resources\views\main_layouts\master.blade.php`

`<a href="blog.html" class="blog-img" style="background-image: url(/blog_template/images/blog-1.jpg);">`

 の部分を 

 `<a href="blog.html" class="blog-img" style="background-image: url({{ asset('blog_template/images/blog-1.jpg') }});">` 

 に変更（asset ヘルパメソッドを使用）

 加えてメニューのドロップダウンの箇所を編集

 `master.blade.php`

 ```diff
         <div id="page">
            <nav class="colorlib-nav" role="navigation">

                <div class="top-menu">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <div id="colorlib-logo"><a href="{{ route('home') }}">Blog</a></div>
                            </div>
                            <div class="col-md-10 text-right menu-1">
                                <ul>
                                    <li><a href="{{ route('home') }}">Home</a></li>
+                                   <li class="has-dropdown">
+                                       <a href="{{ route('categories.index') }}">Categories</a>
+                                       <ul class="dropdown">
+                                           @foreach($navbar_categories as $category)
+                                           <li><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></li>
+                                           @endforeach
+                                       </ul>
+                                   </li>
                                    <li><a href="{{ route('about') }}">About</a></li>
                                    <li><a href="{{ route('contact.create') }}">Contact</a></li>
 ```

`web.php` にルートの追加

```php
// ...

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])
    ->name('categories.show');

Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');

Route::get('/tags/{tag:name}', [TagController::class, 'show'])
    ->name('tags.show');

// ...
```

スタイルシートの追加。`public\css\mystyle.css` に以下の記述を追加

```diff
// ...

+ .categories-col .block-21 .text {
+     width: 100%;
+ }
```

`create_categories_table.php` を開き新規カラムの追加

```diff
    return new class extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
+               $table->foreignId('user_id')->constrained();
                $table->timestamps();
            });
        }
```

`database\seeders\DatabaseSeeder.php` を開きシーダーの位置を調整。また `user_id`カラムの追加

```diff
    // ...

-   $category = Category::create([
-       'name' => 'Education',
-       'slug' => 'education'
-   ]);

    $user = $role2->users()->create([
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'status' => 1,
    ]);

+   $category = Category::create([
+       'name' => 'Education',
+       'slug' => 'education',
+       'user_id' => $user->id,
+   ]);
```

リレーションの設定

`app\Models\Category.php`

```diff
class Category extends Model
{
    // ...

+   public function user()
+   {
+       return $this->belongsTo(User::class);
+   }
}
```

`app\Models\User.php`

```diff
class User extends Authenticatable
{
    // ...

+   public function categories()
+   {
+       return $this->hasMany(Category::class);
+   }
}
```

`app\Providers\AppServiceProvider.php` を編集

```diff
class AppServiceProvider extends ServiceProvider
{
    // ...

    public function boot()
    {
        Paginator::useBootstrap();

+       $categories = Category::withCount('posts')->orderBy('posts_count', 'DESC')->take(10)->get();
+       View::share('navbar_categories', $categories);
    }
}
```

## Admin パネルの作成

Admin パネルを作成する。`web.php` に Admin パネル用のルート設定を行うために以下のコードを追加。

```diff
// Admin Dashboard Routes

+ Route::get('/admin', [DashboardController::class, 'index'])
+    ->name('admin.index');
```

Admin パネル用のコントローラーを作成。以下のコマンドを入力。

```
php artisan make:controller DashboardController
```

作成された `app\Http\Controllers\AdminControllers\DashboardController.php` を編集

```diff
    // ...

    class DashboardController extends Controller
    {
+       public function index()
+       {
+           return view('admin_dashboard.index');
+       }
}
```

Udemy から Admin パネル用の素材を DL してくる。`public` フォルダ内に `admin_dashboard_assets` フォルダを新規に作成。DL したフォルダ内の `public/asetts`内のフォルダとファイルをすべてコピーして、新規に作成した`admin_dashboard_assets` フォルダにまるごとコピー。

コピーしたファイル数が多いので `.gitignore` を編集。以下を追加

```diff
// ...

+ /public/admin_dashboard_assets/
```

`resources\views` に `admin_dashboard` フォルダを作成。作成したフォルダに DL したフォルダ内の `resources/view` にある `index.blade.php` と `layouts` フォルダをコピーして貼り付け

結果、以下の様なフォルダ構造になる

```
|- resources
|    ∟ views
|        ∟ admin_dashboard
|            |- layouts
|            |    |- app.blade.php
|            |    |- header.blade.php
|            |    ∟ nav.blade.php
|            ∟ index.blade.php
```

コピーした `index.blade.php` を編集。冒頭を編集

```diff
- @extends("layouts.app")
+ @extends("admin_dashboard.layouts.app")
```

また、`index.blade.php`, `app.blade.php`, `header.blade.php`, `nav.blade.php` のすべてで以下のように asset 関数を使用した形式に編集。

```diff
- <link href="blog-template/plugins/simplebar/css/simplebar.css'" rel="stylesheet" />
+ <link href="{{ asset('admin_dashboard_assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
```

## ミドルウェアによるアクセス制限の作成

管理者用のルートのアクセス制限を設定するため、専用のミドルウェアを作成。以下のコマンドを入力

```
php artisan make:middleware IsAdmin
```

作成された `app\Http\Middleware\IsAdmin.php` を編集

```diff
    // ...

    class IsAdmin
    {
        public function handle(Request $request, Closure $next)
        {
+           if (auth()->user()->role->name === 'admin') {
+               return $next($request);
+           }
+
+           abort(403);
        }
    }
```

ミドルウェアをアプリで有効にするために `app\Http\Kernel.php` に作成したミドルウェアを定義

```diff
class Kernel extends HttpKernel
{
    // ...

    protected $routeMiddleware = [
        // ...
+       'isAdmin' => \App\Http\Middleware\IsAdmin::class,
    ];
}
```

続けて `web.php` を編集

```diff
// Admin Dashboard Routes

-   Route::get('/admin', [DashboardController::class, 'index'])
-       ->name('admin.index');

+   Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
+       Route::get('/', [DashboardController::class, 'index'])
+           ->name('index');
+   });
```

シーダーファイルを以下のように編集

```
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $role1 = Role::query()->create([
            'name' => 'user',
        ]);

        $role2 = Role::query()->create([
            'name' => 'admin',
        ]);

        $role3 = Role::query()->create([
            'name' => 'author',
        ]);

        $tag1 = Tag::query()->create([
            'name' => 'php',
        ]);

        $tag2 = Tag::query()->create([
            'name' => 'c++',
        ]);

        $tag3 = Tag::query()->create([
            'name' => 'ruby',
        ]);

        $user = $role2->users()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 1,
        ]);

        $category = Category::create([
            'name' => 'Education',
            'slug' => 'education',
            'user_id' => $user->id,
        ]);

        $post = $user->posts()->create([
            'title' => 'This is title',
            'slug' => 'This is slug',
            'excerpt' => 'This is excerpt',
            'body' => 'This is content',
            'category_id' => 1,
        ]);

        $post->comments()->create([
            'the_comment' => '1st subaru',
            'user_id' => $user->id,
        ]);

        $post->comments()->create([
            'the_comment' => '2st subaru',
            'user_id' => $user->id,
        ]);

        $post->image()->create([
            'name' => 'post file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(0, 10) . '.jpg',
        ]);

        $user->image()->create([
            'name' => 'user file',
            'extension' => 'jpg',
            'path' => 'images/' . rand(0, 10) . '.jpg',
        ]);

        $post->tags()->attach([
            $tag1->id, $tag2->id, $tag3->id
        ]);
    }
}
```

マイグレートを行う。

## 管理者画面での記事投稿の作成と更新

まずはルートの設定から。以下のように編集

```diff
// Admin Dashboard Routes

Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');

+   Route::prefix('/posts')
+       ->controller(AdminPostsController::class)
+       ->name('posts.')
+       ->group(function () {
+           Route::get('', 'index')->name('index');
+           Route::get('create', 'create')->name('create');
+           Route::post('', 'store')->name('store');
+           Route::get('{post}', 'show')->name('show');
+           Route::get('{post}/edit', 'edit')->name('edit');
+           Route::put('{post}', 'update')->name('update');
+           Route::delete('{post}', 'destroy')->name('destroy');
+       });
});
```

`AdminPostsController` を作成するために以下のコマンドを入力

```
php artisan make:controller AdminPostsController -r
```

作成されたコントローラーを以下のように編集

```php
// ...

class AdminPostsController extends Controller
{
    public function index()
    {
        return view('admin_dashboard.posts.index', [
            'posts' => Post::with('category')->get(),
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.posts.create', [
            'categories' => Category::query()->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'excerpt' => 'required|max:300',
            'category_id' => 'required|numeric',
            'thumbnail' => 'required|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227',
            'body' => 'required',
        ]);

        $validated['user_id'] = auth()->id();
        $post = Post::query()->create($validated);

        if ($request->has('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = $thumbnail->getClientOriginalName();
            $file_extension = $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);

            return redirect()
                ->route('admin.posts.create')
                ->with('success', 'Post has been created');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Post $post)
    {
        return view('admin_dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::query()->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'excerpt' => 'required|max:300',
            'category_id' => 'required|numeric',
            'thumbnail' => 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227',
            'body' => 'required',
        ]);

        $post->update($validated);

        if ($request->has('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = $thumbnail->getClientOriginalName();
            $file_extension = $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->update([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);

            return redirect()
                ->route('admin.posts.edit', $post)
                ->with('success', 'Post has been updated.');
        }
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post has been Deleted.');
    }
}
```

`create_posts_table.php` を編集。`view` カラムと `status` カラムの追加

```diff
    // ...

    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt');
            $table->text('body');

+           $table->integer('views')->default(0);
+           $table->string('status')->default('published');

            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }
```

`public/css` に `my_style.css` ファイルを新規に作成。および編集。

```css
.general-message {
    position: fixed;
    bottom: 10px;
    right: 10px;
    z-index: 5;
    min-width: 500px;
    border-radius: 50px;
    color: #525252;
} 
```

`resources/views/admin_dashboard/layouts/app.blade.php` を以下のように編集

```diff
    // ...

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
+   <meta name='csrf-token' content="{{ csrf_token() }}">
    <!--favicon-->
    <link rel="icon" href="{{ asset('admin_dashboard_assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->

    // ...
    
    <link rel="stylesheet" href="{{ asset('admin_dashboard_assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_dashboard_assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin_dashboard_assets/css/header-colors.css') }}" />

+   <link rel="stylesheet" href="{{ asset('admin_dashboard_assets/css/my_style.css') }}" />
    <title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body>
+   @if(Session::has('success'))
+   <div class='general-message alert alert-info'>{{ Session::get('success') }}</div>
+   @endif

    <!--wrapper-->
    <div class="wrapper">
        <!--start header -->

        // ...
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を以下のように編集

```diff
<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        // ...
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">

        // ...

+       <li>
+           <a href="javascript:;" class="has-arrow">
+               <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
+               </div>
+               <div class="menu-title">Posts</div>
+           </a>
+
+           <ul>
+               <li> <a href="{{ route('admin.posts.index') }}"><i class="bx bx-right-arrow-alt"></i>All Posts</a>
+               </li>
+               <li> <a href="{{ route('admin.posts.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Post</a>
+               </li>
+           </ul>
+       </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
```

`resources/views/admin_dashboard/posts/create.blade.php` を新規作成して以下のように編集

```php
@extends("admin_dashboard.layouts.app")

@section("style")
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Add New Post</h5>
                <hr />

                <form action="{{ route('admin.posts.store') }}" method='post' enctype='multipart/form-data'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Title</label>
                                        <input type="text" value='{{ old("title") }}' name='title' required class="form-control" id="inputProductTitle">

                                        @error('title')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Slug</label>
                                        <input type="text" value='{{ old("slug") }}' class="form-control" required name='slug' id="inputProductTitle">

                                        @error('slug')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Excerpt</label>
                                        <textarea required class="form-control" name='excerpt' id="inputProductDescription" rows="3">{{ old("excerpt") }}</textarea>

                                        @error('excerpt')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Category</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="rounded">
                                                    <div class="mb-3">
                                                        <select required name='category_id' class="single-select">
                                                            @foreach($categories as $key => $category)
                                                            <option value="{{ $key }}">{{ $category }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('category_id')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="inputProductDescription" class="form-label">Post Thumbnail</label>
                                                <input id='thumbnail' required name='thumbnail' id="file" type="file">

                                                @error('thumbnail')
                                                <p class='text-danger'>{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Content</label>
                                        <textarea name='body' id='post_content' class="form-control" id="inputProductDescription" rows="3">{{ old("body") }}</textarea>

                                        @error('body')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Add Post</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/posts/edit.blade.php` を新規作成して以下のように編集

```php
@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Post: {{ $post->title }}</h5>
                <hr />

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                
                                <form action="{{ route('admin.posts.update', $post) }}" method='post' enctype='multipart/form-data'>
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Title</label>
                                        <input type="text" value='{{ old("title", $post->title) }}' name='title' required class="form-control" id="inputProductTitle">

                                        @error('title')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Slug</label>
                                        <input type="text" value='{{ old("slug", $post->slug) }}' class="form-control" required name='slug' id="inputProductTitle">

                                        @error('slug')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Excerpt</label>
                                        <textarea required class="form-control" name='excerpt' id="inputProductDescription" rows="3">{{ old("excerpt", $post->excerpt) }}</textarea>

                                        @error('excerpt')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Category</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="rounded">
                                                    <div class="mb-3">
                                                        <select required name='category_id' class="single-select">
                                                            @foreach($categories as $key => $category)
                                                            <option {{ $post->category_id === $key ? 'selected' : '' }} value="{{ $key }}">{{ $category }}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('category_id')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class='row'>

                                            <div class='col-md-8'>


                                                <div class="card">
                                                    <div class="card-body">
                                                        <label for="inputProductDescription" class="form-label">Post Thumbnail</label>
                                                        <input id='thumbnail' name='thumbnail' id="file" type="file">

                                                        @error('thumbnail')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                </div>

                                            </div>

                                            <div class='col-md-4 text-center'>
                                                <img style='width: 100%' src="/storage/{{ $post->image ? $post->image->path : 'placeholders/thumbnail_placeholder.svg' }}" class='img-responsive' alt="Post Thumbnail">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Content</label>
                                        <textarea name='body' id='post_content' class="form-control" id="inputProductDescription" rows="3">
                                                {{ old("body", str_replace('../../../', '/', $post->body) ) }}
                                            </textarea>

                                        @error('body')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Update Post</button>
                                </form>

                                <form action="{{ route('admin.posts.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type='submit' class='btn btn-danger'>Delete Post</button>
                                </form>

                                </div>
                            </div>

                        </div>
                    </div>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        // $('#image-uploadify').imageuploadify();
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/posts/index.blade.php` を編集して以下のように編集

```php
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.posts.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Post</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Post#</th>
                                <th>Post Title</th>
                                <th>Post Excerpt</th>
                                <th>Category</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $post->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->title }} </td>

                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>


                                <td>
                                    <div class="badge rounded-pill @if($post->status === 'published') {{ 'text-info bg-light-info' }} @elseif($post->status === 'draft') {{ 'text-warning bg-light-warning' }} @else {{ 'text-danger bg-light-danger' }} @endif p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>{{ $post->status }}</div>
                                </td>

                                <td>{{ $post->views }}</td>

                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $post->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.posts.destroy', $post) }}" id='delete_form_{{ $post->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection


@section("script")

<script>
    $(document).ready(function () {
        
            setTimeout(() => {
                $(".general-message").fadeOut();
            }, 5000);
        });
</script>
@endsection 
```

`resources/views/components/blog/side-recent-posts.blade.php` を以下のように編集

```diff
    // ...

    @foreach ($recentPosts as $recent_post)
    <div class="f-blog">
-        <a href="{{ route('posts.show', $recent_post) }}" class="blog-img" style="background-image: url({{ asset('storage/' . $recent_post->image->path ) }});">
+       <a
+          href="{{ route('posts.show', $recent_post) }}"
+          class="blog-img"
+          style="background-image: url({{ asset($recent_post->image ? 'storage/' . $recent_post->image->path : 'storage/placeholders/thumbnail_placeholder.svg' . '')  }});">
        </a>
        <div class="desc">
            <p class="admin"><span>{{ $recent_post->created_at->diffForHumans() }}</span></p>
```


## 管理者画面でのカテゴリー情報の登録と更新

管理者画面にて、カテゴリー用の更新ページを作成する。以下のコマンドを入力してカテゴリー用のコントローラーを作成。

```
php artisan make:controller AdminControllers/AdminCategoriesController
```

作成されたコントローラーを開いて以下のように編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Category;

class AdminCategoriesController extends Controller
{
    private $rules = [
        'name' => 'required|min:3|max:30',
        'slug' => 'required|unique:categories,slug'
    ];

    public function index()
    {
        return view('admin_dashboard.categories.index', [
            'categories' => Category::with('user')->orderBy('id', 'DESC')->paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $validated['user_id'] = auth()->id();
        Category::create($validated);

        return redirect()->route('admin.categories.create')->with('success', 'Category has been Created.');
    }

    public function show(Category $category)
    {
        return view('admin_dashboard.categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin_dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $this->rules['slug'] = ['required', Rule::unique('categories')->ignore($category)];
        $validated = $request->validate($this->rules);

        $category->update($validated);

        return redirect()->route('admin.categories.edit', $category)->with('success', 'Category has been Updated.');
    }

    public function destroy(Category $category)
    {
        $default_category_id = Category::where('name', 'Uncategorized')->first()->id;

        if($category->name === 'Uncategorized')
            abort(404);

        $category->posts()->update(['category_id' => $default_category_id]);

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category has been Deleted.');
    }
}
```

次に `Category.php` モデルを編集

```diff
    // ...

    class Category extends Model
    {
        use HasFactory;

-       protected $fillable = ['name', 'slug'];
+       protected $fillable = ['name', 'slug' ,'user_id'];

        public function posts()
        {
            // ...
        }

        // ...
    }
```

カテゴリー用のページの Blade を作成。`resources/views/admin_dashboard` に `categories` フォルダを新規に作成し `create.blade.php`、`edit.blade.php`、`index.blade.php`、`show.blade.php` を作成する。

`resources/views/admin_dashboard/categories/create.blade.php`

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Add New Category</h5>
                <hr/>

                <form action="{{ route('admin.categories.store') }}" method='post'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Category Name</label>
                                        <input type="text" value='{{ old("name") }}' name='name' required class="form-control" id="inputProductTitle">

                                        @error('title')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Category Slug</label>
                                        <input type="text" value='{{ old("slug") }}' class="form-control" required name='slug' id="inputProductTitle">

                                        @error('slug')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Add Category</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
    $(document).ready(function () {
        
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/categories/edit.blade.php` 

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Category: {{ $category->name }}</h5>
                <hr/>

                <form action="{{ route('admin.categories.update', $category) }}" method='post'>
                    @csrf
                    @method('PATCH')

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Category Name</label>
                                        <input type="text" value='{{ old("name", $category->name) }}' name='name' required class="form-control" id="inputProductTitle">

                                        @error('title')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Category Slug</label>
                                        <input type="text" value='{{ old("slug", $category->slug) }}' class="form-control" required name='slug' id="inputProductTitle">

                                        @error('slug')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Update Category</button>

                                    <a 
                                    class='btn btn-danger'
                                    onclick="event.preventDefault();document.getElementById('delete_category_{{ $category->id }}').submit()"
                                    href="#">Delete Category</a>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                <form id='delete_category_{{ $category->id }}' method='post' action="{{ route('admin.categories.destroy', $category) }}">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
$(document).ready(function () {
    
    setTimeout(() => {
        $(".general-message").fadeOut();
    }, 5000);
});
</script>
@endsection 
```

`resources/views/admin_dashboard/categories/index.blade.php`

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.categories.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Category</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category#</th>
                                <th>Category Name</th>
                                <th>Creator</th>
                                <th>Related Posts</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $category->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->name }} </td>
                                <td>{{ $category->user->name }}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href="{{ route('admin.categories.show', $category) }}">Related Posts</a>
                                </td>
                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $category->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.categories.destroy', $category) }}" id='delete_form_{{ $category->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='mt-4'>
                {{ $categories->links() }}
                </div>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/categories/index.blade.php`

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.categories.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Category</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category#</th>
                                <th>Category Name</th>
                                <th>Creator</th>
                                <th>Related Posts</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $category->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->name }} </td>
                                <td>{{ $category->user->name }}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href="{{ route('admin.categories.show', $category) }}">Related Posts</a>
                                </td>
                                <td>{{ $category->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $category->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.categories.destroy', $category) }}" id='delete_form_{{ $category->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='mt-4'>
                {{ $categories->links() }}
                </div>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/categories/show.blade.php`

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ $category->name }} Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Category Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.posts.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Post</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Post#</th>
                                <th>Post Title</th>
                                <th>Post Excerpt</th>
                                <th>Category</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $post->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->title }} </td>

                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>


                                <td>
                                    <div class="badge rounded-pill @if($post->status === 'published') {{ 'text-info bg-light-info' }} @elseif($post->status === 'draft') {{ 'text-warning bg-light-warning' }} @else {{ 'text-danger bg-light-danger' }} @endif p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>{{ $post->status }}</div>
                                </td>

                                <td>{{ $post->views }}</td>

                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $post->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.posts.destroy', $post) }}" id='delete_form_{{ $post->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を更新。できるだけコードをシンプルにする

```html
<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('admin_dashboard_assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">MYBLOG</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ url('index') }}" target="_blank">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                </div>
                <div class="menu-title">Posts</div>
            </a>

            <ul>
                <li> <a href="{{ route('admin.posts.index') }}"><i class="bx bx-right-arrow-alt"></i>All Posts</a>
                </li>
                <li> <a href="{{ route('admin.posts.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Post</a>
                </li>
                
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-menu'></i>
                </div>
                <div class="menu-title">Categories</div>
            </a>

            <ul>
                <li> <a href="{{ route('admin.categories.index') }}"><i class="bx bx-right-arrow-alt"></i>All Categories</a>
                </li>
                <li> <a href="{{ route('admin.categories.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Category</a>
                </li>
                
            </ul>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
```

`resources/views/admin_dashboard/posts/create.blade.php` を編集。

```diff
    // ...
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
-               <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
+               <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
            </ol>
            // ...
```

`resources/views/admin_dashboard/posts/edit.blade.php` を編集。

```diff
    // ...
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
-               <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
+               <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
            </ol>
```

`resources/views/admin_dashboard/posts/index.blade.php` を編集

```diff
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Posts</li>
                <li class="breadcrumb-item active" aria-current="page">All Posts</li>
            </ol>
        </nav>
    </div>				<div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
-               <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
+               <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                </li>
-               <li class="breadcrumb-item active" aria-current="page">Posts</li>
+               <li class="breadcrumb-item active" aria-current="page">All Posts</li>
            </ol>
        </nav>
    </div>
```

`routes/web.php` を編集。

```diff
    // ...

    // Admin Dashboard Routes

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');

        Route::prefix('/posts')
            ->controller(AdminPostsController::class)
            ->name('posts.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('{post}', 'show')->name('show');
                Route::get('{post}/edit', 'edit')->name('edit');
                Route::put('{post}', 'update')->name('update');
                Route::delete('{post}', 'destroy')->name('destroy');
            });

+       Route::prefix('/categories')
+           ->controller(AdminCategoriesController::class)
+           ->name('categories.')
+           ->group(function () {
+               Route::get('', 'index')->name('index');
+               Route::get('create', 'create')->name('create');
+               Route::post('', 'store')->name('store');
+               Route::get('{category}', 'show')->name('show');
+               Route::get('{category}/edit', 'edit')->name('edit');
+               Route::put('{category}', 'update')->name('update');
+               Route::delete('{category}', 'destroy')->name('destroy');
+           });
    });
```

## 管理者画面でのタグ情報の登録と更新

`app/Http/Controllers/AdminControllers/AdminPostsController.php` 管理者画面でタグ情報の更新をする

```diff
    use App\Models\Category;
    use App\Models\Post;
+   use App\Models\Tag;

    class AdminPostsController extends Controller
    {

            // ...
                    'path' => $path
                ]);
            }

+           $tags = explode(',', $request->input('tags'));
+           $tags_ids = [];
+           foreach($tags as $tag){
+               $tag_ob = Tag::create(['name' => trim($tag)]);
+               $tags_ids[] = $tag_ob->id;
+           }
+
+           if(count($tags_ids) > 0)
+               $post->tags()->sync( $tags_ids );

            return redirect()->route('admin.posts.create')->with('success', 'Post has been created.');
        }

        // ...

        public function edit(Post $post)
        {
+           $tags = '';
+           foreach($post->tags as $key => $tag)
+           {
+               $tags .= $tag->name;
+               if($key !== count($post->tags) - 1)
+                   $tags .= ', ';
+           }

            return view('admin_dashboard.posts.edit', [
                'post' => $post,
+               'tags' => $tags,
                'categories' => Category::pluck('name', 'id')
            ]);
        }

        public function update(Request $request, Post $post)
        {
-           $this->rules['thumbnail'] = 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227';
+           $this->rules['thumbnail'] = 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=800,max_height=300';
            $validated = $request->validate($this->rules);

            $post->update($validated);

                    // ...

                    'path' => $path
                ]);
            }

+           $tags = explode(',', $request->input('tags'));
+           $tags_ids = [];
+           foreach($tags as $tag){
+
+               $tag_exist = $post->tags()->where('name', trim($tag) )->count();
+               if($tag_exist == 0) {
+                   $tag_ob = Tag::create(['name' => $tag]);
+                   $tags_ids[] = $tag_ob->id;
+               }
+           }
+
+           if(count($tags_ids) > 0)
+               $post->tags()->syncWithoutDetaching( $tags_ids );

            return redirect()->route('admin.posts.edit', $post)->with('success', 'Post has been updated.');
        }

        public function destroy(Post $post)
        {
+           $post->tags()->delete();
            $post->delete();
            return redirect()->route('admin.posts.index')->with('success', 'Post has been Deleted.');
        }
```

`app/Http/Controllers/AdminControllers/AdminTagsController.php` を作成。以下のコマンドを入力。

```
php artisan make:controller AdminTagsController.php
```

作成されたファイルを開き以下のように編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tag;

class AdminTagsController extends Controller
{
    public function index()
    {
        return view('admin_dashboard.tags.index', [
            'tags' => Tag::with('posts')->paginate(50),
        ]);
    }


    public function show(Tag $tag)
    {
        return view('admin_dashboard.tags.show', [
            'tag' => $tag
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag has been Deleted.');
    }
}
```

`Tag` モデル編集。`app/Models/Tag.php`


```
    class Tag extends Model
    {
        use HasFactory;

+       protected $fillable = ['name'];

        public function posts()
        {
            return $this->belongsToMany(Post::class);
```

`database/migrations/2021_08_08_204758_create_post_tag_table.php` を編集。

```diff
    Schema::create('post_tag', function (Blueprint $table) {
        $table->id();

-       $table->unsignedBigInteger('post_id');
-       $table->unsignedBigInteger('tag_id');
+       $table->foreignId('post_id')->constrained()->onDelete('cascade');
+       $table->foreignId('tag_id');

        $table->timestamps();
    });
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
        // ...
                    </ul>
                </li>

+               <li>
+                   <a href="{{ route('admin.tags.index') }}">
+                   <div class="parent-icon"><i class='bx bx-purchase-tag'></i></div>
+                       <div class="menu-title">Tags</div>
+                   </a>
+               </li>


            </ul>
            <!--end navigation-->
        </div>

        // ...
```

`resources/views/admin_dashboard/posts/create.blade.php` を編集

```diff
    // ...

    <link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

+   <link href="{{ asset('admin_dashboard_assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js" integrity="sha512-XNYSOn0laKYg55QGFv1r3sIlQWCAyNKjCa+XXF5uliZH+8ohn327Ewr2bpEnssV9Zw3pB3pmVvPQNrnCTRZtCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @endsection

    // ...

        </div>
    </div>

+ <div class="mb-3">
+     <label class="form-label">Post Tags</label>
+     <input type="text" class="form-control" name='tags' data-role="tagsinput">
+ </div>

    <div class="mb-3">
        <div class="card">
            <div class="card-body">

    // ...
    
    @section("script")
    <script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>
+   <script src="{{ asset('admin_dashboard_assets/plugins/input-tags/js/tagsinput.js') }}"></script>

    <script>
        $(document).ready(function () {
```

`resources/views/admin_dashboard/posts/edit.blade.php` を編集

```diff
    <link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

+   <link href="{{ asset('admin_dashboard_assets/plugins/input-tags/css/tagsinput.css') }}" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js" integrity="sha512-XNYSOn0laKYg55QGFv1r3sIlQWCAyNKjCa+XXF5uliZH+8ohn327Ewr2bpEnssV9Zw3pB3pmVvPQNrnCTRZtCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @endsection

    // ...

                                                </div>
                                            </div>

+                                           <div class="mb-3">
+                                               <label class="form-label">Post Tags</label>
+                                               <input type="text" class="form-control" value='{{ $tags }}' name='tags' data-role="tagsinput">
+                                           </div>

                                            <div class="mb-3">
                                                <div class='row'>

    // ...
                                            <div class="mb-3">
                                                <label for="inputProductDescription" class="form-label">Post Content</label>
                                                <textarea name='body' id='post_content' class="form-control" id="inputProductDescription" rows="3">
-                                                   {{ old("body", str_replace('../../../', '/', $post->body) ) }}
+                                                  {{ old("body", str_replace('../../', '../../../', $post->body) ) }}
                                                </textarea>

                                                @error('body')
                                                
                                                // ...
                                                
                                            </div>

                                            <button class='btn btn-primary' type='submit'>Update Post</button>

-                                           <form action="{{ route('admin.posts.destroy', $post) }}">
-                                               @csrf
-                                               @method('DELETE')
-
-                                               <button type='submit' class='btn btn-danger'>Delete Post</button>
-                                           </form>
+                                           <a 
+                                           class='btn btn-danger'
+                                           onclick="event.preventDefault();document.getElementById('delete_post_{{ $post->id }}').submit()"
+                                           href="#">Delete Post</a>

                                        </div>
                                    </div>
                                    // ...
                            </div>
                        </form>

+                       <form method='post' id='delete_post_{{ $post->id }}' action="{{ route('admin.posts.destroy', $post) }}">
+                           @csrf
+                           @method('DELETE')
+                       </form>

                    </div>
                </div>

                // ...

    <script src="{{ asset('admin_dashboard_assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
    <script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

+   <script src="{{ asset('admin_dashboard_assets/plugins/input-tags/js/tagsinput.js') }}"></script>
    <script>
        $(document).ready(function () {
```

`resources/views/admin_dashboard/tags/index.blade.php` を新規作成し編集

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tags</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Tags</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Tag#</th>
                                <th>Tag Name</th>
                                <th>Related Posts</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $tag->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $tag->name }} </td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href="{{ route('admin.tags.show', $tag) }}">Related Posts</a>
                                </td>
                                <td>{{ $tag->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $tag->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.tags.destroy', $tag) }}" id='delete_form_{{ $tag->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='mt-4'>
                {{ $tags->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
    <script>
        $(document).ready(function () {
            setTimeout(() => {
                $(".general-message").fadeOut();
            }, 5000);
        });
    </script>
@endsection 
```

`resources/views/admin_dashboard/tags/show.blade.php` を新規に作成し編集

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ $tag->name }} Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tag Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.posts.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Post</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Post#</th>
                                <th>Post Title</th>
                                <th>Post Excerpt</th>
                                <th>Category</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tag->posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $post->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->title }} </td>

                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>


                                <td>
                                    <div class="badge rounded-pill @if($post->status === 'published') {{ 'text-info bg-light-info' }} @elseif($post->status === 'draft') {{ 'text-warning bg-light-warning' }} @else {{ 'text-danger bg-light-danger' }} @endif p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>{{ $post->status }}</div>
                                </td>

                                <td>{{ $post->views }}</td>

                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $post->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.posts.destroy', $post) }}" id='delete_form_{{ $post->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection


@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/post.blade.php` を編集

```diff
    @extends('main_layouts.master')

-  @section('title', 'MyBlog | This is single post')
+   @section('title', $post->title . ' | MyBlog')

    @section('custom_css')

        <style>
            .class-single .desc img {
                width: 100%;
            }
        </style>

    @endsection

    @section('content')

    // ...

    <div class="row row-pb-lg">
        <div class="col-md-12 animate-box">
            <div class="classes class-single">
-               <div class="classes-img" style="background-image: url(/blog_template/images/classes-1.jpg);">
+               <div class="classes-img" style="background-image: url({{ asset($post->image ? 'storage/' . $post->image->path : 'storage/placeholders/thumbnail_placeholder.svg' . '')  }});">
                </div>
                <div class="desc desc2">
-                   <h3><a href="#">Developing Mobile Apps</a></h3>
-                   <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
-                   <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.</p>
-                   <blockquote>
-                       The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
-                   </blockquote>
-                   <h3>Some Features</h3>
-                   <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.</p>
-                    <p><a href="#" class="btn btn-primary btn-outline btn-lg">Live Preview</a> or <a href="#" class="btn btn-primary btn-lg">Download File</a></p>
+                   {!! $post->body !!}
                </div>
            </div>
        </div>
```

`routes/web.php` を編集

```diff
    // Admin Dashboard Routes

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

+       Route::prefix('/tags')
+           ->controller(AdminCategoriesController::class)
+           ->name('tags.')
+           ->group(function () {
+               Route::get('', 'index')->name('index');
+               Route::get('{category}', 'show')->name('show');
+               Route::delete('{category}', 'destroy')->name('destroy');
+           });
    });
```

## 管理者画面でのコメントの更新と削除

管理者画面にてコメントの更新と削除を行う。

`app/Http/Controllers/AdminControllers/AdminCommentsController.php` を新規に作成。以下のコマンドを入力

```
php artisan make:controller AdminCommentsController -r
```

作成されたコントローラーを編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Comment;

class AdminCommentsController extends Controller
{
    private $rules = [
        'post_id' => 'required|numeric',
        'the_comment' => 'required|min:3|max:1000'
    ];

    public function index()
    {
        return view('admin_dashboard.comments.index', [
            'comments' => Comment::latest()->paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.comments.create', [
            'posts' => Post::pluck('title', 'id')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $validated['user_id'] = auth()->id();

        Comment::create($validated);
        return redirect()->route('admin.comments.create')->with('success', 'Comment has been added.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('admin_dashboard.comments.edit', [
            'posts' => Post::pluck('title', 'id'),
            'comment' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate($this->rules);
        $comment->update($validated);
        return redirect()->route('admin.comments.edit', $comment)->with('success', 'Comment has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Comment has been deleted.');
    }
}
```

`resources/views/admin_dashboard/comments/create.blade.php` を新規に作成して以下を入力

```html
@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Comments</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Comment</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New Comment</h5>
                    <hr/>

                    <form action="{{ route('admin.comments.store') }}" method='post'>
                        @csrf

                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Related Post</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rounded">
                                                        <div class="mb-3">
                                                            <select required name='post_id' class="single-select">
                                                                @foreach($posts as $key => $post)
                                                                <option value="{{ $key }}">{{ $post }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('post_id')
                                                                <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post Comment</label>
                                            <textarea name='the_comment'  id='post_comment' class="form-control" id="inputProductDescription" rows="3">{{ old("the_comment") }}</textarea>

                                            @error('the_comment')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button class='btn btn-primary' type='submit'>Add Comment</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    @endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/comments/edit.blade.php` を新規に作成して以下を入力

```html
@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Comments</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Comment</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New Comment</h5>
                    <hr/>

                    <form action="{{ route('admin.comments.update', $comment) }}" method='post'>
                        @csrf
                        @method('PATCH')

                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Related Post</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rounded">
                                                        <div class="mb-3">
                                                            <select required name='post_id' class="single-select">
                                                                @foreach($posts as $key => $post)
                                                                <option {{ $comment->post_id === $key ? 'selected' : '' }} value="{{ $key }}">{{ $post }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('post_id')
                                                                <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post Comment</label>
                                            <textarea name='the_comment'  id='post_comment' class="form-control" id="inputProductDescription" rows="3">{{ old("the_comment", $comment->the_comment) }}</textarea>

                                            @error('the_comment')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button class='btn btn-primary' type='submit'>Update Comment</button>

                                        <a 
                                        class='btn btn-danger'
                                        onclick="event.preventDefault(); document.getElementById('comment_delete_form_{{ $comment->id }}').submit()"
                                        href="#">Delete Comment</a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <form id='comment_delete_form_{{ $comment->id }}' method='post' action="{{ route('admin.comments.destroy', $comment) }}">@csrf @method('DELETE')</form>

                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    @endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/comments/index.blade.php` を新規に作成して以下を入力

```html
@extends("admin_dashboard.layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Comments</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Comments</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								<input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
							</div>
						  <div class="ms-auto"><a href="{{ route('admin.comments.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Comment</a></div>
						</div>
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>Comment#</th>
										<th>Comment Author</th>
                                        <th>Comment Body</th>
                                        <th>View Comment</th>
										<th>Created at</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($comments as $comment)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div>
													<input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
												</div>
												<div class="ms-2">
													<h6 class="mb-0 font-14">#P-{{ $comment->id }}</h6>
												</div>
											</div>
										</td>
										<td>{{ $comment->user->name }} </td>
                                        <td>{{ \Str::limit($comment->the_comment, 60) }} </td>
                                        <td>
                                            <a target='_blank' class='btn btn-primary btn-sm' href="{{ route('posts.show', $comment->post->slug) }}#comment_{{ $comment->id }}">View Comment</a>
                                        </td>
                                        <td>{{ $comment->created_at->diffForHumans() }}</td>
                                        <td>
											<div class="d-flex order-actions">
												<a href="{{ route('admin.comments.edit', $comment) }}" class=""><i class='bx bxs-edit'></i></a>
												<a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $comment->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                                <form method='post' action="{{ route('admin.comments.destroy', $comment) }}" id='delete_form_{{ $comment->id }}'>@csrf @method('DELETE')</form>
                                            </div>
										</td>
									</tr>
                                    @endforeach
								</tbody>
							</table>
						</div>

                        <div class='mt-4'>
                        {{ $comments->links() }}
                        </div>

					</div>
				</div>


			</div>
		</div>
		<!--end page wrapper -->
		@endsection


@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
// ...
                </li>

+               <li>
+                   <a href="javascript:;" class="has-arrow">
+                       <div class="parent-icon"><i class='bx bx-comment-dots'></i>
+                       </div>
+                       <div class="menu-title">Comments</div>
+                   </a>
+                   <ul>
+                       <li> <a href="{{ route('admin.comments.index') }}"><i class="bx bx-right-arrow-alt"></i>All Comments</a>
+                       </li>
+                       <li> <a href="{{ route('admin.comments.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Comment</a>
+                       </li>
+                   </ul>
+               </li>

            </ul>
            <!--end navigation-->
        </div>
        //...
```

`routes/web.php` を編集


```diff
    // Admin Dashboard Routes

    Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

        // ...

+       Route::prefix('/comments')
+           ->controller(AdminCommentsController::class)
+           ->name('comments.')
+           ->group(function () {
+               Route::get('', 'index')->name('index');
+               Route::get('create', 'create')->name('create');
+               Route::post('', 'store')->name('store');
+               Route::get('{comments}/edit', 'edit')->name('edit');
+               Route::put('{comments}', 'update')->name('update');
+               Route::delete('{comments}', 'destroy')->name('destroy');
+           });
    });
```

## 管理画面でのロールとパーミッション設定

`app/Http/Controllers/AdminControllers/AdminRolesController.php` を新規に作成。以下のコマンド入力

```
php artisan make:contorlller AdminRolesController -r
```

作成したコントローラーを以下のように入力

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Permission;
use App\Models\Role;

class AdminRolesController extends Controller
{
    private $rules = ['name' => 'required|unique:roles,name'];

    public function index()
    {
        return view('admin_dashboard.roles.index', [
            'roles' => Role::paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.roles.create', [
            'permissions' => Permission::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $permissions = $request->input('permissions');

        $role = Role::create($validated);
        $role->permissions()->sync( $permissions );

        return redirect()->route('admin.roles.create')->with('success', 'Role has been created');
    }

    public function edit(Role $role)
    {
        return view('admin_dashboard.roles.edit', [
            'role' => $role,
            'permissions' => Permission::all()
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $this->rules['name'] = ['required', Rule::unique('roles')->ignore($role)];
        $validated = $request->validate($this->rules);
        $permissions = $request->input('permissions');

        $role->update($validated);
        $role->permissions()->sync( $permissions );

        return redirect()->route('admin.roles.edit', $role)->with('success', 'Role has been updated');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role has been deleted');
    }
}
```

ミドルウェアを作成。以下のコマンドを入力

```
php artisan make:middleware CheckPermission
```

作成されたミドルウェアを編集

```diff
    // ...

    class CheckPermission
    {
+       public function handle(Request $request, Closure $next)
+       {
+           // 1- get the route name
+           $route_name = $request->route()->getName();
+           // 2- get permissions for this authintecated person
+           $routes_arr = auth()->user()->role->permissions->toArray();
+           // 3- compare this route name with user permissions
+           foreach($routes_arr as $route)
+           {
+               // 4- if this route name is one of these permissions
+               if($route['name'] === $route_name)
+                   // 5- allow user to access
+                   return $next($request);
+           }
+           // 6- else about 403 Unauthoerized Access
+           abort(403, 'Access Denied | Unauthorized');
+        }
    }
```

`Permission` モデルを作成。以下のコマンドを入力

```
php artisan make:model Permission -m
```

作成された `app/Models/Permission.php` ファイルを編集

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role')->withTimestamps();
    }
}
```

作成された `database/migrations/2021_10_31_202120_create_permissions_table.php` を編集

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
```

`app/Models/Role.php` を編集

```diff
    // ...

    class Role extends Model
    {
        public function users(){
            return $this->hasMany(User::class);
        }

+       public function permissions()
+       {
+           return $this->belongsToMany(Permission::class, 'permission_role')->withTimestamps();
+       }
    }
```

中間テーブル用のマイグレーションファイルを作成 `database/migrations/○○○○_create_pivot_table_permissions_roles.php` ファイルを編集

```diff
    class CreatePivotTablePermissionsRoles extends Migration
    {
        public function up()
        {
            Schema::create('permission_role', function (Blueprint $table) {
                $table->id();
+               $table->foreignId('permission_id');
+               $table->foreignId('role_id');
                $table->timestamps();
            });
        }

        // ...
    }
```

`database/migrations/2013_08_01_200529_create_roles_table.php` を編集

```diff
    // ...
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
-           $table->string('name');
+           $table->string('name')->unique();
            $table->timestamps();
        });
    }
```

`database/seeders/DatabaseSeeder.php` を編集

```diff
        \App\Models\Role::factory(1)->create();
        \App\Models\Role::factory(1)->create(['name' => 'admin']);

+       $blog_routes = Route::getRoutes();
+       $permissions_ids = [];
+       foreach($blog_routes as $route)
+       {
+           if(strpos($route->getName(), 'admin') !== false) {
+               $permission = \App\Models\Permission::create(['name' => $route->getName()]);
+               $permissions_ids[] = $permission->id;
+           }
+       }
+
+       \App\Models\Role::where('name', 'admin')->first()->permissions()->sync( $permissions_ids );

        $users = \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'ahmed',
```

`resources/views/admin_dashboard/categories/create.blade.php` を編集

    ```diff                                            <label for="inputProductTitle" class="form-label">Category Name</label>
        <input type="text" value='{{ old("name") }}' name='name' required class="form-control" id="inputProductTitle">

-       @error('title')
+       @error('name')
            <p class='text-danger'>{{ $message }}</p>
        @enderror
    </div>
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
-           <a href="{{ url('index') }}" target="_blank">
+           <a href="{{ route('admin.index') }}">
            <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
                <div class="menu-title">Dashboard</div>
            </a>

            // ...

            </a>
        </li>


        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-comment-dots'></i>

                // ...

            </ul>
        </li>

+       <hr>
+
+       <li>
+           <a href="javascript:;" class="has-arrow">
+               <div class="parent-icon"><i class='bx bx-key'></i>
+               </div>
+               <div class="menu-title">Roles</div>
+           </a>
+
+           <ul>
+               <li> <a href="{{ route('admin.roles.index') }}"><i class="bx bx-right-arrow-alt"></i>All Roles</a>
+               </li>
+               <li> <a href="{{ route('admin.roles.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New Role</a>
+               </li>
+
+           </ul>
+       </li>                


    </ul>
    <!--end navigation-->
```

`resources/views/admin_dashboard/roles/create.blade.php` を編集

```html
@extends("admin_dashboard.layouts.app")

@section('style')
<style>
    .permission {
        background-color: white;
        padding: 5px 10px;
        display: inline-block;
        font-size: 15px;
        margin: 10px 10px;
        cursor: pointer;
    }
</style>
@endsection
@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Roles</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Roles</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Add New Role</h5>
                <hr/>

                <form action="{{ route('admin.roles.store') }}" method='post'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Name</label>
                                        <input type="text" value='{{ old("name") }}' name='name' required class="form-control" id="inputProductTitle">

                                        @error('name')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Permissions</label>

                                        <div class='row'>
                                            @php 
                                                $the_count = count($permissions); 
                                                $start = 0;
                                            @endphp

                                            @for($j = 1; $j <= 3; $j++)
                                            @php 
                                                $end = round($the_count * ( $j / 3 ));
                                            @endphp

                                            <div class='col-md-4'>

                                                @for($i = $start; $i < $end; $i++)
                                                    <label class="permission">
                                                    <input type="checkbox" name='permissions[]' value='{{ $permissions[$i]->id }}'> {{ $permissions[$i]->name }}
                                                    </label>    

                                                @endfor

                                            </div>
                                            @php 
                                                $start = $end;
                                            @endphp
                                            @endfor

                                        </div>
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Add Role</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
$(document).ready(function () {
    
    setTimeout(() => {
        $(".general-message").fadeOut();
    }, 5000);
});
</script>
@endsection 
```

`resources/views/admin_dashboard/roles/edit.blade.php` を編集

```html
@extends("admin_dashboard.layouts.app")

@section('style')
<style>
    .permission {
        background-color: white;
        padding: 5px 10px;
        display: inline-block;
        font-size: 15px;
        margin: 10px 10px;
        cursor: pointer;
    }
</style>
@endsection
@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Roles</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Roles</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Role: {{ $role->name }}</h5>
                <hr/>

                <form action="{{ route('admin.roles.update', $role) }}" method='post'>
                    @csrf
                    @method('PATCH')

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Name</label>
                                        <input type="text" value='{{ old("name", $role->name) }}' name='name' required class="form-control" id="inputProductTitle">

                                        @error('name')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Permissions</label>

                                        <div class='row'>
                                            @php 
                                                $the_count = count($permissions); 
                                                $start = 0;
                                            @endphp

                                            @for($j = 1; $j <= 3; $j++)
                                            @php 
                                                $end = round($the_count * ( $j / 3 ));
                                            @endphp

                                            <div class='col-md-4'>

                                                @for($i = $start; $i < $end; $i++)
                                                    <label class="permission">
                                                    <input {{ $role->permissions->contains( $permissions[$i]->id ) ? 'checked' : '' }} type="checkbox" name='permissions[]' value='{{ $permissions[$i]->id }}'> {{ $permissions[$i]->name }}
                                                    </label>    

                                                @endfor

                                            </div>
                                            @php 
                                                $start = $end;
                                            @endphp
                                            @endfor

                                        </div>
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Update Role</button>

                                    <a 
                                    class='btn btn-danger'
                                    onclick="event.preventDefault();document.getElementById('delete_role_{{ $role->id }}').submit()"
                                    href="#">Delete Role</a>


                                </div>
                            </div>

                        </div>
                    </div>
                </form>

                <form id='delete_role_{{ $role->id }}' method='post' action="{{ route('admin.roles.destroy', $role) }}">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script>
$(document).ready(function () {
    
    setTimeout(() => {
        $(".general-message").fadeOut();
    }, 5000);
});
</script>
@endsection 
```

`resources/views/admin_dashboard/roles/index.blade.php` を編集

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Roles</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Roles</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.roles.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Role</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Role#</th>
                                <th>Role Name</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $role->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $role->name }} </td>
                                <td>{{ $role->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.roles.edit', $role) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $role->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.roles.destroy', $role) }}" id='delete_form_{{ $role->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class='mt-4'>
                {{ $roles->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")

<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`routes/web.php` を編集

```diff
    // Admin Dashboard Routes

-   Route::name('admin.')->prefix('admin')->middleware(['auth', 'isadmin'])->group(function(){
+   Route::name('admin.')->prefix('admin')->middleware(['auth', 'isadmin', 'check_permissions'])->group(function(){

        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::post('upload_tinymce_image', [TinyMCEController::class, 'upload_tinymce_image'])->name('upload_tinymce_image');

        // ...

        Route::resource('categories', AdminCategoriesController::class);
        Route::resource('tags', AdminTagsController::class)->only(['index', 'show', 'destroy']);
        Route::resource('comments', AdminCommentsController::class)->except('show');

        Route::resource('roles', AdminRolesController::class)->except('show');
    });
```

## 管理者画面での User の更新

管理画面で使用する `AdminUsersController.php` を作成する。以下のコマンドを入力

```
php artisan make:controller AdminControllers/AdminUsersController -r
```

作成されたファイルを以下のように編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Role;
use App\Models\User;

class AdminUsersController extends Controller
{
    private $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|max:20',
        'image' => 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=300',
        'role_id' => 'required|numeric'
    ];

    public function index()
    {
        return view('admin_dashboard.users.index', [
            'users' => User::with('role')->paginate('50')
        ]);
    }

    public function create()
    {
        return view('admin_dashboard.users.create', [
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules);
        $validated['password'] = Hash::make($request->input('password'));

        $user = User::create($validated);

        if($request->has('image'))
        {
            $image = $request->file('image');

            $filename = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $path = $image->store('images', 'public');

            $user->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path
            ]);
        }

        return redirect()->route('admin.users.create')->with('success', 'User has been created.');
    }

    public function edit(User $user)
    {
        return view('admin_dashboard.users.edit', [
            'user' => $user,
            'roles' => Role::pluck('name', 'id')
        ]);
    }

    public function show(User $user)
    {
        return view('admin_dashboard.users.show',[
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->rules['password'] = 'nullable|min:3|max:20';
        $this->rules['email'] = ['required', 'email', Rule::unique('users')->ignore($user)];

        $validated = $request->validate($this->rules);

        if($validated['password'] === null)
            unset($validated['password']);
        else 
            $validated['password'] = Hash::make($request->input('password'));

        $user->update($validated);

        if($request->has('image'))
        {
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $path = $image->store('images', 'public');

            $user->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path
            ]);
        }

        return redirect()->route('admin.users.edit', $user)->with('success', 'User has been updated.');
    }

    public function destroy(User $user)
    {
        if($user->id === auth()->id())
            return redirect()->back()->with('error', 'You can not delete your self.');

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User has been deleted.');
    }
}
```

`app/Http/Middleware/IsAdmin.php` ミドルウェアを削除して、その内容を `app/Http/Middleware/CheckPermission.php` に入力。

```diff
    // ...

    {
        public function handle(Request $request, Closure $next)
        {
    +       // admin has permissions for everything
    +       if(auth()->user()->role->name === 'admin')
    +           return $next($request);

            // 1- get the route name
            $route_name = $request->route()->getName();
            // 2- get permissions for this authintecated person
            $routes_arr = auth()->user()->role->permissions->toArray();
            // 3- compare this route name with user permissions
            foreach($routes_arr as $route)
            {
                // 4- if this route name is one of these permissions
                if($route['name'] === $route_name)
                    // 5- allow user to access
                    return $next($request);
            }
            // 6- else about 403 Unauthoerized Access
            abort(403, 'Access Denied | Unauthorized');
            
        }
    }
```

以前のミドルウェアを削除。`app/Http/Kernel.php` を編集

```diff
            // ...

            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
-           'isadmin' => \App\Http\Middleware\IsAdmin::class,
            'check_permissions' => \App\Http\Middleware\CheckPermission::class
        ];
    }
```

`resources/views/admin_dashboard/layouts/app.blade.php` を編集

```diff
        <div class='general-message alert alert-info'>{{ Session::get('success') }}</div>
    @endif

+   @if(Session::has('error'))
+       <div class='general-message alert alert-danger'>{{ Session::get('error') }}</div>
+   @endif

	<!--wrapper-->
	<div class="wrapper">
		<!--start header -->
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
                // ...

+               <li>
+                   <a href="javascript:;" class="has-arrow">
+                       <div class="parent-icon"><i class='bx bx-user'></i>
+                       </div>
+                       <div class="menu-title">Users</div>
+                   </a>
+
+                   <ul>
+                       <li> <a href="{{ route('admin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>All Users</a>
+                       </li>
+                       <li> <a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New User</a>
+                       </li>
+
+                   </ul>
+               </li>    


            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
```

`resources/views/admin_dashboard/users/create.blade.php` を新規作成し編集

```html
@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">New User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New User</h5>
                    <hr/>

                    <form action="{{ route('admin.users.store') }}" method='post' enctype='multipart/form-data'>
                        @csrf

                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="input_name" class="form-label">Name</label>
                                            <input name='name' type='text' class="form-control" id="input_name" value='{{ old("name") }}'>

                                            @error('name')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_email" class="form-label">Email</label>
                                            <input name='email' type='email' class="form-control" id="input_email" value='{{ old("email") }}'>

                                            @error('email')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_password" class="form-label">Password</label>
                                            <input name='password' type='password' class="form-control" id="input_password">

                                            @error('password')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_image" class="form-label">Image</label>
                                            <input name='image' type='file' class="form-control" id="input_image">

                                            @error('image')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">User Role</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rounded">
                                                        <div class="mb-3">
                                                            <select required name='role_id' class="single-select">
                                                                @foreach($roles as $key => $role)
                                                                <option value="{{ $key }}">{{ $role }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('role_id')
                                                                <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class='btn btn-primary' type='submit'>Add User</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    @endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/users/edit.blade.php` を新規作成し編集

```html
@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User: {{ $user->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Add New User</h5>
                    <hr/>

                    <form action="{{ route('admin.users.update', $user) }}" method='post' enctype='multipart/form-data'>
                        @csrf
                        @method('PATCH')

                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="input_name" class="form-label">Name</label>
                                            <input name='name' type='text' class="form-control" id="input_name" value='{{ old("name", $user->name) }}'>

                                            @error('name')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_email" class="form-label">Email</label>
                                            <input name='email' type='email' class="form-control" id="input_email" value='{{ old("email", $user->email) }}'>

                                            @error('email')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="input_password" class="form-label">Password</label>
                                            <input name='password' type='password' class="form-control" id="input_password">

                                            @error('password')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-8'>
                                                <div class="mb-3">
                                                    <label for="input_image" class="form-label">Image</label>
                                                    <input name='image' type='file' class="form-control" id="input_image">

                                                    @error('image')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='user-image'>
                                                    <img src="{{ $user->image ? asset('storage/' . $user->image->path) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">User Role</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rounded">
                                                        <div class="mb-3">
                                                            <select required name='role_id' class="single-select">
                                                                @foreach($roles as $key => $role)
                                                                <option {{ $user->role_id === $key ? 'selected' : '' }} value="{{ $key }}">{{ $role }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('role_id')
                                                                <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class='btn btn-primary' type='submit'>Update User</button>

                                        <a 
                                        onclick='event.preventDefault(); document.getElementById("delete_user_{{ $user->id }}").submit()'
                                        href="#"
                                        class='btn btn-danger'>
                                            Delete User
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <form id='delete_user_{{ $user->id }}' action="{{ route('admin.users.destroy', $user) }}" method='POST'>@csrf @method('DELETE')</form>

                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    @endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/users/index.blade.php` を新規作成し編集

```html
@extends("admin_dashboard.layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Users</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Users</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->

				<div class="card">
					<div class="card-body">
						<div class="d-lg-flex align-items-center mb-4 gap-3">
							<div class="position-relative">
								<input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
							</div>
						  <div class="ms-auto"><a href="{{ route('admin.categories.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Category</a></div>
						</div>
						<div class="table-responsive">
							<table class="table mb-0">
								<thead class="table-light">
									<tr>
										<th>User#</th>
										<th>Image</th>
										<th>Name</th>
										<th>Email</th>
										<th>Role</th>
										<th>Related Posts</th>
										<th>Created at</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach($users as $user)
									<tr>
										<td>
											<div class="d-flex align-items-center">
												<div>
													<input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
												</div>
												<div class="ms-2">
													<h6 class="mb-0 font-14">#U-{{ $user->id }}</h6>
												</div>
											</div>
										</td>
										<td>
                                            <img width='50' src="{{ $user->image ? asset('storage/' . $user->image->path) : asset('storage/placeholders/user_placeholder.jpg') }}" alt="">    
                                        </td>
                                        <td>{{ $user->name }} </td>
                                        <td>{{ $user->email }} </td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>
                                            <a class='btn btn-primary btn-sm' href="{{ route('admin.users.show', $user) }}">Related Posts</a>
                                        </td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
											<div class="d-flex order-actions">
												<a href="{{ route('admin.users.edit', $user) }}" class=""><i class='bx bxs-edit'></i></a>
												<a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $user->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                                <form method='post' action="{{ route('admin.users.destroy', $user) }}" id='delete_form_{{ $user->id }}'>@csrf @method('DELETE')</form>
                                            </div>
										</td>
									</tr>
                                    @endforeach
								</tbody>
							</table>
						</div>

                        <div class='mt-4'>
                        {{ $users->links() }}
                        </div>

					</div>
				</div>


			</div>
		</div>
		<!--end page wrapper -->
		@endsection


    @section("script")

    <script>
        $(document).ready(function () {
        
            setTimeout(() => {
                $(".general-message").fadeOut();
            }, 5000);
        });
    </script>
    @endsection 
```

`resources/views/admin_dashboard/users/show.blade.php` を新規作成し編集

```html
@extends("admin_dashboard.layouts.app")

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ $user->name }} Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                    <div class="ms-auto"><a href="{{ route('admin.posts.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Post</a></div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Post#</th>
                                <th>Post Title</th>
                                <th>Post Excerpt</th>
                                <th>Category</th>
                                <th>Created at</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">#P-{{ $post->id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->title }} </td>

                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->created_at->diffForHumans() }}</td>


                                <td>
                                    <div class="badge rounded-pill @if($post->status === 'published') {{ 'text-info bg-light-info' }} @elseif($post->status === 'draft') {{ 'text-warning bg-light-warning' }} @else {{ 'text-danger bg-light-danger' }} @endif p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>{{ $post->status }}</div>
                                </td>

                                <td>{{ $post->views }}</td>

                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class=""><i class='bx bxs-edit'></i></a>
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $post->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                        <form method='post' action="{{ route('admin.posts.destroy', $post) }}" id='delete_form_{{ $post->id }}'>@csrf @method('DELETE')</form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection


@section("script")

<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection 
```

`routes/web.php` を編集

```diff
    // ...

    // Admin Dashboard Routes

+   Route::prefix('admin')->name('admin.')->middleware(['auth', 'check_permissions'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');

        Route::prefix('/posts')
            ->controller(AdminPostsController::class)
            ->name('posts.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('{post}', 'show')->name('show');
                Route::get('{post}/edit', 'edit')->name('edit');
                Route::put('{post}', 'update')->name('update');
                Route::delete('{post}', 'destroy')->name('destroy');
            });

        Route::prefix('/categories')
            ->controller(AdminCategoriesController::class)
            ->name('categories.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('{category}', 'show')->name('show');
                Route::get('{category}/edit', 'edit')->name('edit');
                Route::put('{category}', 'update')->name('update');
                Route::delete('{category}', 'destroy')->name('destroy');
            });

        Route::prefix('/tags')
            ->controller(AdminTagsController::class)
            ->name('tags.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('{category}', 'show')->name('show');
                Route::delete('{category}', 'destroy')->name('destroy');
            });

        Route::prefix('/comments')
            ->controller(AdminCommentsController::class)
            ->name('comments.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('{comments}/edit', 'edit')->name('edit');
                Route::put('{comments}', 'update')->name('update');
                Route::delete('{comments}', 'destroy')->name('destroy');
            });

        Route::prefix('/roles')
            ->controller(AdminCommentsController::class)
            ->name('roles.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('{role}/edit', 'edit')->name('edit');
                Route::put('{role}', 'update')->name('update');
                Route::delete('{role}', 'destroy')->name('destroy');
            });

+       Route::prefix('/users')
+           ->controller(AdminUsersController::class)
+           ->name('users.')
+           ->group(function () {
+               Route::get('', 'index')->name('index');
+               Route::get('create', 'create')->name('create');
+               Route::post('', 'store')->name('store');
+               Route::get('{user}', 'show')->name('show');
+               Route::get('{user}/edit', 'edit')->name('edit');
+               Route::put('{user}', 'update')->name('update');
+               Route::delete('{user}', 'destroy')->name('destroy');
+           });
    });

```

`app/Http/Controllers/AdminControllers/AdminUsersController.php` を修正

```diff
    // ...

    public function destroy(User $user)
    {
        if($user->id === auth()->id())
            return redirect()->back()->with('error', 'You can not delete your self.');

+       User::whereHas('role', function($query){
+           $query->where('name', 'admin');
+       })->first()->posts()->saveMany( $user->posts );

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User has been deleted.');
    }
```

## コンタクトページの管理者画面用コントローラーとビューの作成

### Finishing Admin Contacts Controller and Views 

コンタクトページ用の管理者画面用コントローラーを作成。以下のコマンドを入力

```
php artisan make:contorller AdminControllers/AdminContactsController
```

作成されたファイルを以下のように編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class AdminContactsController extends Controller
{
    public function index()
    {
        return view('admin_dashboard.contacts.index', [
            'contacts' => Contact::all()
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts')->with('success', 'Contact has been Deleted.');
    }
}
```

`resources/views/admin_dashboard/contacts/index.blade.php` を作成し以下のように編集

```html
@extends("admin_dashboard.layouts.app")

@section("style")
<link href="{{ asset('admin_dashboard_assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Contacts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Contacts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->first_name }}</td>
                                        <td>{{ $contact->last_name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->subject }}</td>
                                        <td>{{ $contact->message }}</td>
                                        <td>
                                            <div class="d-flex order-actions">
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete_form_{{ $contact->id }}').submit();" class="ms-3"><i class='bx bxs-trash'></i></a>

                                                <form method='post' action="{{ route('admin.contacts.destroy', $contact) }}" id='delete_form_{{ $contact->id }}'>@csrf @method('DELETE')</form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")

<script src="{{ asset('admin_dashboard_assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_dashboard_assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: ['excel']
        } );
        
        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
    // ...

            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user'></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li> <a href="{{ route('admin.users.index') }}"><i class="bx bx-right-arrow-alt"></i>All Users</a>
                    </li>
                    <li> <a href="{{ route('admin.users.create') }}"><i class="bx bx-right-arrow-alt"></i>Add New User</a>
                    </li>
                    
                </ul>
            </li>    

+           <li>
+               <a href="{{ route('admin.contacts') }}">
+               <div class="parent-icon"><i class='bx bx-mail-send'></i></div>
+                   <div class="menu-title">Contacts</div>
+               </a>
+           </li>

        </ul>
        <!--end navigation-->
    </div>
```

`routes/web.php` を編集

```diff
    // Admin Dashboard Routes
    Route::name('admin.')->prefix('admin')->middleware(['auth', 'check_permissions'])->group(function(){

        // ...

+       Route::get('contacts', [AdminContactsController::class, 'index'])->name('contacts');
+       Route::delete('contacts/{contact}', [AdminContactsController::class, 'destroy'])->name('contacts.destroy');
    });
```

## About ページを動的にアップデート

`app/Http/Controllers/AdminControllers/AdminPostsController.php` を更新

```diff
   private $rules = [
        'title' => 'required|max:200',
        'slug' => 'required|max:200',
-       'excerpt' => 'required|max:300',
+       'excerpt' => 'required|max:1000',
        'category_id' => 'required|numeric',
-       'thumbnail' => 'required|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227',
+       'thumbnail' => 'required|file|mimes:jpg,png,webp,svg,jpeg',
        'body' => 'required',
    ];

    public function index()
    {
        return view('admin_dashboard.posts.index', [
-           'posts' => Post::with('category')->get(),
+           'posts' => Post::with('category')->orderBy('id', 'DESC')->get(),
        ]);
    }
```

About ページを動的に更新するためのコントローラーを作成

```
php artisan make:controller AdminControllers/AdminSettingController
```

作成されたファイルを編集

```php
<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function edit()
    {
        return view('admin_dashboard.about.edit', [
            'setting' => Setting::find(1)
        ]);
    }

    public function update()
    {
        $validated = request()->validate([
            'about_first_text' => 'required|min:50,max:500',
            'about_second_text' => 'required|min:50,max:500',
            'about_our_vision' => 'required',
            'about_our_mission' => 'required',
            'about_services' => 'required',
            'about_first_image' => 'nullable|image',
            'about_second_image' => 'nullable|image', 
        ]);

        if(request()->has('about_first_image'))
        {
            $about_first_image = request()->file('about_first_image');
            $path = $about_first_image->store('setting', 'public');
            $validated['about_first_image'] = $path;
        }

        if(request()->has('about_second_image'))
        {
            $about_second_image = request()->file('about_second_image');
            $path = $about_second_image->store('setting', 'public');
            $validated['about_second_image'] = $path;
        }

        Setting::find(1)->update($validated);
        return redirect()->route('admin.setting.edit')->with('success', 'Setting has been Updated.');
    }
}
```

`app/Http/Controllers/HomeController.php` を編集

```diff
    // ...
    
    class HomeController extends Controller
    {
        public function index()
        {
-           $posts = Post::withCount('comments')->paginate(10);
+           $posts = Post::latest()->withCount('comments')->paginate(10);

            $recent_posts = Post::latest()->take(5)->get();

            // ...
        }
    }
```

`Setting` モデルとマイグレーションファイル及びファクトリークラスを作成

```
php artisan make:model Setting -mf
```

作成した `app/Models/Setting.php` モデルを編集

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_first_text',
        'about_second_text',
        'about_first_image',
        'about_second_image',
        'about_our_vision',
        'about_our_mission',
        'about_services',
    ];
}
```

作成された `database/factories/SettingFactory.php` を編集

```php
<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'about_first_text' => $this->faker->paragraph(),
            'about_second_text' => $this->faker->paragraph(),
            'about_first_image' => 'setting/about-img-1.jpg',
            'about_second_image' => 'setting/about-img-2.jpg',
            'about_our_vision' => $this->faker->paragraph(),
            'about_our_mission' => $this->faker->paragraph(),
            'about_services' => $this->faker->paragraph(),
        ];
    }
}
```

`app/Providers/AppServiceProvider.php` を編集

```diff
    //

    class AppServiceProvider extends ServiceProvider
    {
        public function boot()
        {
            Paginator::useBootstrap();

            $categories = Category::withCount('posts')->orderBy('posts_count', 'DESC')->take(10)->get();
            View::share('navbar_categories', $categories);

-           $setting = Setting::find(1);
+            View::share('setting', $setting);
        }
    }
```

作成された `database/migrations/2021_11_23_192010_create_settings_table.php` を編集

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('about_first_text');
            $table->text('about_second_text');
            $table->string('about_first_image');
            $table->string('about_second_image');
            $table->text('about_our_vision');
            $table->text('about_our_mission');
            $table->text('about_services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
```

`database/seeders/DatabaseSeeder.php` を編集

```diff
    // ...

    class DatabaseSeeder extends Seeder
    {
        public function run()
        {
            // ...

+           \App\Models\Setting::factory(1)->create();
        }
    }
```

`resources/views/about.blade.php` を編集

```diff
    @extends('main_layouts.master')

    @section('title', 'MyBlog | About')
    
    @section('content')
            <div id="colorlib-counter" class="colorlib-counters">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="about-desc">
-                               <div class="about-img-1 animate-box" style="background-image: url(blog_template/images/about-img-2.jpg);"></div>
-                               <div class="about-img-2 animate-box" style="background-image: url(blog_template/images/about-img-1.jpg);"></div>
+                              <div class="about-img-1 animate-box" style="background-image: url({{ asset('storage/' . $setting->about_first_image) }})"></div>
+                              <div class="about-img-2 animate-box" style="background-image: url({{ asset('storage/' . $setting->about_second_image) }})"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-12 colorlib-heading animate-box">
                                    <h1 class="heading-big">Who are we</h1>
                                    <h2>Who are we</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 animate-box">
-                                   <p><strong>Even the all-powerful Pointing has no control about the blind texts</strong></p>
-                                   <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
+                                   <p>{{ $setting->about_first_text }}</p>
                                </div>
                                <div class="col-md-6 col-xs-6 animate-box">
                                    <div class="counter-entry">

                    // ...
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Knowledge online learning center</h3>
-                          <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
+                           <p>{{ $setting->about_second_text }}</p>
                        </div>
                        <div class="col-md-6">
                            <div class="fancy-collapse-panel">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Our Mission
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">
                                        <div class="row">
-                                           <div class="col-md-6">
-                                                   <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
-                                               </div>
-                                               <div class="col-md-6">
-                                                   <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
-                                               </div>
-                                           </div>
+                                          {!! $setting->about_our_mission !!}
+                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Our Vision
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
-                                       <p>Far far away, behind the word <strong>mountains</strong>, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
-                                       <ul>
-                                           <li>Separated they live in Bookmarksgrove right</li>
-                                           <li>Separated they live in Bookmarksgrove right</li>
-                                       </ul>
+                                   {!! $setting->about_our_vision !!}
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Services
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
-                                   <div class="panel-body">
-                                       <p>Far far away, behind the word <strong>mountains</strong>, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>	
-                                   </div>
+                                   {!! $setting->about_services !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
    @endsection
```

`resources/views/admin_dashboard/about/edit.blade.php` を新規作成し編集

```php
@extends("admin_dashboard.layouts.app")

@section("style")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js" integrity="sha512-XNYSOn0laKYg55QGFv1r3sIlQWCAyNKjCa+XXF5uliZH+8ohn327Ewr2bpEnssV9Zw3pB3pmVvPQNrnCTRZtCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection


    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">About</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">About Page</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Edit About Page</h5>
                    <hr/>

                    <form action="{{ route('admin.setting.update') }}" method='post' enctype='multipart/form-data'>
                        @csrf

                        <div class="form-body mt-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="border border-3 p-4 rounded">

                                        <div class="mb-3">
                                            <label for="about_first_text" class="form-label">Top Text</label>
                                            <textarea name='about_first_text' class="form-control" id="about_first_text">{{ $setting->about_first_text }}</textarea>

                                            @error('about_first_text')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="about_second_text" class="form-label">Bottom Text</label>
                                            <textarea name='about_second_text' class="form-control" id="about_second_text">{{ $setting->about_second_text }}</textarea>

                                            @error('about_second_text')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-8'>
                                                <div class="mb-3">
                                                    <label for="about_first_image" class="form-label">First Image</label>
                                                    <input name='about_first_image' type='file' class="form-control" id="about_first_image">

                                                    @error('about_first_image')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='user-image p-2'>
                                                    <img class='img-fluid img-thumbnail' src='{{ asset('storage/' . $setting->about_first_image) }}' >
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='col-md-8'>
                                                <div class="mb-3">
                                                    <label for="about_second_image" class="form-label">Second Image</label>
                                                    <input name='about_second_image' type='file' class="form-control" id="about_second_image">

                                                    @error('about_second_image')
                                                        <p class='text-danger'>{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class='col-md-4'>
                                                <div class='user-image p-2'>
                                                    <img class='img-fluid img-thumbnail' src='{{ asset('storage/' . $setting->about_second_image) }}' >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="about_our_mission" class="form-label">About Our Mission</label>
                                            <textarea name='about_our_mission'  id='about_our_mission' class="form-control" id="our_mission" rows="3">{{ old("about_our_mission", $setting->about_our_mission) }}</textarea>

                                            @error('about_our_mission')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="about_our_vision" class="form-label">About Our Vision</label>
                                            <textarea name='about_our_vision'  id='about_our_vision' class="form-control" rows="3">{{ old("about_our_vision", $setting->about_our_vision) }}</textarea>

                                            @error('about_our_vision')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>


                                        <div class="mb-3">
                                            <label for="about_services" class="form-label">About Services</label>
                                            <textarea name='about_services'  id='about_services' class="form-control" rows="3">{{ old("about_services", $setting->about_services) }}</textarea>

                                            @error('about_services')
                                                <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>


                                        <button class='btn btn-primary' type='submit'>Update</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>
    <!--end page wrapper -->
    @endsection

@section("script")
<script>
    $(document).ready(function () {
    
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
        let initTinyMCE = (id) => {
            tinymce.init({
                selector: '#'+id,
                plugins: 'advlist autolink lists link charmap print preview hr anchor pagebreak',
                toolbar_mode: 'floating',
                height: '300',
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | rtl ltr',
                toolbar_mode: 'floating',
            });
        }
        initTinyMCE('about_our_mission');
        initTinyMCE('about_our_vision');
        initTinyMCE('about_services');
    });
</script>
@endsection 
```

`resources/views/admin_dashboard/layouts/nav.blade.php` を編集

```diff
                    // ...

                    </a>
                </li>

+               <li>
+                   <a href="{{ route('admin.setting.edit') }}">
+                   <div class="parent-icon"><i class='bx bx-info-square'></i></div>
+                       <div class="menu-title">Setting</div>
+                   </a>
+               </li>
+
+               <hr>
+
+               <li>
+                   <a target='_blank' href="{{ route('home') }}">
+                   <div class="parent-icon"><i class='bx bx-pointer'></i></div>
+                       <div class="menu-title">Visit Site</div>
+                   </a>
+               </li>

            </ul>
            <!--end navigation-->
```

`resources/views/components/blog/side-recent-posts.blade.php` を編集

```diff
                // ...
                {{ \Str::limit( $recent_post->title, 20) }}
                </a>
            </h2>
-           <p>{{ $recent_post->excerpt }}</p>
+           <p>{{ \Str::limit($recent_post->excerpt, 50) }}</p>
        </div>
    </div>
    @endforeach
```

`routes/web.php`

```diff
    // ...

    // Admin Dashboard Routes
    Route::name('admin.')->prefix('admin')->middleware(['auth', 'check_permissions'])->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::post('upload_tinymce_image', [TinyMCEController::class, 'upload_tinymce_image'])->name('upload_tinymce_image');
        Route::resource('posts', AdminPostsController::class);
        Route::resource('categories', AdminCategoriesController::class);
        Route::resource('tags', AdminTagsController::class)->only(['index', 'show', 'destroy']);
        Route::resource('comments', AdminCommentsController::class)->except('show');
        Route::resource('roles', AdminRolesController::class)->except('show');
        Route::resource('users', AdminUsersController::class);

        Route::get('contacts', [AdminContactsController::class, 'index'])->name('contacts');
        Route::delete('contacts/{contact}', [AdminContactsController::class, 'destroy'])->name('contacts.destroy');

+       Route::get('about', [AdminSettingController::class, 'edit'])->name('setting.edit');
+       Route::post('about', [AdminSettingController::class, 'update'])->name('setting.update');
    });
```

## サービスプロバイダーの修正

`app/Providers/AppServiceProvider.php` を編集

```diff
    // ...

    class AppServiceProvider extends ServiceProvider
    {
        public function register()
        {
            //
        }

        public function boot()
        {
            Paginator::useBootstrap();
+           if( Schema::hasTable('categories') ) {
+               $categories = Category::withCount('posts')->orderBy('posts_count', 'DESC')->take(10)->get();
+               View::share('navbar_categories', $categories);

-           $categories = Category::withCount('posts')->orderBy('posts_count', 'DESC')->take(10)->get();
-           View::share('navbar_categories', $categories);
-           $setting = Setting::find(1);
-           View::share('setting', $setting);
+               $setting = Setting::find(1);
+               View::share('setting', $setting);
+           }
        }
    }
```

## ニュースレターの作成

`app/Http/Controllers/AdminControllers/AdminPostsController.php` を編集

```diff
    // ...

    public function update(Request $request, Post $post)
    {
        $this->rules['thumbnail'] = 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=800,max_height=300';
        $validated = $request->validate($this->rules);

+       $validated['approved'] = $request->input('approved') !== null;

        $post->update($validated);

        if($request->has('thumbnail'))

        // ...

    }
```

`app/Http/Controllers/HomeController.php` を編集

```diff
    public function index()
    {
-       $posts = Post::latest()->withCount('comments')->paginate(10);
+       $posts = Post::latest()
+       ->approved()
+       // ->where('approved', 1)
+       ->withCount('comments')->paginate(10);

        $recent_posts = Post::latest()->take(5)->get();

        // ...
    }
```

ニュースレター用のコントローラーを作成。以下のコマンドを入力

```
php artisan make:controller NewsletterController
```

作成されたファイルを編集

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRequests\NewsletterRequest;
use App\Models\Newsletter;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request)
    {
        return Newsletter::store( $request );
    }
}
```

フォームリクエストの作成。以下のコマンドを入力

```
php artisan make:request NewsLetterRequests/NewsLetterRequest
```

作成された `app\Http\Requests\NewsLetterRequests\NewsLetterRequest.php` を編集

```php
<?php

namespace App\Http\Requests\NewsletterRequests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>'required|email',
        ];
    }
}
```

Newsletter モデルの作成。以下のコマンドを入力

```
php artisan make:model Newsletter -m
```

作成された `app/Models/Newsletter.php` ファイルを編集

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;
    protected $table = "newsletter";
    protected $fillable = ['email'];

    public static function store($request)
    {
        self::create( $request->all() );

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config('services.mailchimp.apikey'),
            'server' => config('services.mailchimp.prefix') 
        ]);

        $list_id='298ae56b23';

        try {
            $response = $mailchimp->lists->addListMember($list_id, [
                "email_address" => $request->input('email'),
                "status" => "subscribed"
            ]);
            return response()->json([
                'message' => 'Thank you for your subscription'
            ], 200);
        } catch (\MailchimpMarketing\ApiException $e) {
            return response()->json([
                'message' => 'Invalid Email Address'
            ], 500);
        }
    }
}
```

マイグレーションファイル `database/migrations/create_newsletter_migration.php` も編集

```diff
    // ...

    return new class extends Migration
    {
        /**
        * Run the migrations.
        *
        * @return void
        */
        public function up()
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
+               $table->string('email');
                $table->timestamps();
            });
        }

        // ...
    }
```

`database/migrations/create_posts_table.php` を編集

```diff
    // ...

    class CreatePostsTable extends Migration
    {
        public function up()
        {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('excerpt');
                $table->text('body');
                $table->foreignId('user_id');
                $table->foreignId('category_id');

                $table->integer('views')->default(0);
-               $table->string('status')->default('published');
+               $table->boolean('approved')->default(true);

                $table->timestamps();
            });
        }

        // ...
    }
```

`public/css/mystyle.css` を編集

```diff
    // ...

+   .subscribe-error
+   {
+       background: #931d1d;
+       border-color: #931d1d;
+   }
+
+   .subscribe-success
+   {
+       background: #15c8ce;
+       border-color: #15c8ce;
+   }
```

`resources/views/admin_dashboard/posts/edit.blade.php` を編集

```diff

+           <div class="mb-3">
+               <div class="form-check form-switch">
+                   <input name='approved' {{ $post->approved ? 'checked' : '' }} class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
+                   <label class="form-check-label {{ $post->approved ? 'text-success' : 'text-warning' }}" for="flexSwitchCheckChecked">
+                       {{ $post->approved ? 'Approved' : 'Not approved' }}
+                   </label>
+               </div>
+           </div>

            <button class='btn btn-primary' type='submit'>Update Post</button>
            <a 
            class='btn btn-danger'
            onclick="event.preventDefault();document.getElementById('delete_post_{{ $post->id }}').submit()"
            href="#">Delete Post</a>
            
            
        </div>
    </div>
```

`resources/views/main_layouts/master.blade.php` を編集

```diff
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
+   <meta name="_token" content="{{ csrf_token() }}" />

  <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>

        // ...

        @yield('content')


-       <div id="colorlib-subscribe" class="subs-img" style="background-image: url({{ asset('blog_template/images/img_bg_2.jpg') }});" data-stellar-background-ratio="0.5">
+       <div id="colorlib-subscribe" class="subs-img" style="background-image: url({{ asset('blog_template/images/img_bg_2.jpg') }});" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">

                    // ...

                            <form class="form-inline qbstp-header-subscribe">
                                <div class="col-three-forth">
                                    <div class="form-group">
-                                       <input type="text" class="form-control" id="email" placeholder="Enter your email">
+                                       <input name='subscribe-email' type="email" required class="form-control" id="email" placeholder="Enter your email">
                                    </div>
                                </div>
                                <div class="col-one-third">
                                    <div class="form-group">
-                                       <button type="submit" class="btn btn-primary">Subscribe Now</button>
+                                       <button id='subscribe-btn' type="submit" class="btn btn-primary">Subscribe Now</button>
                                    </div>
                                </div>
                            </form>

    // ...

-   <script src="{{ asset('blog_template/js/main.js') }}"></script>

+   <script src="{{ asset('js/functions.js') }}"></script>

+   <script>
+       $(function(){
+           function isEmail(email) {
+               var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
+               return regex.test(email);
+           }
+           $(document).on("click", "#subscribe-btn", (e) => {
+               e.preventDefault();
+               let _this = $(e.target);
+               
+               let email = _this.parents("form").find("input[name='subscribe-email']").val();
+               if( ! isEmail( email ) )
+               {
+                   $("body").append("<div class='global-message alert alert-danger subscribe-error'>This email is not valid.</div>");
+               }
+               else 
+               {
+                   // send this email to subscribe 
+                   // 1- send an ajax and store this email
+                   let formData = new FormData();
+                   let _token = $("meta[name='_token']").attr("content");
+                   formData.append('_token', _token);
+                   formData.append('email', email);
+                   $.ajax({
+                       url: "{{ route('newsletter_store') }}",
+                       type: "POST",
+                       dataType: "JSON",
+                       processData: false,
+                       contentType: false,
+                       data:formData,
+                       success: (respond) => {
+                           let message = respond.message;
+                           $("body").append("<div class='global-message alert alert-danger subscribe-success'>"+ message +"</div>");
+                           _this.parents("form").find("input[name='subscribe-email']").val('');
+                       },
+                       statusCode: {
+                           500: () => {
+                               $("body").append("<div class='global-message alert alert-danger subscribe-error'>Invalid Email Address</div>");
+                           }
+                       }
+                   });
+               }
+               setTimeout( () => {
+                   $(".global-message.subscribe-error, .global-message.subscribe-success").remove();
+               }, 5000 );
+           });
+       });
+   </script>
    @yield('custom_js')

    </body>
```

`routes/web.php` を編集

```diff
    Route::get('/tags/{tag:name}', [TagController::class, 'show'])->name('tags.show');

+  Route::post('newsletter', [NewsletterController::class, 'store'])->name('newsletter_store');

    require __DIR__.'/auth.php';
```