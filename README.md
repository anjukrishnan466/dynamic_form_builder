# Installation & Setup Instructions

## 1. Clone the Repository

```bash
git clone https://github.com/your-username/dynamic-form-builder.git
cd dynamic-form-builder
```

## 2. Rename .env File

Rename `.env.example` to `.env`.

## 3. Configure .env Email & Queue Settings

Update your `.env` file with:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=anjukrishnan466@gmail.com
MAIL_PASSWORD="szak gygx tdzm lhqq"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=anjukrishnan466@gmail.com
MAIL_FROM_NAME="dynamic-form-builder"

QUEUE_CONNECTION=database
DB_DATABASE=laravel1
```
## 3a. Create Database

Create a MySQL database named `laravel1` before running migrations.  
You can use phpMyAdmin or run:

```sql
CREATE DATABASE laravel1;

```
> **Note:** Ensure your Gmail account allows app password login or "less secure apps."

## 4. Install Composer Dependencies

```bash
composer install
```

## 5. Generate Application Key

```bash
php artisan key:generate
```

## 6. Run Database Migrations

```bash
php artisan migrate
```

## 7. Update Seeder with Admin Email

Edit `database/seeders/AdminUserSeeder.php`:

```php
'email' => 'your-email@example.com', // Replace with your email
```

Then run:

```bash
php artisan db:seed
```

## 8. Start Queue Worker

To enable queued email jobs:

```bash
php artisan queue:work
```

## 9. Serve the App

```bash
php artisan serve
```

---

# Admin Panel

- **Login URL:** [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
- **Credentials:**  
  - Email: your configured email  
  - Password: password

### Admin Features

1. Create new forms with dynamic fields
2. View all forms with edit/delete
3. On form creation, an email is sent to admin using queue (check your email)
4. Track mail success/failure in `form_mail_logs` table

---

# Public User Interface

- **Browse Forms:** [http://127.0.0.1:8000/forms](http://127.0.0.1:8000/forms)
- View dynamically created forms
- Fill and submit forms

### Supported Fields

- Text, Number, Email, Textarea
- Dropdown (select), Checkbox, Radio

All fields are validated.

---

# Additional Features

## 1. Dynamic Field Support

Field types available:
- Text
- Number
- Email
- Textarea
- Dropdown
- Checkbox
- Radio

## 2. User Submission Logging

- Submissions are stored in the `form_submissions` table.
- Admin can view all submissions for each form.

## 3. View Submitted User Data (Admin)

- On the form list page, click "Saved Data" to view entries from `form_submissions` with all field labels.

---

# Email Queue and Logs

- Email on form creation is dispatched via a queued job.
- Status (success/failure) is recorded in `form_mail_logs` table:
  - `form_id`, `email`, `status`, `error`, `created_at`

---

# Developer Tips

- If queue isn't working, try:
  ```bash
  php artisan queue:restart
  php artisan queue:work
  ```
- Use Tinker to manually check logs:
  ```bash
  php artisan tinker
  >>> FormMailLog::latest()->get();
  ```

---

# Notes

- All form creation and email logic is handled via Laravel jobs and listeners.
- UI uses Bootstrap for responsiveness.
- Admin & user views are separated for clarity.