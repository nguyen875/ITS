# Backend Setup Guide

Follow these steps to set up and run the backend of this project.

---

## 1. Install and Configure XAMPP
- Download and install **XAMPP**.
- Start **Apache** and **MySQL** from the XAMPP Control Panel.
- Refer to `./Lab 1.1 Install XAMPP.pdf` for detailed installation instructions.
- If MySQL does not start after step 4:
  - Open **Task Manager**.
  - End any running **MySQL** processes.
  - Try starting MySQL again from XAMPP.

---

## 2. Project Setup
- Locate the directory where **XAMPP** was installed.
- Clone or move the entire project folder into **/xampp/htdocs**.
- Open a terminal and make sure the current working directory is the project folder.
---

## 3. Install Composer
- Download Composer from [getcomposer.org/download](https://getcomposer.org/download).
- Follow the installation instructions for your operating system.

---

## 4. Install Project Dependencies
- In the project root directory, run:
  ```bash
  composer install
  ```
---

## 5. Set Up the Database
- Open [phpMyAdmin](http://localhost/phpmyadmin/index.php?route=/server/sql).
- Run the SQL script ITS_DataBase_1.sql from row 1 to row 380.
- Do not import any data at this stage.

---

## 6. (Optional) Install Postman
- Postman is recommended for easy API testing.
- Download Postman from https://www.postman.com/downloads/.
- Create an account and follow the setup instructions.

---

## 7. API Documentation
- Refer to ./API_DOC.md for details on all implemented API endpoints.
- Authentication Notes:
    - For all APIs (except register and login), you must include in the HTTP header (or Headers tab in Postman):
    - Key: Authorization
    - Value: JWT token returned from the login API
- Ensure the HTTP method matches the specification in API_DOC.md.