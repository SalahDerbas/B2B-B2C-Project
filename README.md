# API Routes Documentation B2C API

This document provides an overview of the API routes for the project. All routes are grouped based on their functionality, making it easier for developers to navigate and use the API effectively.



### API Security
- **JWT Authentication**: 
  - Secure all sensitive routes with JSON Web Token (JWT) authentication.
- **Token Expiry**: 
  - Expiring tokens to ensure secure access and session management.
- **Role-based Access Control**: 
  - Different access levels based on user roles (admin, employee, manager).

### Integration
- **OAuth 2.0 Integration**: 
  - Allows users to login through Google, Facebook, or Apple OAuth.
- **Third-party Integration**: 
  - Seamless integration with external systems for specific HR functions.

### Error Handling
- **API Error Responses**: 
  - Detailed error messages with HTTP status codes to help users troubleshoot issues.
- **Custom Error Messages**: 
  - User-friendly error messages to simplify debugging and improve the user experience.




## Table of Contents
1. [Public User Routes](#public-user-routes)
2. [Content Routes](#content-routes)
3. [Home Routes](#home-routes)
4. [Authenticated User Routes](#authenticated-user-routes)
    - [User Routes](#user-routes)
    - [Notification Routes](#notification-routes)
    - [Orders Routes](#orders-routes)

---

## Public User Routes
### Base URL: `/user`

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| POST   | `/login`              | User login                         |
| POST   | `/check-otp`          | Verify OTP                         |
| POST   | `/re-send-otp`        | Resend OTP                         |
| POST   | `/login-by-google`    | Login with Google                  |
| POST   | `/login-by-facebook`  | Login with Facebook                |
| POST   | `/login-by-apple`     | Login with Apple                   |
| POST   | `/forget-password`    | Request password reset             |
| POST   | `/reset-password`     | Reset password                     |
| POST   | `/register`           | User registration                  |

## Content Routes
### Base URL: `/user/content`

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/terms-conditions`   | Get terms and conditions           |
| GET    | `/privacy-policy`     | Get privacy policy                 |
| GET    | `/about-us`           | Get about us content               |
| GET    | `/faq`                | Get FAQ content                    |
| GET    | `/sliders`            | Get sliders for UI                 |
| POST   | `/contact-us`         | Submit contact form                |

## Home Routes
### Base URL: `/home`

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/`                   | Get home data                      |
| GET    | `/search/{input}`     | Search for items                   |
| GET    | `/slider`             | Get homepage sliders               |

#### Category Sub-Routes
| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/category`           | Get all categories                 |
| GET    | `/category/regional`  | Get regional categories            |
| GET    | `/category/local`     | Get local categories               |
| GET    | `/category/global`    | Get global categories              |
| GET    | `/category/{id}`      | Get category by ID                 |

#### Item Sub-Routes
| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/items/{sub_category_id}` | Get items for sub-category     |
| GET    | `/items/show/{id}`    | Get item details                   |

## Authenticated User Routes
These routes require authentication via an API token.

### User Routes
#### Base URL: `/user`

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/get-profile`        | Get user profile                   |
| GET    | `/refresh-token`      | Refresh authentication token       |
| GET    | `/logout`             | User logout                        |
| POST   | `/update-profile`     | Update user profile                |
| DELETE | `/delete`             | Delete user account                |

### Notification Routes
#### Base URL: `/user/notification`

| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/`                   | Get notifications                  |
| GET    | `/update-enable`      | Update notification settings       |

### Orders Routes
#### Base URL: `/user/order`

##### Submit Order Sub-Routes
| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| POST   | `/submit-order/pay`   | Submit order payment               |
| POST   | `/submit-order/check-promocode` | Check promocode validity |

##### Order Data
| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| POST   | `/order-data`         | Submit order data                  |

##### Packages Sub-Routes
| Method | Endpoint              | Description                         |
|--------|-----------------------|-------------------------------------|
| GET    | `/packages`           | Get package status                 |
| POST   | `/packages/usage`     | Update package usage               |
| POST   | `/packages/get-qr`    | Generate QR code for package       |
| POST   | `/packages/reedem-qr` | Redeem QR code for package         |

---



# B2B API Project

This project provides a set of APIs to manage public user authentication, home data, and order management for B2C and B2B services.

---

## Routes

### Public User Routes
These routes are available without authentication.

- **POST** `/user/login`  
  **Description**: User login.  
  **Controller**: `AuthController@login`  
  **Route Name**: `api.b2b.user.login`

- **POST** `/user/forget-password`  
  **Description**: Initiate password reset process.  
  **Controller**: `AuthController@forgetPassword`  
  **Route Name**: `api.b2b.user.forget_password`

- **POST** `/user/reset-password`  
  **Description**: Reset user password.  
  **Controller**: `AuthController@resetPassword`  
  **Route Name**: `api.b2b.user.reset_password`

- **POST** `/user/check-otp`  
  **Description**: Validate OTP for the user.  
  **Controller**: `AuthController@checkOtp`  
  **Route Name**: `api.user.check_otp`

- **POST** `/user/re-send-otp`  
  **Description**: Resend OTP for verification.  
  **Controller**: `AuthController@resendOtp`  
  **Route Name**: `api.user.resend_otp`

---

### Authenticated User Routes
These routes require API token-based authentication.

#### Home Routes
- **GET** `/home/search/{input}`  
  **Description**: Search for items or categories.  
  **Controller**: `HomeController@search`  
  **Route Name**: `api.b2b.home.search`

##### Category Endpoints
- **GET** `/home/category`  
  **Description**: List all categories.  
  **Controller**: `CategoryController@index`  
  **Route Name**: `api.b2b.home.category.index`

- **GET** `/home/category/regional`  
  **Description**: Retrieve regional categories.  
  **Controller**: `CategoryController@getRegional`  
  **Route Name**: `api.b2b.home.category.getRegional`

- **GET** `/home/category/local`  
  **Description**: Retrieve local categories.  
  **Controller**: `CategoryController@getLocal`  
  **Route Name**: `api.b2b.home.category.getLocal`

- **GET** `/home/category/global`  
  **Description**: Retrieve global categories.  
  **Controller**: `CategoryController@getGlobal`  
  **Route Name**: `api.b2b.home.category.getGlobal`

- **GET** `/home/category/{id}`  
  **Description**: Retrieve details of a specific category.  
  **Controller**: `CategoryController@show`  
  **Route Name**: `api.b2b.home.category.show`

##### Item Endpoints
- **GET** `/home/items/{sub_category_id}`  
  **Description**: List items under a sub-category.  
  **Controller**: `ItemController@index`  
  **Route Name**: `api.b2b.home.items.index`

- **GET** `/home/items/show/{id}`  
  **Description**: Retrieve details of a specific item.  
  **Controller**: `ItemController@show`  
  **Route Name**: `api.b2b.home.items.show`

---

#### User Routes
- **GET** `/user/get-profile`  
  **Description**: Fetch the authenticated user's profile.  
  **Controller**: `AuthController@getProfile`  
  **Route Name**: `api.b2b.user.get_profile`

- **GET** `/user/get-balance`  
  **Description**: Fetch the authenticated user's balance.  
  **Controller**: `AuthController@getBalance`  
  **Route Name**: `api.b2b.user.get_balance`

- **GET** `/user/refresh-token`  
  **Description**: Refresh the user's API token.  
  **Controller**: `AuthController@refreshToken`  
  **Route Name**: `api.b2b.user.refresh_token`

- **GET** `/user/logout`  
  **Description**: Logout the authenticated user.  
  **Controller**: `AuthController@logout`  
  **Route Name**: `api.b2b.user.logout`

---

#### Order Routes
##### Submit Order
- **POST** `/user/order/submit-order/pay`  
  **Description**: Submit payment for an order.  
  **Controller**: `SubmitController@pay`  
  **Route Name**: `api.b2b.user.order.pay`

- **POST** `/user/order/order-data`  
  **Description**: Fetch order details.  
  **Controller**: `SubmitController@orderData`  
  **Route Name**: `api.b2b.user.order.orderData`

##### Packages
- **GET** `/user/order/packages`  
  **Description**: List available packages.  
  **Controller**: `StatusPackageController@index`  
  **Route Name**: `api.b2b.user.order.packages`

- **POST** `/user/order/packages/usage`  
  **Description**: Submit package usage details.  
  **Controller**: `StatusPackageController@usage`  
  **Route Name**: `api.b2b.user.order.packages.usage`

- **POST** `/user/order/packages/get-qr`  
  **Description**: Generate a QR code for a package.  
  **Controller**: `SharePackageController@getQR`  
  **Route Name**: `api.b2b.user.order.packages.getQR`

- **POST** `/user/order/packages/reedem-qr`  
  **Description**: Redeem a QR code.  
  **Controller**: `SharePackageController@reedemQR`  
  **Route Name**: `api.b2b.user.order.packages.reedemQR`

---











# Order API Project

This project contains a set of APIs related to order processing. It includes various callback routes to handle success and failure scenarios.

## Routes

The following routes are available for handling order callbacks:

### `POST /order/callback`
- **Description**: This route handles both GET and POST requests for the order callback.
- **Controller**: `OrderController@callBack`
- **Usage**: Typically used for receiving data from an external system or callback service.

### `GET /order/callback-failed`
- **Description**: This route is triggered when the order process fails.
- **Controller**: `OrderController@failedPage`
- **Usage**: Used to display a failed order page to the user after an unsuccessful process.

### `GET /order/callback-success/{order_id}`
- **Description**: This route handles a successful order process, including an order ID.
- **Controller**: `OrderController@successPage`
- **Usage**: Displays the success page for the user after a successful order completion, with the order ID passed as a parameter.

## Usage

- Use Postman or any API client to test the routes.
- For successful callback, the URL format will be:  
  `http://your-app-url/order/callback-success/{order_id}`
- For failed callback, use:  
  `http://your-app-url/order/callback-failed`


## Author
This API documentation was created by **Salah Derbas**, Senior Laravel Developer.

---

## Notes
- Ensure the API token is included in the `Authorization` header for authenticated routes.
- For any issues or questions, please open a GitHub issue or contact the maintainer directly.
