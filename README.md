# CodeIgniter Theme

This is a Theme library, heavily inspired by the wordpress/joomla theming system.
Easily developing themes with all assets at one place.

## Core Features

-  All themes and assets in one place
-  Overriding of views (by placing it in your view folder of your theme)
-  Automatic translating of relative URL's

(for example: you've download a theme from http://www.free-css.com,
just drop it in your themes folder and rename index.html to index.php, it'll work right away)

## Installing

Just copy the files from this package to the correspoding folder in your
application folder.
Then copy the 'themes' folder to the root of your codeigniter path
(usually where the 'application' and 'system' reside)
Make some adjustments to the config (if needed)
And also (if using .htaccess) make the neccesary changes to allow
readability on the 'themes' folder.

## Example

I provided an example (theme_example) in the controllers and views folder.
Copy these files to your application/controllers and application/views path
Then call it as you normally would e.g. http://localhost/my_ci/theme_example

I provided this with theme switching (via a cookie, just so you know)

## Themes

I included 2 themes.

1) Bootstrap, from twitter (this is the default theme) ( http://twitter.github.com/bootstrap )
2) Skeleton ( http://getskeleton.com/ )

Both themes are excellent but if you want you can always drop-in your own themes.