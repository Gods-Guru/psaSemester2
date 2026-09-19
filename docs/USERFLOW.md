### USER FLOW FOR NEXTLEVEL.COM ###

START
  ↓
Home Page
  ↓
Explore Website
  ↓
 ┌────────────┬────────────┬────────────┐
 ↓            ↓            ↓            ↓
About       Programs     Gallery    Get Involved
 ↓            ↓            ↓            ↓
Learn       View          View       Volunteer /
about       initiatives   activities  Participate
                             
                 ↓
              Contact
                 ↓
          Submit Message
                 ↓
                END

Visitor Journey

Home → About

Visitor learns about the organization.

Home → Programs

Visitor views current and previous initiatives.

Home → Gallery

Visitor views photographs of activities.

Home → Get Involved

Visitor chooses how to participate.

Get Involved → Volunteer Form

Visitor submits their information.

Home → Contact

Visitor accesses contact information or submits an inquiry.

Home
 ↓
Get Involved
 ↓
Volunteer
 ↓
Volunteer Form
 ↓
Enter Information
 ↓
Validate Form
 ↓
Is information valid?
 ├── NO → Display Error → Correct Information
 │
 └── YES
       ↓
   Submit Form
       ↓
 Save to MySQL
       ↓
 Confirmation
       ↓
      END

/admin
   ↓
Login
   ↓
Enter Credentials
   ↓
Are credentials valid?
   ├── NO → Error Message → Login Again
   │
   └── YES
          ↓
      Dashboard
          ↓
 ┌────────┼───────────┐
 ↓        ↓           ↓
Gallery  Programs  Volunteers
 ↓        ↓           ↓
Manage   Manage     Review
Images   Programs   Volunteers
 ↓        ↓           ↓
CRUD     CRUD       Manage
          ↓
       Logout
          ↓
         END

