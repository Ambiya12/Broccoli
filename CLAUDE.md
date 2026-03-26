# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A minimal PHP MVC skeleton with PSR-4 autoloading and lightweight routing. This is a starting point for PHP applications with a clean, extensible folder structure.

## Development Commands

### Starting the Application
```bash
cd public
php -S localhost:8000
```

The application will be accessible at `http://localhost:8000`.

### Running Tests
```bash
vendor/bin/phpunit
```

PHPUnit 11.x is configured as a dev dependency.

### Installing Dependencies
```bash
composer install
```

After adding autoload configuration, regenerate autoloader:
```bash
composer dump-autoload
```

## Architecture

### Request Flow
1. All requests hit `public/index.php` (front controller)
2. `public/index.php` requires the Composer autoloader from `vendor/autoload.php`
3. Router class is loaded via `require_once` from `app/core/Router/router.php`
4. Routes are registered using `$router->get()` or `$router->post()` methods
5. `$router->run()` is called to match the current request method and URI
6. If matched, the router auto-instantiates the controller class and calls the specified method
7. Controller methods fetch data from models and load views

### Directory Structure

```
├── public/
│   └── index.php       # Entry point (front controller)
├── app/
│   ├── Controller/     # Controller classes (namespace: App\Controller)
│   ├── Model/          # Model classes (namespace: App\Model)
│   ├── views/          # View templates (plain PHP files, lowercase)
│   ├── core/
│   │   └── Router/     # Router implementation (no namespace)
│   ├── database/       # JSON files or database config
│   └── tests/          # Test files (empty by default)
└── vendor/             # Composer dependencies
```

### Router Implementation
- Located at `app/core/Router/router.php`
- NOT namespaced (loaded via `require_once` in public/index.php)
- Supports GET and POST routes via `get()` and `post()` methods
- Route handlers can be either:
  - Callable functions/closures
  - Array format: `[ControllerClass::class, 'methodName']`
- Auto-instantiates controllers when using array format
- Returns 404 response for unmatched routes
- Special handling: Ignores URIs starting with `/coverage/` (for PHPUnit coverage reports)

### Controllers
- Located in `app/Controller/`
- Namespace: `App\Controller` (singular, not plural)
- Responsible for handling requests and coordinating models/views
- Load views using `require_once` with relative paths: `require_once __DIR__ . '/../views/viewname.php'`
- Pass data to views by defining variables before requiring the view file

### Models
- Located in `app/Model/`
- Namespace: `App\Model` (singular, not plural)
- No database abstraction layer by default (pure PHP)
- Example `User` model reads from `app/database/db.json`
- Use `__DIR__` for file paths to ensure they work regardless of execution context

### Views
- Located in `app/views/` (lowercase directory name)
- Plain PHP files with HTML
- Access variables passed from controllers
- Use short echo syntax: `<?= htmlspecialchars($variable) ?>` for security

### Database
- Located in `app/database/`
- Default setup uses JSON files (e.g., `db.json`)
- Structure: `{"user": [{"id": 1, "name": "Alice"}]}`

## Important Notes

### Path Resolution Best Practices
Always use `__DIR__` for file paths, not relative paths:
- ✅ Good: `__DIR__ . '/../database/db.json'`
- ❌ Bad: `'../database/db.json'`

This ensures paths work correctly regardless of where the script is executed from.

### Namespace Convention
Controllers and Models use singular namespaces:
- `App\Controller` (not `App\Controllers`)
- `App\Model` (not `App\Models`)

### View Directory Naming
The views directory is lowercase `views/`, not capitalized `View/`.

### Router Not Namespaced
The `Router` class at `app/core/Router/router.php` is not namespaced and is loaded via `require_once` in `public/index.php`. This is intentional to keep the router simple and independent.

### Entry Point Location
The entry point is `public/index.php`, not at the root. This follows best practices by keeping the publicly accessible files in a separate directory.

### Route Registration Order
Routes must be registered BEFORE calling `$router->run()`. The order in `public/index.php` matters:
1. Require autoloader
2. Require router
3. Import controller classes with `use`
4. Instantiate router
5. Register all routes
6. Call `$router->run()`