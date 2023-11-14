# MVC en PHP

Voici un mini framework en MVC (avec la POO PHP). On a utilisé Composer pour installer des librairies. La première commande à faire si vous utilisez ce framework c'est :

```
composer install
```

## Lancer un serveur de dev

Pour pouvoir travailler avec le framework, on doit lancer un serveur PHP :

```
php -S 127.0.0.1:8000 -t public
```

On pourra maintenant aller sur `http://localhost:8000`.

## Les contrôleurs

Les contrôleurs sont rangés dans `src/Controller`. Un contrôleur sert à ranger son code PHP (uniquement le PHP). Une page = Une méthode dans un contrôleur.

Le contrôleur va souvent renvoyer une vue (uniquement le HTML).

Pour aller sur le site, on va bien sur le fichier `public/index.php`.

### Créer un contrôleur

Par exemple, on peut créer un controller `src/Controller/MovieController.php` :

```php
namespace M2i\Mvc\Controller;

use M2i\Mvc\Model\Movie;
use M2i\Mvc\View;

class MovieController
{
    public function index()
    {
        $title = 'Films';
        $movies = Movie::all();

        return View::render('movies/list', [
            'title' => $title,
            'movies' => $movies,
        ]);
    }
}
```

Dans cet exemple, on a un modèle Movie et une vue `views/movies/list.html.php`.

### Créer une vue

Les vues doivent être dans le dossier `views` et doivent se finir par `.html.php`. La vue contient du HTML basique, voici un exemple :

```html
<?php require 'partials/header.html.php'; ?>

<h1>Mon site</h1>

<?php require 'partials/footer.html.php'; ?>
```

La classe `View` va surtout servir à renvoyer une vue :

```php
// On affiche une vue home.html.php avec certaines variables
return View::render('home', [
    'name' => 'Fiorella',
    'cars' => ['F1', 'Alpine', 'Porsche'],
]);

// On peut faire une redirection (NE FONCTIONNE PAS A FAIRE PENDANT LE TP)
return View::redirect('/films');

// On peut renvoyer une 404 (NE FONCTIONNE PAS A FAIRE PENDANT LE TP)
return View::notFound();
```

### Créer un modèle

Les modèles sont rangés dans `src/Model`. Un modèle sert à structurer les données contenues dans la base de données. Il contient du SQL et du PHP.

Voici un exemple :

```php
namespace M2i\Mvc\Model;

class Movie extends Model
{
    public $id;
    public $title;
    public $duration;
    public $image;
}
```

Un modèle doit étendre de `Model` et doit avoir ses propriétés telles qu'elles sont dans la base de données (les colonnes). La table est nommée par rapport au modèle (`movies` ici).

Voilà tout ce qu'on peut faire avec le modèle dans un contrôleur :

```php
$film = new Movie();

// On remplit l'objet avec les données à mettre en base
$film->title = 'Scarface';
$film->duration = 120;
$film->image = 'scarface.jpg';

// On exécute la requête SQL en précisant toutes les colonnes
$film->save(['title', 'duration', 'image']);

// On peut avoir tous les films
$films = Movie::all();

// On peut avoir un film
$film = Movie::find(1);

// On peut modifier un film (NE FONCTIONNE PAS A FAIRE PENDANT LE TP)
$film->update(['title']);

// On peut supprimer un film (NE FONCTIONNE PAS A FAIRE PENDANT LE TP)
Movie::delete(1);
```

### Créer une route

Pour créer une route après avoir fait un contrôleur, ça se passe dans le fichier `index.php` :

```php
$app->addRoutes([
    ['GET', '/', 'HomeController@index'],
    ['GET', '/utilisateurs', 'UserController@list'],
    ['GET', '/utilisateurs/[i:id]', 'UserController@show'],
    ['GET|POST', '/utilisateurs/creer', 'UserController@create'],
    ['GET|POST', '/utilisateurs/modifier/[i:id]', 'UserController@edit'],
    ['GET', '/utilisateurs/supprimer/[i:id]', 'UserController@destroy'],
]);
```

Soyez très attentifs à ce que vous avez écrit, tout doit bien correspondre. Cette petite doc' est basée sur du code qui fonctionne donc il n'y a pas de raisons de ne pas pouvoir le reproduire pour vos propres éléments.
