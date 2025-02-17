# Laravel API Authentication with Sanctum

This repository contains a basic authentication system built with Laravel, implementing user registration, login, logout, password reset, and email verification.  

## Features

- **User Registration**: Create a new user account and generate an authentication token.
- **User Login**: Authenticate users and return a valid token.
- **Logout**: Invalidate the user's authentication token.
- **Password Reset**: Request a password reset link and update credentials.
- **Email Verification**: Send verification emails and validate email addresses. 

## Prerequisites

Before running this project, ensure you have the following installed:

- PHP 8.2+
- Composer
- Laravel 11+
- MySQL or PostgreSQL database
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
POST       api/v1/resend-email-verification  ..........................  EmailVerificationController@sendEmail
POST       api/v1/verify-email  .......................................  EmailVerificationController@verifyEmail
POST       api/v1/forgot-password  ....................................  AuthController@forgotPassword
POST       api/v1/login  ..............................................  AuthController@login
DELETE     api/v1/logout  .............................................  AuthController@logout
POST       api/v1/register  ...........................................  AuthController@register
POST       api/v1/reset-password  .....................................  AuthController@resetPassword
GET|HEAD   api/v1/user  ...............................................  UserController
```

## License

This project is open-source and available under the [MIT License](LICENSE).

