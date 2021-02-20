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
Publish resources, and migrate

```bash
php artisan vendor:publish
```


PS : You can edit `2020_05_27_221346_add_role_id_to_users` migration to link it with the correct user table

Edit the `config/maravels.php` with the correct values

```php
<?php

return [
    // Define the list of actions to be checked against
    'actions' => [
        'add', 'delete', 'create', 'search', 'update'
    ],

    // define the class path for the entities
    'entities' => [
        \App\Models\User::class,
    ],
];

```
And then migrate

```bash
php artisan migrate
```
You will have a `MarvelCan` Middleware, you can tweak it to adapt to your needs and use it such as

```php
// Check if he owns one of those two abilities or both
Route::middleware(['auth:api', 'roleCan:create_post,edit_post'])
      ->post('/posts', 'PostsController@store');
```
## Setup a Model

To setup the user model, all you have to do is add (and import) the `IsMarvel` trait.

```php
use Inani\Maravel\HasRole;

class User extends Model
{
    use HasRole;
    ...
}
```

## Usage

## All roles are role and permissions are powers
Because every user deserves to be a hero, The Maravel API is based on the Marvel Jargon, and here are how it can be used 

```php
// Having a user
$user = User::first();

// Create a new role, description is not mandotary
$userManager = RoleBuilder::create('User Manager', 'The role to manage users')
                ->havingPower([
                   'name' => 'can_update',
                   'description' => 'The abilitiy to update a user',
                   'action' => 'update',
                   'entity' => \App\Models\User::class,
               ]);

// we can grant a power to it
$userManager = RoleBuilder::of($userManager)
                        ->grant([
                             'name' => 'can_create',
                             'description' => 'The abilitiy to create a user',
                             'action' => 'create',
                             'entity' => \App\Models\User::class,
                         ]);

// Or take it off
$ability = Ability::first();

$storm = RoleBuilder::of($userManager)->takeOff($ability);


// bless the user with the abilities of the role
$user->roleManager()->blessWith($storm);


// check if it has the ability
$user->roleManager()->owns($ability);

// check if it has one of the provided abilities
$user->roleManager()->ownsOneOf([$ability, $anOtherAbility]);

// make it human again (remove its role)
$user->roleManager()->humanize();

```

You can also manage the instances directly
```php

// Create Ability
$ability = Ability::create([
    'name' => 'post_write',
    'description' => 'Abitlity to create new Posts',
    'action' => 'add',
    'entity' => \App\Models\Post::class,
]);

// Create a Marvel
$writer = Role::create([
    'name' => 'Webmaster',
    'description' => 'A Role that allows you create new posts'
]);

// Grant the ability
$writer->grant($ability);

// remove a certain ability
$writer->takeOff($ability);

// remove all and keep only those
$abilities = [1, 2]; // or the models
$writer->keep($abilities);

// bless it to our user
$user = \App\Models\User::first();

$user->roleManager()->blessWith($writer);
```

## Am I missing something?
Submit a PR or issue with details!
