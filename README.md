# Laravel Authentication API

This repository contains a basic authentication system built with Laravel, implementing user registration, login, logout, password reset, and email verification. The project follows a service-based architecture to separate business logic from controllers, improving maintainability and scalability.

## Features

- **User Registration**: Create a new user account and generate an authentication token.
- **User Login**: Authenticate users and return a valid token.
- **Logout**: Invalidate the user's authentication token.
- **Password Reset**: Request a password reset link and update credentials.
- **Email Verification**: Send verification emails and validate email addresses.
- **Service-based Architecture**: Business logic is handled in service classes for better code organization.

## Prerequisites

Before running this project, ensure you have the following installed:

- PHP 8.1+
- Composer
- Laravel 10+
- MySQL or PostgreSQL database
- Redis (for caching email verification tokens)
- Mail configuration (SMTP, Mailtrap, etc.)

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/CarlosMateoM/laravel-auth-basic-api.git
   cd laravel-auth-basic-api
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy environment configuration:
   ```sh
   cp .env.example .env
   ```
4. Configure database and mail settings in the `.env` file.
5. Run migrations:
   ```sh
   php artisan migrate
   ```
6. Generate application key:
   ```sh
   php artisan key:generate
   ```
7. Start the development server:
   ```sh
   php artisan serve
   ```

## API Endpoints

```
POST       api/v1/email/verification-notification  ....................  EmailVerificationController@sendEmail
POST       api/v1/email/verify  .......................................  EmailVerificationController@verifyEmail
POST       api/v1/forgot-password  ....................................  AuthController@forgotPassword
POST       api/v1/login  ..............................................  AuthController@login
DELETE     api/v1/logout  .............................................  AuthController@logout
POST       api/v1/register  ...........................................  AuthController@register
POST       api/v1/reset-password  .....................................  AuthController@resetPassword
GET|HEAD   api/v1/user  ...............................................  UserController
```

## License

This project is open-source and available under the [MIT License](LICENSE).

