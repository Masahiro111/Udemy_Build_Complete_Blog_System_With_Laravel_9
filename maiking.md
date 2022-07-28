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

Laravel での認証機能パッケージ Laravel　Breeze のインストールを行います。以下のコマンドでインストールします。

```
composer require laravel /breeze
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