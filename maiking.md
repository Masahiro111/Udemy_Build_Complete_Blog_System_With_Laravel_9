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