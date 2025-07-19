<?php

// app/Models/FormMailLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormMailLog extends Model
{
    protected $table = 'form_mail_logs'; // make sure table name is correct
    public $timestamps = false;

    protected $fillable = [
        'form_id',
        'email',
        'status',
        'error',
    ];
}
