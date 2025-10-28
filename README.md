# 🚀 PW_pe2

This is **Practical Assignment II for the Web Programming course (PW)**, a web application to manage **users** and **activities**, developed with PHP, MySQL, and JavaScript.

---

## 🗂 Structure and Key Concepts

- ✅ Use of **ActiveRecord** (`/models/ActiveRecord.php`) to centralize CRUD operations.  
- Each database table has its **corresponding class** extending `ActiveRecord`.  
- Main tables:  
  - `usuario` → user and role management.  
  - `actividades` → activity and category management.

---

## 🛠 Features

### 👤 User Management
- User registration with **password hashing**.  
- Login and logout functionality.  
- Differentiation between **normal users** and **administrators**.

### 🏢 Activity Administration
- Create, edit, and delete activities.  
- **Dynamic pagination** for activities.  
- Filtering by **sport** or **modality**.  
- Exclusive access for **administrators**.

### 🖥 Interface and Validation
- Form validation using **JavaScript**.  
- Dynamic activity carousel with **circular navigation**.  
- Templates for alerts and access control.

---

## 💻 Technologies Used

- PHP (MVC and ActiveRecord)  
- MySQL  
- JavaScript (validation and carousel)  
- HTML / CSS / SCSS  

---

## 🎓 What I Learned

- Simplifying database operations using **ActiveRecord**.  
- Managing **sessions** and user roles.  
- Form validation with **JavaScript**.  
- Creating dynamic interfaces with **carousel and filters**.  
- Pagination of data and **administrator access control**.
