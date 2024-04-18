<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //protected $table = 'contact'; // Replace 'your_table_name' with your actual table name

    protected $fillable = ['name', 'email', 'message'];
}