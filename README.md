# nia - Bridge Component For Presenter And Routing

This component is a bridge to use a `Nia\Presenter\PresenterInterface` as a handler for the routing compoonent. It provides a handler implementation which requires a presenter implementation and a presenter action.

## Installation

Require this package with Composer.

```bash
	composer require nia/bridge-routing-presenter
```

## Tests
To run the unit test use the following command:

    $ cd /path/to/nia/component/
    $ phpunit --bootstrap=vendor/autoload.php tests/


## How To Use
To create a routing handler from a presenter you just have to pass a instance of your presenter and the handled action name.
```php
	// Create a handler from a presenter.
	$handler = new PresenterHandler(new HomePagePresenter(), 'index');

```

In this part you see a common usage of the `Nia\Routing\Handler\PresenterHandler` class.
```php
	// register start page
	// [...]
	$router->addRoute(new Route($condition, $filter, new PresenterHandler(new HomePagePresenter(), 'index')));

	// register error pages
	// [...]
	$router->addRoute(new Route($condition, $filter, new PresenterHandler(new ErrorPresenter(), 'notFound')));
	$router->addRoute(new Route($condition, $filter, new PresenterHandler(new ErrorPresenter(), 'forbidden')));
```
