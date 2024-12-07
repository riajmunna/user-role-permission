# **User Role and Permission Management API**

## **Description**
This project is a RESTful API built with Laravel. It is designed to manage users, roles, and permissions. It includes secure token-based authentication using Laravel Passport and middleware to verify user access permissions.

---

## **Features**
- **User Management**: CRUD operations for users with role and permission.
- **Role Management**: CRUD operations for roles and assigning roles to users.
- **Permission Management**: CRUD operations for permissions and assigning them to users/roles.
- **Secure Authentication**: Token-based authentication using Laravel Passport.
- **Access Control**: Middleware to check if a user has the necessary permissions for specific routes.

---

## **Installation**

### **Prerequisites**
Ensure the following are installed on your system:
- PHP v8.2.4
- Composer v2.6.5
- Laravel Framework v11
- MySQL
- Laravel Passport

### ***Clone the Repository***:

git clone https://github.com/riajmunna/user-role-permission.git

cd user-role-permission


### ***Install Dependencies***:

composer install


### ***Configure Environment***:

copy the .env.example and paste with the name .env


### ***Run Migrations***:

php artisan migrate


### ***Install Laravel Passport***:

php artisan passport:install


### ***Generate Application Key for Laravel passport***:

php artisan key:generate


### ***Run the application***:

php artisan serve

## **API Endpoints**

### ***Authentication***
POST /login: Log in and get a token.
POST /register: Register a new user.

### ***Users***
GET /users: List all users.
POST /users: Create a new user.
GET /users/{id}: Get details of a user.
PUT /users/{id}: Update a user.
DELETE /users/{id}: Delete a user.

### ***Roles***
GET /roles: List all roles.
POST /roles: Create a new role.
GET /roles/{id}: Get details of a role.
PUT /roles/{id}: Update a role.
DELETE /roles/{id}: Delete a role.
POST /roles/assign-to-user: Assign a role to a user.

### ***Permissions***
GET /permissions: List all permissions.
POST /permissions: Create a new permission.
GET /permissions/{id}: Get details of a permission.
PUT /permissions/{id}: Update a permission.
DELETE /permissions/{id}: Delete a permission.
POST /permissions/assign-to-user: Assign a permission to a user.
POST /permissions/assign-to-role: Assign a permission to a role.


## **Example Requests**

### ***User Login***

POST /login:

{
    "email": "riaj.cse@gmail.com",
    "password": "riaj1234"
}

### ***Create User***

POST /users:

{
    "name": "Riaj Hosen",
    "email": "riaj.cse@gmail.com",
    "password": "riaj1234"
}

### ***Assign Role to User***

POST /roles/assign-to-user:

{
    "user_id": 1,
    "role_id": 2
}

### ***Postman Collection***

https://api.postman.com/collections/26053853-2f738361-3a06-4c15-b8bf-b6217c72ea7b?access_key=PMAT-01JEH3KJXKKSSKC5QQX73MGH75
