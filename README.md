# PointOfSaleSystem
📦 POS System (PHP + MySQL) This is a web-based Point of Sale (POS) system built using PHP, MySQL, and Bootstrap. The project supports role-based login functionality for Admin and regular Users, and includes modules for managing inventory and processing sales. It is designed for small to medium-sized businesses to manage daily transactions and stock in a simple, user-friendly way.

🔑 Features

1)User Authentication: Secure login system with role validation (Admin / User) using PHP Sessions.

2) Role-Based Dashboard Access

  i) Admins are redirected to the admin dashboard.
  
  ii) Users are redirected to the POS sales interface.

3) Responsive UI: Styled using Bootstrap and integrated with SweetAlert2 and Toastr for dynamic feedback.

5) Modular Structure: Organized file system with clear separation of UI and database interaction (ui/, config/, plugins/ folders).

🚀 Technologies Used

Frontend: HTML5, CSS3, Bootstrap 4, Font Awesome

Backend: PHP 7+, MySQL (PDO for DB interaction)

Libraries: SweetAlert2, Toastr, jQuery

⚙️ How to Run
Clone the repository

Import the provided SQL file into your MySQL server

Set up the database connection in connectdb.php

Start the project on a local server (XAMPP/LAMP/WAMP)

Login using default Admin/User credentials (defined in tbl_user)
