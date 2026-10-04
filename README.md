# 📚 Book Store Web Application

A full-featured **Book Store Web Application** built from scratch using **PHP and MySQL**, following the **MVC (Model–View–Controller)** architecture with a **Singleton Design Pattern**.

The project was developed as a practical training project to apply backend development concepts, database integration, authentication, authorization, sessions, middleware, AJAX, and clean application structure in a real-world web application.

---

## 🚀 Project Overview

The **Book Store** is an online bookstore that allows customers to browse books, manage their accounts, add books to their cart, place orders, and track their orders.

The system also provides an **Admin Dashboard** where administrators can manage books, authors, users, and orders.

The main goal of this project was not only to build a working bookstore, but also to understand how a real backend web application is structured and how its different layers communicate with each other.

---

## ✨ Features

### 👤 Authentication & Authorization

* User Registration
* User Login
* User Logout
* User Profile
* Session-based authentication
* Authentication Middleware
* Guest Middleware
* Role-based access
* Protected routes
* Admin and Customer permissions

---

### 📚 Books Management

* Display available books
* View book details
* Add books
* Edit books
* Delete books
* Manage book information
* Connect books with their authors
* Manage book inventory

---

### ✍️ Authors Management

* Add authors
* Edit authors
* Delete authors
* Display author information
* Connect authors with their books

---

### 🛒 Shopping Cart

* Add books to cart
* Remove books from cart
* Increase book quantity
* Decrease book quantity
* Calculate item totals
* Calculate order total
* Dynamic cart updates using AJAX

---

### 📦 Orders

* Create orders
* Store order information in the database
* Display customer orders
* View order details
* Manage order status
* Pagination for orders
* Filter orders by status
* Dynamic order loading using AJAX

---

### 👨‍💼 Admin Dashboard

The admin section allows administrators to manage the main resources of the bookstore.

Admin features include:

* Manage Users
* Manage Books
* Manage Authors
* Manage Orders
* Update order status
* View system data
* Control administrative operations

---

### 🔎 Search & Pagination

The application includes dynamic data handling such as:

* Searching
* Filtering
* Pagination
* Loading data dynamically
* AJAX-based requests

This helps improve the user experience and reduces unnecessary page reloads.

---

### ⚡ AJAX & Dynamic UI

**jQuery AJAX** is used in several parts of the application to communicate with the backend without requiring a full page reload.

Examples include:

* Loading orders
* Pagination
* Updating quantities
* Cart operations
* Dynamic data retrieval
* Updating parts of the page asynchronously

---

## 🏗️ Architecture

The project follows the **MVC architecture**.

### MVC stands for:

**Model → View → Controller**

### Model

Responsible for:

* Database interaction
* Retrieving data
* Inserting data
* Updating data
* Deleting data
* Application data logic

### View

Responsible for:

* HTML structure
* UI components
* Displaying data
* User interaction

### Controller

Responsible for:

* Receiving requests
* Validating input
* Calling models
* Processing application logic
* Returning the appropriate view

This separation makes the application easier to maintain, debug, and extend.

---

## 🎯 Design Patterns

### Singleton Design Pattern

The project also implements the **Singleton Design Pattern**.

The purpose of Singleton is to ensure that a specific class has only **one instance** throughout the application and provides a single point of access to that instance.

This pattern was mainly useful for managing shared application resources and avoiding unnecessary object creation.

---

## 🔐 Middleware

Middleware is used to control access to specific routes before the request reaches the controller.

The project includes middleware such as:

### Auth Middleware

Used to make sure that the user is authenticated before accessing protected pages.

### Guest Middleware

Used to prevent authenticated users from accessing pages intended only for guests, such as login and registration.

### Authorization

Different permissions are applied depending on the user's role.

---

## 🛣️ Routing

The application contains a custom routing system that handles:

* GET requests
* POST requests
* Route parameters
* Protected routes
* Middleware-protected routes
* Controller actions

Example:

```php
Route::get('/profile', [ProfileController::class, 'index']);

Route::post('/login', [LoginController::class, 'login']);
```

The routing system helps keep URLs and application logic organized.

---

## 🗄️ Database

The project uses **MySQL** as its relational database.

The database stores information such as:

* Users
* Books
* Authors
* Orders
* Order Items
* User information
* Book information
* Order status

The application communicates with the database through the Model layer.

---

## 🔄 Application Flow

A simplified request flow looks like this:

```text
User
  │
  ▼
Route
  │
  ▼
Middleware
  │
  ▼
Controller
  │
  ▼
Model
  │
  ▼
MySQL Database
  │
  ▼
Model
  │
  ▼
Controller
  │
  ▼
View
  │
  ▼
User
```

For AJAX requests:

```text
JavaScript / jQuery
        │
        ▼
      AJAX
        │
        ▼
      Route
        │
        ▼
    Controller
        │
        ▼
      Model
        │
        ▼
      Database
        │
        ▼
      Response
        │
        ▼
    JavaScript
        │
        ▼
   Update UI
```

---

## 🧩 Project Structure

The project is organized into separate layers to keep the code maintainable and scalable.

```text
BookStore/
│
├── app/
│   ├── controllers/
│   │   ├── HomeController.php
│   │   ├── LoginController.php
│   │   ├── RegisterController.php
│   │   ├── ProfileController.php
│   │   ├── UserController.php
│   │   ├── AuthorController.php
│   │   ├── BookController.php
│   │   └── OrderController.php
│   │
│   ├── models/
│   │   ├── User.php
│   │   ├── Author.php
│   │   ├── Book.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   │
│   ├── middleware/
│   │   ├── Auth.php
│   │   ├── Guest.php
│   │   └── Register.php
│   │
│   ├── views/
│   │   ├── Home/
│   │   ├── Login/
│   │   ├── Register/
│   │   ├── Profile/
│   │   ├── Author/
│   │   ├── Book/
│   │   ├── Order/
│   │   └── components/
│   │
│   └── core/
│       ├── Route.php
│       ├── Database.php
│       └── ...
│
├── config/
│
├── public/
│   ├── index.php
│   ├── css/
│   ├── js/
│   └── images/
│
├── routes/
│   └── web.php
│
├── .htaccess
│
└── README.md
```

> The exact structure may vary depending on the current version of the project.

---

## 🛠️ Technologies Used

### Backend

* **PHP**
* **MySQL**

### Frontend

* **HTML5**
* **CSS3**
* **SCSS**
* **Bootstrap**
* **JavaScript**
* **jQuery**
* **AJAX**

### Architecture & Concepts

* MVC Architecture
* Singleton Design Pattern
* Object-Oriented Programming
* Middleware
* Routing
* Authentication
* Authorization
* Sessions
* CRUD Operations
* Database Relationships
* Validation
* Pagination
* AJAX Requests

### Tools

* Git
* GitHub
* VS Code
* XAMPP

---

## 💡 What I Learned

Building this project helped me understand how different parts of a real web application work together.

### Backend Development

* How PHP handles requests
* How controllers communicate with models
* How models communicate with databases
* How sessions work
* Authentication and authorization
* Middleware
* Routing
* CRUD operations

### Database

* MySQL database design
* Relationships between tables
* Working with queries
* Retrieving related data
* Updating and deleting records

### Frontend & AJAX

* DOM manipulation
* jQuery
* AJAX requests
* Dynamic content updates
* Pagination
* Form handling
* Interactive UI

### Software Architecture

One of the most important things I learned from this project was how to organize a project instead of putting all the code in one place.

Using MVC helped me understand the separation between:

```text
Business Logic
      ↓
Controllers
      ↓
Models
      ↓
Database

Presentation
      ↓
Views
```

---

## 🎯 Project Goals

The main goals of this project were:

* Build a complete web application from scratch
* Practice PHP and MySQL
* Understand MVC architecture
* Apply OOP concepts
* Implement the Singleton Design Pattern
* Build a custom routing system
* Understand middleware
* Implement authentication and authorization
* Work with sessions
* Build CRUD operations
* Practice AJAX and jQuery
* Work with pagination
* Improve database integration
* Write more organized and maintainable code

---

## 📸 Screenshots

Screenshots of the application can be added here:

```text
Add screenshots of:

- Home Page
- Books Page
- Book Details
- Login
- Register
- Profile
- Cart
- Orders
- Admin Dashboard
```

---

## 🔗 Links

### GitHub

[GitHub Repository](YOUR_GITHUB_REPOSITORY_LINK)

### Live Project

[Live Demo](YOUR_LIVE_PROJECT_LINK)

---

## 👨‍💻 Developer

### Ahmed Mohamed

Computer Science Student | Front-End Developer | Back-End Developer in Progress

I am currently developing my skills in backend development and working toward becoming a **Full-Stack Developer**.

---

## 🙏 Acknowledgments

This project was developed as part of my training at **SemiCodeTech Academy**.

Special thanks to:

* **Eng. Mohamed Attia** — Instructor
* **Gemy** — Mentor
* **Abdelgmen** — Mentor

Thank you for the guidance, support, and knowledge that helped me build this project and understand backend development in a more practical way.

---

## 📌 Future Improvements

Some features that can be added in future versions:

* Online payment integration
* Book reviews and ratings
* Wishlist
* Advanced search
* Email notifications
* More advanced admin statistics
* REST API
* Laravel version of the project
* Improved security
* More advanced caching

---

## ⭐ Final Note

This project represents an important step in my backend development journey.

It started as a training project, but it gave me practical experience in building a complete web application, connecting the frontend with the backend, working with databases, handling authentication, and organizing application code using **MVC and Design Patterns**.

### 🚀 More projects and more learning are coming.

**Laravel is coming! 🔥**
