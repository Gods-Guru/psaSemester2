# My Next Level Site Plan

## Project Overview
My Next Level is a charity organization website that supports public information sharing and administrative content management. The site provides general information about the organization, highlights its programs, showcases gallery material, and gives visitors ways to volunteer or contact the organization.

## Project Objectives
- Build an online presence for My Next Level.
- Inform visitors about the organization�s mission and activities.
- Showcase charity programs and community initiatives.
- Display images from previous events and activities.
- Allow people to volunteer and participate.
- Provide contact points for public inquiries.
- Allow administrators to manage content and volunteer information.

## Target Users
### General Visitors
People who want to learn about the organization and its activities.

### Volunteers
People interested in joining events, programs, and community initiatives.

### Administrators
Authorized users who maintain the website�s content and manage volunteer records.

## Public Website Pages
| Page | Purpose |
| --- | --- |
| Home | Introduce the organization and highlight key information. |
| About | Share the organization�s background, mission, values, and history. |
| Programs | Display the organization�s program areas and initiatives. |
| Gallery | Showcase photos and visual updates from events and activities. |
| Get Involved | Present opportunities to volunteer, participate, or support the organization. |
| Contact | Show contact information and provide an inquiry form. |

## Home Page Components
- Navigation bar
- Logo and organization branding
- Hero section with primary and secondary calls to action
- Introduction and mission section
- Programs preview
- Impact or statistics section
- Gallery preview
- Get Involved section
- Footer with links, organization details, and contact information

## Admin Dashboard
The administrator area contains:
- Admin login
- Dashboard
- Programs management
- Gallery management
- Volunteer management

The admin area should support create, read, update, and delete actions for program and gallery information and review records submitted by volunteers and visitors.

## Technical Stack
- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL

## Database
The database may include tables for:
- admins
- programs
- gallery
- volunteers
- contacts

                    ┌───────────────┐
                    │    Visitor    │
                    └───────┬───────┘
                            │
                            ▼
                  ┌───────────────────┐
                  │  HTML/CSS/JS UI   │
                  └─────────┬─────────┘
                            │
                            ▼
                  ┌───────────────────┐
                  │       PHP         │
                  │ Backend / Logic   │
                  └─────────┬─────────┘
                            │
                            ▼
                  ┌───────────────────┐
                  │      MySQL        │
                  │     Database      │
                  └───────────────────┘

Admin
  ↓
Login
  ↓
PHP authentication
  ↓
Session
  ↓
Dashboard
  ↓
CRUD
  ↓
MySQL

1. MNL solves the organisation's problem of not being able to get volunteers, donors and a wider audience dut to their lack of internet presence. 
2. The primary target users are potential donors, volunteers and people with information about underserved communities in need of help. 
3. A normal visitor should be able to understand what the organisation is about, tell us about a community, become a sponsor to the movement, or donor, or volunteer for a particular programme(s). 
4. The administrator should be able to: 
- manage website content 
- manage donations 
- add/remove/update/delete events 
- view the website's statistics and see which events are gaining more attention 
5. Our mission, vision and goals.

## Visitor Goals

A normal visitor should be able to:

Understand what MNL is.
Learn about its mission, vision and goals.
View its programmes and events.
Volunteer for a particular programme.
Become a sponsor.
Make a donation.
Report/tell MNL about a community that needs assistance.
Learn how to contact the organisation.

## Administrator Goals

The administrator should be able to:

Manage website content.
Manage donations.
Add events.
Update events.
Remove/delete events.
View website statistics.
Monitor which events/programmes receive the most attention.
Manage relevant visitor submissions such as volunteer applications and community reports.