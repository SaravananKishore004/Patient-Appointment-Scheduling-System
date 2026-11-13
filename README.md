# Patient Appointment Scheduling System

Web-based appointment booking system (DBMS course project, EGB1221).
Frontend (HTML/CSS/JavaScript) talks to a PHP + MySQL backend through a JSON API.

## Structure
```
backend/
  api/        create_, get_, get_(one), update_, delete_ appointment endpoints
  config/     db_connect.php, helpers.php
  database/   schema.sql
frontend/
  css/        style.css
  js/         api.js, booking.js, appointments.js, edit.js
  *.html      index, appointments, edit, about
```

## Run (XAMPP)
1. Start Apache and MySQL.
2. Copy the project folder to `htdocs/`.
3. Open `http://localhost/patient-appointment-scheduling-system/frontend/index.html`

The database and table are created automatically on first request (or import `backend/database/schema.sql`).

## API
| Method | Endpoint | Purpose |
|---|---|---|
| POST | `backend/api/create_appointment.php` | Create |
| GET | `backend/api/get_appointments.php` | Read all |
| GET | `backend/api/get_appointment.php?id=1` | Read one |
| POST | `backend/api/update_appointment.php` | Update |
| POST | `backend/api/delete_appointment.php` | Delete |
