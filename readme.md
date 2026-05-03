# Mawzoon DBMS System

![Mawzoon logo](assets/images/Mawzoon%20Logo.png)

A full-stack database-driven management system developed for the COSC312 DBMS project.  
The system simulates a catering/event data management platform with full CRUD operations, relational integrity, triggers, and views.


---

## 📌 Overview

Mawzoon is designed to act as a **centralized control system** where users can manage:

- Customers
- Orders
- Payments
- Inventory
- Menu Items
- Events
- Staff (view-only)

The system ensures that users **do not need to directly interact with the database**, as all operations are handled through the frontend.

---

## 🧱 System Architecture

The system follows a layered database design:

### 1. Frontend Layer
Handles user interaction:
- PHP-based pages
- CRUD operations
- Dashboard with summarized data

### 2. Database Layer
MySQL database with:
- Relational tables
- Foreign keys
- Constraints

### 3. Logic Layer
Handled internally using:
- Triggers (automation)
- Junction tables (relationships)
- Views (data abstraction)

---

## 🗃️ Database Components

### Core Tables (User-Facing)
- CUSTOMER
- ORDERS
- PAYMENT
- INVENTORY
- MENU_ITEM
- EVENTS
- STAFF

### Relationship Tables (Internal Use)
- CONTAIN (Order ↔ Items)
- PLACES (Customer ↔ Order)
- HOSTS (Event ↔ Order)
- ITEM_USES (Menu Item ↔ Inventory)

### Additional Tables (For extensibility)
- DELIVERY
- ASSIGNED_TO
- FEATURES
- USES

These are included for **future scalability** and are not fully exposed in the frontend.

---

## ⚙️ Features Implemented

### CRUD Operations
- Customers (Create, View, Edit)
- Orders (Create, View, Edit, Delete)
- Menu Items (Full CRUD)
- Events (Create, View, Edit)

### Transactions & Relationships
- Orders linked to Customers and Events
- Orders contain multiple Menu Items
- Payments linked to Orders

### Triggers (Automation)
- Automatic inventory reduction when orders are placed
- Automatic updates to order totals
- Status updates after payment

### Views
- Order_Details_View
- Inventory_Status_View
- Event_Menu_View

Used for:
- Dashboard previews
- Simplified querying
- Reporting

### Authentication
- Login & registration system
- Session-based access control
- Protection against unauthorized access

---

## 🖥️ Dashboard

The dashboard provides:
- Key statistics (orders, customers, inventory alerts)
- Recent orders preview
- Low stock alerts
- Event menu preview

This allows quick access to important system data.

---

## 🚀 How to Run the Project (Localhost)

### Requirements
- XAMPP / WAMP / MAMP (Apache + MySQL)
- PHP 8+
- Web browser

---

### 1. Clone / Copy Project

Place the project folder inside:


htdocs/mawzoon_frontend


---

### 2. Import Database

1. Open phpMyAdmin  
2. Create a new database:


mawzoon_dbms


3. Import the provided `.sql` file

---

### 3. Configure Database Connection

Open:


includes/db.php


Update credentials if needed:

```php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mawzoon_dbms";
```
4. Run the System

Start Apache and MySQL, then go to:
```
http://localhost/mawzoon_frontend/ 
```
---
### 5. Login

Use an existing account or register a new user using the registration page.

---

## 🔒 Security Considerations

- Prepared statements used to prevent SQL injection  
- Session-based authentication  
- Restricted access to protected pages  
- Cache-control headers implemented  

---

## 🧠 Design Decisions

- Staff is view-only → requires admin-level control  
- Orders are deletable → allows operational flexibility  
- Customers are not deletable → preserves historical data integrity  
- Payments are append-only → ensures financial consistency  

---

## 📈 Future Improvements

The system is designed to be extendable. Possible enhancements include:

- Role-based access control (Admin vs Employee)  
- Full delivery management system  
- Staff assignment system (`assigned_to` table)  
- Inventory restocking automation  
- Advanced analytics dashboard  
- API integration  
- UI/UX improvements (responsive design, charts)  

---

## 🧪 Limitations

- Some tables are not fully exposed in the frontend  
- No role-based permissions implemented  
- Limited validation on certain inputs  
- No real-time updates (no AJAX)  

---

## 👨‍💻 Authors

- Yousif Alansari  
- Rashid Bomtaia  

COSC312 – Design and Usage of Database
2026  

---

## 📌 Notes

This project demonstrates:

- Relational database design  
- Normalization and integrity constraints  
- Trigger-based automation  
- View-based abstraction  
- Full-stack database interaction  

## 🤖 AI Assistance Disclosure

This project was developed with the assistance of AI-based tools (e.g., ChatGPT) for tasks such as:

- Code debugging and troubleshooting  
- Refining structure and organization  
- UI/UX improvement suggestions  
- General development guidance  

All core system design, database schema, and implementation decisions were developed and validated by the authors.