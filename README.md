# CodeIgniter Theme

This is a Theme library, heavily inspired by the Wordpress/Joomla theming system. Easily developing themes with all assets at one place.

## Core Features

-  All themes and assets in one place
-  Overriding of views (by placing it in your view folder of your theme)
-  Automatic translating of relative URL's

For example: you've download a theme from http://www.free-css.com,
just drop it in your themes folder and rename index.html to index.php, it'll work right away.

## Installing

- Copy the files from this package to the correspoding folder in your
`application` folder.
- Copy the `themes` folder to the root of your Codeigniter path
- Make some adjustments to the config (if needed)
And also (if using .htaccess) make the neccesary changes to allow
readability on the `themes` folder.

## Example

For example:

```php
$this->theme->view('theme_example');
```

Chainable method:

```php
$this->theme->set('status', 'Success')->view('theme_example');
```

#### Set Theme
```php
$this->theme->set_theme('my_theme');
```

#### Set Layout
```php
$this->theme->set_layout('single');
```

#### Set Data
```php
$this->theme->set('user', $user);
```

#### Etc..

## Themes

I included 2 themes.

-  Bootstrap, from twitter (this is the default theme) ( http://twitter.github.com/bootstrap )
-  Skeleton ( http://getskeleton.com/ )

Both themes are excellent but if you want you can always drop-in your own themes.