Laravel 11 E-Commerce Application
Project Overview

This is a simple e-commerce application built using Laravel 11. It includes functionalities for managing products and orders, with user authentication to secure the application.
Key Features:

    Product Management (CRUD):
        Create, Read, Update, and Delete products.
        Manage product attributes such as name, price, and quantity.

    Order Management:
        List all orders placed by users.
        Store new orders, allowing users to select products and create orders.

    User Authentication:
        Secure login feature using Laravel’s sanctum.
        Only authenticated users can access the product and order management features.

Project Setup and Installation
Prerequisites

Make sure you have the following installed on your machine:

    PHP = 8.2
    Composer (Dependency Manager for PHP)
    MySQL


Steps to Run the Project:

    Clone the Repository: Clone this repository to your local machine using the command:

cd project_folder_name

Install Dependencies: Run the following commands to install Laravel dependencies via Composer:

bash

composer install

Configure Environment: Copy the example environment file and set up your own .env file:

bash

cp .env.example .env

Update the .env file with your database credentials and other configurations (e.g., DB_HOST, DB_CONNECTION=mysql, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Generate Application Key: Generate a unique application key using Artisan:

bash

php artisan key:generate

Run Migrations and Seed Database: This project includes migration files to set up the database schema and seeders to populate some initial data. Run the following command to migrate the database and seed it with test data:

bash

php artisan migrate --seed

Start the Application: Finally, you can start the local development server with:

bash

    php artisan serve

    Your application will be accessible at http://localhost:8000.

Database Structure

The application uses a MySQL database with the following main tables:

    users: Stores user details for authentication.
    products: Contains information about the products, such as name , price, and quantity.
    orders: Stores the details of customer orders.
    order_product: A pivot table for many-to-many relationships between orders and products, capturing which products are part of each order.

Seeding the Database

The application includes seeders to quickly populate the database with demo data for testing purposes. When you run the php artisan migrate --seed command, the following seeders will be executed:

    UserSeeder: Creates default users for login, including test@example.com with password 123456789.
    ProductSeeder: Adds sample products to the database.

If you need to re-seed the data at any time, run:

bash

php artisan db:seed

Authentication

The application comes with authentication . To access the product and order management features, users must be logged in. You can use the pre-seeded test account:

    Email: test@example.com
    Password: 123456789

API Endpoints
Authentication

    Login:
        POST api/login
        Credentials:
            Email: test@example.com
            Password: 123456789
    Example request:

    bash

    curl -X POST http://localhost:8000/login \
    -H "Content-Type: application/json" \
    -d '{"email": "test@example.com", "password": "123456789"}'

Products

    Get All Products:
        GET api/products: List all products.
    Create Product:
        POST api/products: Create a new product (requires authentication).
    Update Product:
        PUT api/products/{id}: Update an existing product (requires authentication).
    Delete Product:
        DELETE api/products/{id}: Delete a product (requires authentication).

Orders

    Get All Orders:
        GET api/orders: List all orders (requires authentication).
    Create New Order:
        POST api/orders: Place a new order (requires authentication).

