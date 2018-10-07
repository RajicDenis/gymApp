<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Testing GymApp

1. Create new database called "gym"
2. run --> php artisan migrate --seed

## How it works

- Register to the app
- After successful registration you will be redirected to the programs page.
- Click on "Start new program" to choose program name, level, trainer and start date.
- You can cancel the program as soon as you create it but it can only be paused after it starts.
- You can only pause, cancel or continue the program on the first day of the week (Sunday)
- You can change the level or the trainer at any time unless the program is canceled or finished
- You can only start a new program after you cancel the existing one or after it finishes
- There is a refresh button on the program. If you pause the program and continue after two weeks, the two weeks are added to the end date. If they are not added automatically, you can refresh the program and the date will change.

## Timetravel

- To be able to test the program there is a form at the top called timetravel.
- The form allows you to choose the current date (in a real app this would be replaced with the current date).
- For example: You can start the program and then use the form to "travel" two weeks to the future. Then you can pause the program and travel another four weeks in the future and then continue the program. These four weeks are then added to the end date of the program so that the progress of the program stays the same. Also, you can travel to the last day of the program and the program will automatically finish and give you the option to start a new one.


