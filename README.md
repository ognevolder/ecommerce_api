<p align="center">
  <a href="https://ognevolder.pro" target="_blank">
    <img src="/resources/ognevolder.svg" width="400" alt="Ognevolder Logo"></img>
  </a>
</p>

## Ecommerce API project

Back-end REST API built with Laravel.

## Tech Stack

- PHP 8+
- Laravel
- MySQL

## Installation

1. Clone repository.
2. Run composer install.
3. Configure .env file.
4. Run 'php artisan migrate'.
5. Run 'php artisan serve'.

## API endpoints

#Public
POST /api/registration - User Registration
POST /api/login - User Authorization

GET /api/products - List of products
GET /api/product/{id} - Show single product

POST /api/orders - Create order (Auth)
GET /api/orders/{id} - List of user orders
GET /api/admin/orders - Index all orders
