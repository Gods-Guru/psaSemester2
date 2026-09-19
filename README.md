# My Next Level

My Next Level is a full-stack charity organization web application developed as a school software engineering project.

The application provides a public-facing website where visitors can learn about the organization, explore its programs and activities, view its gallery, get involved, and contact the organization.

It also includes a private administration system for managing website content and volunteer information.

## Problem Statement

My Next Level (MNL) solves the organisation's lack of online presence, which currently limits its ability to reach and engage:

Potential volunteers
Donors and sponsors
People who know about underserved communities requiring assistance
A wider audience that may support or participate in its mission

# Target Users

MNL has three primary user groups:

| User                          | Main Goal                                                              |
| ----------------------------- | ---------------------------------------------------------------------- |
| **Potential Donors/Sponsors** | Understand the organisation and financially support its work           |
| **Potential Volunteers**      | Discover programmes and volunteer for specific opportunities           |
| **Community Informants**      | Tell the organisation about underserved communities that may need help |

There is also a fourth system user:

Administrator → manages the platform and organisation's online content.

## Core Message

The website's central communication should be: MNL's mission, vision and goals, and how people can participate in achieving them.

---

## Features

### Public Website

- Responsive home page
- About page
- Programs page
- Gallery page
- Get Involved page
- Contact page
- Volunteer registration
- Interactive user interface
- Responsive design for different screen sizes

### Admin Dashboard

- Secure administrator login
- Dashboard
- Program management
- Gallery management
- Volunteer management
- CRUD operations
- Session-based authentication

---

## Technology Stack

### Frontend

- HTML5
- CSS3
- JavaScript

### Backend

- PHP

### Database

- MySQL

### Development Tools

- Visual Studio Code
- Git
- GitHub
- XAMPP

---

## Project Structure

```text
my-next-level/
│
├── index.php
│
├── pages/
│   ├── about.php
│   ├── programs.php
│   ├── gallery.php
│   ├── get-involved.php
│   └── contact.php
│
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   ├── programs.php
│   ├── gallery.php
│   ├── volunteers.php
│   └── logout.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── navigation.php
│   └── database.php
│
├── database/
│   └── my_next_level.sql
│
└── README.md


## Database

The application uses MySQL for storing and managing system data.

Potential database tables include:

- admins
- programs
- events
- volunteers
- donations
- sponsors
- community_reports
- contacts

### Installation

1. Clone the Repository
git clone <repository-url>

2. Move the Project

Move the project folder into the XAMPP htdocs directory.

Example:

C:/xampp/htdocs/my-next-level
3. Start XAMPP

Start:

Apache
MySQL

from the XAMPP Control Panel.

4. Create the Database

Open phpMyAdmin and create a database named:

my_next_level

Import the SQL file:

database/my_next_level.sql

5. Configure Database Connection

Update the database connection file with the appropriate credentials.

Example:

$host = "localhost";
$username = "root";
$password = "";
$database = "my_next_level";
6. Run the Application

Open:

http://localhost/my-next-level/
Admin Access

The administrator interface can be accessed through:

http://localhost/my-next-level/admin/

Administrators must authenticate before accessing the dashboard.

Development Roadmap
 Project planning
 UI/UX design
 Frontend development
 Database implementation
 PHP backend
 Admin authentication
 Admin dashboard
 CRUD functionality
 Testing
 Deployment
Security Considerations

### The application should implement:

Password hashing
Session-based authentication
Input validation
Prepared SQL statements
Access control for admin pages
Server-side validation
Protection against SQL injection
Protection against unauthorized administrative access
Project Goals

### The project demonstrates practical understanding of:

Frontend web development
Backend development
Database management
CRUD operations
Authentication
Responsive web design
Full-stack application architecture

## License

This project was developed for educational purposes as a school software engineering project.