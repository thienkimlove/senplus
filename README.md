## Install Commands logs

```textmate
11  composer require backpack/permissionmanager
12  php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
13  php artisan migrate
14  php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
15  php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider"
16  composer require backpack/settings
17  php artisan vendor:publish --provider="Backpack\Settings\SettingsServiceProvider"
18  php artisan migrate
19  php artisan backpack:add-sidebar-content "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon fa fa-cog'></i> Settings</a></li>"
20  composer require backpack/filemanager
21  php artisan backpack:filemanager:install
22  git status
23  git add . && git commit -m update && git push origin master
24  chmod -R 777 public/uploads

```

* I was install backpack settings, backpack file manager and also backpack permission.

* Currently user have 2 roles `admin` and `editor`.