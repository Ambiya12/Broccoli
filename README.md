# PHP Skeleton MVC

A minimalist MVC skeleton to quickly start your PHP projects. Clone this repo, install dependencies, and start coding.

## Why this project?

Because starting from scratch every time is tedious. This skeleton gives you a clean foundation with:

-   A simple and clear MVC architecture
-   A functional router (GET/POST)
-   PSR-4 autoloading configured
-   A consistent folder structure

Perfect for testing an idea quickly, learning the MVC pattern, or prototyping without wasting time on configuration.

## Installation

```bash
git clone https://github.com/julesbourin/php-skeleton-mvc.git
cd php-skeleton-mvc
composer install
```

## Quick Start

From the `public/` folder:

```bash
php -S localhost:8000
```

Open your browser at `http://localhost:8000` and you're good to go.

## Structure

```
├── public/
│   └── index.php          # Entry point
├── app/
│   ├── Controller/        # Your controllers
│   ├── Model/             # Your models
│   ├── views/             # Your views
│   ├── core/
│   │   └── Router/        # The router
│   └── database/          # JSON files or DB config
└── vendor/                # Composer dependencies
```

## How it works

### Adding a route

In `public/index.php`:

```php
$router->get('/about', [AboutController::class, 'index']);
$router->post('/contact', [ContactController::class, 'submit']);
```

### Creating a controller

In `app/Controller/`:

```php
namespace App\Controller;

class AboutController {
    public function index() {
        require_once __DIR__ . '/../views/about.php';
    }
}
```

### Creating a model

In `app/Model/`:

```php
namespace App\Model;

class Article {
    public function all(): array {
        // Your logic here
        return [];
    }
}
```

### Creating a view

In `app/views/`, simple PHP file with HTML:

```php
<!DOCTYPE html>
<html>
<head>
    <title>My page</title>
</head>
<body>
    <h1><?= $title ?></h1>
</body>
</html>
```

## Testing

PHPUnit is installed as a dev dependency:

```bash
vendor/bin/phpunit
```

## Notes

-   The router is basic but extensible
-   No heavy framework, just PHP
-   No ORM by default (add Doctrine or Eloquent if you want)
-   Views use native PHP (no Twig/Blade)

## License

Do whatever you want with it 🤷‍♂️
