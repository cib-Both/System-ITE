<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://logowik.com/content/uploads/images/laravel8530.jpg" width="400" alt="Laravel Logo"></a>
<a href="https://filamentphp.com" terget="_blank"><img src="https://logowik.com/content/uploads/images/filament-laravel4896.logowik.com.webp" width="400" alt="Filament logo"></a></p>

## About the Project

This project is a Inventory System Management application built using the Laravel/Filament framework. It leverages Laravel's expressive syntax and powerful tools to streamline development and deliver a seamless user experience. The project is designed to handle complex business logic while maintaining simplicity and flexibility.

### Key Features:
- **Modern UI/UX**: Built with responsive design principles for an intuitive user experience.
- **Efficient Data Management**: Utilizes Laravel's Eloquent ORM for database interactions.
- **Secure Authentication**: Implements secure user authentication and authorization.
- **Real-Time Functionality**: Supports real-time updates using Laravel's broadcasting capabilities.
- **Extensible Architecture**: Designed with modularity in mind, making it easy to extend and maintain.

This project is ideal for developers looking to build enterprise-grade applications with minimal effort, leveraging Laravel's ecosystem and best practices.

## How to make the project work

### Clone the project: 
-> `git clone https://github.com/cib-Both/System-ITE.git`
### Installation: 
-> `composer install`

-> `npm install`
### Database work
- **Connect to the Database**: Create a `.env` file by copying from the `.env.example` file, then update the database connection details. You can copy the following configuration: 

    `DB_CONNECTION=mysql`

    `DB_HOST=127.0.0.1`

    `DB_PORT=3306`

    `DB_DATABASE=` 

    `DB_USERNAME=root`

    `DB_PASSWORD=` 

- **Generate api key**:

  `php artisan key:generate`
- **Migration**:

  `php artisan migrate`
- **Seed Data**:

  `php artisan db:seed`

  `php artisan db:seed --class=PermissionSeeder`
- **Run the project**:

  `composer run dev`

## Admin Login

- *Email* : `admin@gmail.com`
- *Passwork* : `12345`


<p align="center">
  Made with ❤️ if you like | © 2025 Inventory-System Management
</p>
