# Web-Based Inventory Management with QR Code Feature

This application is an inventory management information system called **M-Stok**, designed to digitally manage and monitor stock. With the integration of *QR Code* and automation features, the application aims to improve efficiency, data accuracy, and ease of decision-making in inventory management.

---

## 🎯 Key Features

- **Product & Master Data Management**  
  Admin can perform *CRUD* (Create, Read, Update, Delete) operations on product, category, and supplier data.

- **Stock Transactions**
  - Recording incoming stock by Admin.  
  - Recording outgoing stock by Admin and Employees.

- **QR Code Integration**  
  The system automatically generates a *QR Code* for each product.  
  Users can scan the *QR Code* to speed up product identification and transaction recording.

- **Low Stock Validation**  
  The system sends an automatic *email* notification to the Admin when a product's stock reaches the predetermined minimum threshold.

- **Stock Reports**  
  Admin and Employees can view stock transaction summaries and download them in **PDF** format.

---

## 👥 User Roles

### 1. Admin
- Manage product, category, supplier, and user data.
- Record incoming and outgoing stock transactions.
- Monitor stock conditions via an interactive dashboard and low stock notifications.
- View and download stock reports.

### 2. Employee
- Record outgoing stock transactions.
- Scan *QR Codes* to simplify transaction recording.
- View and download stock reports.

---

## 📦 System Workflow

1. **Products & Categories**  
   Admin adds category data first, then products.  
   When a product is added, its *QR Code* is automatically generated.

2. **Incoming Stock Transactions**  
   Admin records products coming into the warehouse.

3. **Outgoing Stock Transactions**  
   Employees record stock reduction transactions, usually by scanning a *QR Code*.

4. **Low Stock Validation**  
   The system checks stock after outgoing transactions, and if it reaches the minimum limit, an automatic notification is sent to the Admin.

5. **Stock Reports**  
   Admin and Employees can view and download transaction history and product stock data.

---

## 🛠️ Technologies Used

- **Backend:** Laravel 12  
- **Frontend:** *Blade* (Laravel templating engine), **Bootstrap 4**  
- **Database:** MySQL  
- **QR Code:**  
  - Code generation: `SimpleSoftwareIO/simple-qrcode`  
  - Scanning: `html5-qrcode`  
- **PDF Reports:** `Laravel domPDF`
