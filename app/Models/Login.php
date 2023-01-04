<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['admin_name','admin_phone','admin_email','admin_password'];
    protected $primaryKey = 'admin_id';
    protected $table='tbl_admin';

}
