# Installation & Setup Instructions

Follow these steps to set up the project locally:
  1. Clone the Repository

git clone https://github.com/your-username/dynamic-form-builder.git
cd dynamic-form-builder

  2. Rename .env.example file as .env

 
  3. Configure .env Email & Queue Settings

Update the .env file with the following:

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

    * Make sure your Gmail account allows app password login or "less secure apps."

  4. Install Composer Dependencies

composer install

  5. Generate Application Key

php artisan key:generate

  6. Run Database Migrations

php artisan migrate

  7. Update Seeder with Admin Email

Edit database/seeders/AdminUserSeeder.php and set your email in:

'email' => 'your-email@example.com', // Replace this with your email

Then run:

php artisan db:seed

  8. Start Queue Worker

To enable queued email jobs:

php artisan queue:work

  9. Serve the App

php artisan serve

  Admin Panel
Login URL

http://127.0.0.1:8000/admin/login
Credentials (from seeder)

    Email: your configured email

    Password: password

Admin Features

     1. Create new forms with dynamic fields

     2. View all forms with edit/delete

   3.  On form creation, an email is sent to admin using queue

    4.  Track mail success/failure in form_mail_logs table

# Public User Interface

Browse available forms:

http://127.0.0.1:8000/forms

    View dynamically created forms

    Fill and submit forms

    Fields supported:

        Text, Number, Email, Textarea

        Dropdown (select), Checkbox, Radio

All fields are validated.
* Additional Features
1. Dynamic Field Support

Field types available:

<option value="text">Text</option>
<option value="number">Number</option>
<option value="email">Email</option>
<option value="textarea">Textarea</option>
<option value="select">Dropdown</option>
<option value="checkbox">Checkbox</option>
<option value="radio">Radio</option>

2. User Submission Logging

    Submissions are stored in the form_submissions table.

    Admin can view all submissions for each form.

3. View Submitted User Data (Admin)

On the form list page, click on the "Saved Data" action to:

    View each entry from form_submissions

    See all filled values with their field labels

  # Email Queue and Logs

    Email on form creation is dispatched via a queued job

    Status of mail (success/failure) is recorded in the form_mail_logs table:

        form_id, email, status, error, created_at

 # Developer Tips

    If queue isn't working, try restarting:

php artisan queue:restart
php artisan queue:work

    Use Tinker to manually check:

php artisan tinker
>>> FormMailLog::latest()->get();

# Notes

    All form creation and email-related logic is handled via Laravel jobs and listeners.

    UI is built with Bootstrap for responsiveness.

    Admin & user views are separated for clarity.