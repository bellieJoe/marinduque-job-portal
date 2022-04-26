
# Marinduque Job Portal
Marinduque Job Portal is a web-based Job Hunting platform dedicated for LMD-PESO Marinduque, this website is associated with a capstone/research project conducted by the students of Bachelor of Science in Information Technology in Marinduque State College as part of their completion for the said course.

This static website uses [Laravel 9](https://laravel.com) as the main framework for the development.


## Installation & Setup

### Dependencies
To setup this project you need to have the following installed on your system.
* PHP 7 or any version that might work
* Composer
* Node.js
* MySQL

To make the installation of PHP and MySQL easier you can install [Xampp](https://www.apachefriends.org/download.html) that comes with PHP and MySQL.

### Development Setup

 1. Download or Clone this repository on your local machine and extract the folder.
 2. Open the folder with powershell or any terminal then migrate to the `marinduque_job_portal_main` folder that contains all the folders and source files.
 3. Install all the package dependencies for Composer and Node by running `composer install` and `npm install` respectively.
 4.  Now that all the dependencies are installed the next thing we have to configure is the Environment variables or the `.env` file.  Create a file named  `.env` and copy the contents of the .env,example to it. Now we have to change the values of the environment variables below, *note that this environment variable wil be based on your prefered configuration, you visit the laravel documentation to setup the environment variables*.
 `APP_NAME='Marinduque Job Portal'
 DB_DATABASE=jobportal 
 BROADCAST_DRIVER=pusher 
 MAIL_MAILER=smtp 
 MAIL_HOST=smtp.googlemail.com 
 MAIL_PORT 
 MAIL_USERNAME 
 MAIL_PASSWORD 
 MAIL_ENCRYPTION 
 MAIL_FROM_ADDRESS 
 MAIL_FROM_NAME 
 PUSHER_APP_ID 
 PUSHER_APP_KEY 
 PUSHER_APP_SECRET 
 PUSHER_APP_CLUSTER
 DEV_HOST=127.0.0.1
 DEV_PORT=8000 
 ALGOLIA_APP_ID 
 ALGOLIA_SECRET `
 
### Database Setup
 1. For the database setup you have to create a database named 'jobportal' on your MySQL server and leave it blank. 
 2. On your terminal navigate again to your development folder then run `php artisan migrate` and `php artisan db:seed` respectively.
 3. Check your jobportal database again and you will see that the tables are now loaded.
 
 ### Running the website locally
 To run the website you just run `php artisan serve` on your terminal, this will initiate a local server on localhost:8000.
 Lastly open your browser and access the localhost:8000.
