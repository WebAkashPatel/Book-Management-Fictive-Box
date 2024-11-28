Book management system  developed by Akash Patel
Mo. Number - 7828676830


Step 1 install PHP by Brew(FOR MAC ONLY, Skip this if you have alredy installed) $ brew install php It will install php 8.0

Step 2(FOR MAC ONLY, Skip this if you have alredy installed) Install Composer
brew install composer
For more https://formulae.brew.sh/formula/composer

Step 3
Setup Git and clone the project file by
git clone 

Step 4
Download all dependecy by Composer
composer install

Step 5
Craete .Env File by duplicalating .env.example

Step 6
Setup Env File by changing database credintial

Step 7
Run the migration for Database php artisan command
php artisan migrate

Step 8
Run the seeder for Default Admin Credentials php artisan command
php artisan db:seed --class=AdminDefaultCredSeeder

Step 9
Run the server for Host php artisan command
php artisan serve
