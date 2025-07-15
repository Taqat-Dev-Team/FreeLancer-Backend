<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    protected $fillable = ['title','name', 'email', 'phone', 'message', 'status', 'read_at'];

    public function reply():HasOne
    {
        return $this->hasOne(ContactReplay::class);
    }

}
