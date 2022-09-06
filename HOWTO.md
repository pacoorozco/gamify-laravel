# How to

## Customize the content of the different views (screens)

You can create Blade view files under the `resources/views/custom` folder. These files will override the default ones. 

1. Copy the default view file under the `resources/views/custom` folder, maintaining the folder location. Imagine that you want to customize the `dashboard` view, you should copy `resources/views/dashboard` in to `resources/views/custom/dashboard`.
2. Modify the view file inside the `resources/views/custom` folder using the [Blade templating language](https://laravel.com/docs/9.x/blade).
3. If you're caching the views, you must clear the cache to see the changes, execute `php artisan view:clear`.
