# EMERGENCY 20 HOUR SPRINT

## HOUR 0–1: LOCK THE SCOPE
Goal

Know exactly what you're building.

Create/confirm:

 Site map
 Features
 User flow
 Database entities
 Folder structure
Final MVP

Public:

 Home
 About
 Programs
 Gallery
 Get Involved
 Contact
 Volunteer form

Admin:

 Login
 Dashboard
 Programs CRUD
 Gallery CRUD
 Volunteer viewing

Do not add random features after this point.

| Requirement          | Status    |
| -------------------- | --------- |
| Problem              | ✅ Defined |
| Target users         | ✅ Defined |
| Visitor capabilities | ✅ Defined |
| Admin capabilities   | ✅ Defined |
| Core message         | ✅ Defined |
| MVP direction        | ✅ Defined |

## HOURS 1–5: FRONTEND

Build the public-facing website first.

Hour 1–2

Global structure

 Header
 Navbar
 Footer
 Responsive navigation
 CSS variables
 Typography
 Buttons
 Cards
 Forms
Hour 2–3

Home

 Hero
 About preview
 Programs preview
 Impact/statistics
 Gallery preview
 CTA
 Footer
Hour 3–4

Internal pages

 About
 Programs
 Gallery
 Get Involved
 Contact
Hour 4–5

Responsive pass

Test:

320px
375px
768px
1024px
1440px

Fix:

 Overflow
 Cards
 Images
 Navigation
 Forms
 Spacing

Checkpoint: At the end of Hour 5, you should have a convincing static website.

## HOURS 5–7: DATABASE

This needs to be simple.

Create:

my_next_level
│
├── admins
├── programs
├── gallery
├── volunteers
└── contacts
Do
 Create database
 Create tables
 Define primary keys
 Define appropriate fields
 Insert test records
 Export .sql
Checkpoint

You should be able to open phpMyAdmin and see your entire database.

HOURS 7–10: PHP BACKEND
Hour 7–8

Create:

includes/
├── database.php
├── header.php
└── footer.php

Get PHP → MySQL working.

Test:

PHP → MySQL → successful query

## HOURS 8–9: Make Programs dynamic.

MySQL
 ↓
PHP
 ↓
Programs page

### HOURS 9–10

Make:

 Gallery dynamic
 Volunteer form functional
 Contact form functional

Checkpoint: Your website is now genuinely full-stack.

Not merely a PowerPoint presentation wearing HTML.

## HOURS 10–14: ADMIN

This is the highest-risk section, so don't leave it until the final two hours.

Hour 10–11

Admin authentication:

 Login page
 Database credentials
 Password hashing
 Sessions
 Logout
 Protected pages
Hour 11–12

Dashboard:

 Sidebar
 Statistics
 Navigation
 Responsive layout
Hour 12–13

Programs:

 View
 Add
 Edit
 Delete
Hour 13–14

Gallery + volunteers:

 Gallery management
 Volunteer list
 Delete/update where needed
Checkpoint

You should be able to:

Login
 ↓
Dashboard
 ↓
Add Program
 ↓
See Program on Website
 ↓
Edit Program
 ↓
Website Updates
 ↓
Delete Program
 ↓
Program Disappears

If that works, congratulations, you have an actual application.

## HOURS 14–16: SECURITY + VALIDATION

Do the minimum responsible pass.

PHP
 Prepared statements
 Server-side validation
 Password hashing
 Session protection
 Admin access protection
Forms
 Required fields
 Email validation
 Invalid input handling
 Success messages
 Error messages
Uploads

If gallery uploads are implemented:

 Validate file type
 Validate size
 Handle upload errors
HOURS 16–17: TESTING

Don't merely stare at the website and decide it looks correct. Computers have a cruel sense of humor.

Test the public side
 Every navigation link
 Every button
 Every form
 Programs display
 Gallery displays
 Mobile menu
 Mobile layout
Test admin
 Correct login
 Incorrect login
 Logout
 Protected URL
 Create
 Read
 Update
 Delete
Test database
 Records insert
 Records update
 Records delete
 Records display

## HOURS 17–18: DOCUMENTATION

Now produce the documents.

1. Site Plan

Already mostly done.

2. Roadmap

Use the detailed roadmap, but make the 20-hour version the actual development plan.

3. User Flow

Include:

Visitor
Volunteer
Administrator
4. README

Include:

Project overview
Features
Technologies
Installation
Database setup
Folder structure
Admin access
Development status

## HOURS 18–19: UI POLISH

Only now.

Priorities:

Fix ugly spacing.
Fix responsiveness.
Fix inconsistent typography.
Fix cards.
Fix buttons.
Fix forms.
Add subtle shadows/gradients where appropriate.
Fix broken images.
Remove obvious visual bugs.

Do not redesign the entire website at Hour 18.

I know you.

You will see one card and suddenly decide the entire design system is spiritually incorrect. T_T

## HOUR 19–20: FINAL SUBMISSION CHECK
Code
 No obvious errors
 No unnecessary files
 No passwords committed
 No debugging code
 Clean folder structure
Database
 .sql file exported
 Test data works
 Database connection works
Documentation
 Site plan
 Roadmap
 User flow
 README
Presentation
 Homepage looks finished
 Navigation works
 Admin works
 Mobile works
 Forms work


| Work                |    Time |
| ------------------- | ------: |
| Scope & planning    |      1h |
| Frontend            |      4h |
| Database            |      2h |
| PHP backend         |      3h |
| Admin               |      4h |
| Security/validation |      2h |
| Testing             |      1h |
| Documentation       |      1h |
| Polish              |      1h |
| Final QA/submission |      1h |
| **Total**           | **20h** |