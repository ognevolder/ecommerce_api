<p align="center">
  <a href="https://ognevolder.pro" target="_blank">
    <img src="/resources/ognevolder.svg" width="400" alt="Ognevolder Logo"></img>
  </a>
</p>

# Ecommerce API project

Back-end REST API e-commerce project built with Laravel. Contains basic CMS.

# Tech Stack

- PHP 8+
- Laravel
- MySQL

# Architecture

This project follows a layered architecture with separation of responsibilities between controllers, actions, services and models.
The goal is to keep controllers thin, move business logic to services/actions and make the code easier to maintain and test.

#### Layers

Request -> Controller -> Service -> Action -> Model -> Database.

#### Controller

Handle HTTP requests and responses. Validates incoming data, calls services and returns JSON-response. Controller do not contain business logic.

#### Service

Service contain business logic and domain workflows, coordinate models, actions and policies.

- OrderService (create(), fulfill(), cancel()).
- AuthService (register(), login(), logout()).
- ProductService (create(), update(), delete(), show()).

#### Models

Eloquent Models represent database entities. Define relationships, scopes and attribute casting.

- Order -> hasMany(OrderItems).
- User -> hasMany(Orders).
- Product -> belongsTo(User).

# Key Principles

The project follows several backend engineering principles:

- Thin controllers.
- Single responsibility.
- Separation of concerns.
- Reusable services.
- Clear domain logic.
- API-first design.

# Installation

1. Clone repository.
2. Run composer install.
3. Configure .env file.
4. Run 'php artisan migrate'.
5. Run 'php artisan serve'.

# API endpoints

#### Public

- POST /api/registration - User Registration
- POST /api/login - User Authorization
- POST /api/logout - User Log Out

- GET /api/products - List of products
- GET /api/product/{id} - Show single product

#### Auth

- POST /api/orders - Create order
- GET /api/orders/{id} - List of personal orders
- PATCH /api/order/{id} - Change personal Order
- PATCH /api/order/cancel/{id} - Cancel personal Order

#### CMS

- GET /api/admin/orders - Index all orders
