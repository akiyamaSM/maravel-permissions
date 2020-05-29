# Grant Users the superpower of Marvel characters
![inani-user2](https://user-images.githubusercontent.com/12276076/83249747-f7a65800-a19e-11ea-950f-fdaba4981829.png)


## Download

```bash
composer require inani/maravel-permissions
```

## Installation

Then include the service provider inside `config/app.php`. (You can skipp it if it's in Laravel 5.5 or higher)

```php
'providers' => [
    ...
    Inani\Maravel\Providers\MaravelServiceProvider::class,
    ...
];
```
Publish migrations, and migrate

```bash
php artisan vendor:publish
```

You can edit `2020_05_27_221346_add_marvel_id_to_users` migration to link it with the correct user table

And then migrate

```bash
php artisan migrate
```
## Setup a Model

To setup the user model, all you have to do is add (and import) the `IsMarvel` trait.

```php
use Inani\Maravel\IsMarvel;

class User extends Model
{
    use IsMarvel;
    ...
}
```

## Usage

## All roles are marvel and permissions are powers
Because every user deserves to be a hero, The Maravel API is based on the Marvel Jargon, and here are how it can be used 

```php
// Having a user
$user = User::first();

// Create a new marvel
$storm = Spectre::create('storm')->havingPower([
	'weather_manipulation',
  	'earth_telepathy',
  	'high_sens',
  	'see_the_future'
]);

// we can grant a power to it
$storm = Spectre::of($storm)->grant('flying');

// Or take it off
$storm = Spectre::of($storm)->takeOff('see_the_future');


// bless the user with the abilities of the marvel
$user->cerebro()->blessWith($storm);


// check if it has the ability
$user->cerebro()->owns('weather_manipulation');

// check if it has one of the provided abilities
$user->cerebro()->ownsOneOf([
	'earth_telepathy',
  	'flying',
  	'x-ray',
]);

// make it human again (remove its role)
$user->cerebro()->humanize();

```

You can also manage the instances directly
```php

// Create Ability
$ability = Ability::create([
    'super_power' => 'speed'
]);

// Create a Marvel
$marvel = Marvel::create([
    'name' => 'Cristiano Ronaldo'
]);

// Grant the ability
$marvel->grant($ability);

// remove a certain ability
$marvel->takeOff($ability);

// remove all and keep only those
$marvel->keep($abilities);

// bless it to our user

$user->cerebro()->blessWith($marvel);
```

## Am I missing something?
Submit a PR or issue with details!
