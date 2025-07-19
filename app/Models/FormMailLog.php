<?php

// app/Models/FormMailLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormMailLog extends Model
{
    protected $table = 'form_mail_logs'; // make sure table name is correct
    public $timestamps = true;
    protected $casts = [
        'error' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'form_id',
        'email',
        'status',
        'error',
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
