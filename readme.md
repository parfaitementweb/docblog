# DocBlog

Documentation & Blogging Package for Laravel

## Installation

Via Composer

``` bash
$ composer require parfaitementweb/docblog
```

Publish Assets & Configuration files

```
php artisan vendor:publish --provider="Parfaitementweb\DocBlog\DocBlogServiceProvider"
```

Add this to .env
```
RESPONSE_CACHE_ENABLED=true
SCOUT_DRIVER=tntsearch
```

Add to your package.json

    "bootstrap": "^4.1.3",
    "jquery": "^3.3",
    "popper.js": "^1.14.4",

Add to your webpack.mix.js

```
.js('resources/assets/vendor/docblog/js/blog.js', 'public/js')
.sass('resources/assets/vendor/docblog/sass/blog.scss', 'public/css')
.sass('resources/assets/vendor/docblog/sass/docs.scss', 'public/css')
```

Install dependencies

```
cd ./vendor/parfaitementweb/docblog
npm install
```

Migrate Database

```
php artisan migrate
```

Seeds the database (optional)
```
php artisan db:seed --class=\\Parfaitementweb\\DocBlog\\Database\\Seeds\\DatabaseSeeder
```

## Configuration

Edit `docblog.php`

## Security

If you discover any security related issues, please email us instead of using the issue tracker.

## Credits

- [Alexis][link-author]

[ico-version]: https://img.shields.io/packagist/v/parfaitementweb/docblog.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/parfaitementweb/docblog.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/parfaitementweb/docblog/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/parfaitementweb/docblog
[link-downloads]: https://packagist.org/packages/parfaitementweb/docblog
[link-travis]: https://travis-ci.org/parfaitementweb/docblog
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/parfaitementweb
[link-contributors]: ../../contributors]