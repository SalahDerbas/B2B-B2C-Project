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
