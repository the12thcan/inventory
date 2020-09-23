How to run the tets :)
Run in the terminal in directory 12th-Can/Inventory-Site
Run the following commands in the terminal
*Make sure to have laravel dusk installed*
*Make sure the database is clear as the register group tests would fail if the accounts are already registered*


1. php artisan migrate:fresh --seed
2. php artisan dusk --group=site

If it doesn't work I found success from switching my chrome drive:  php artisan dusk:chrome-driver 72
