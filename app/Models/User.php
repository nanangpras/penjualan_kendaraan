<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $collection = 'users';
    protected $primaryKey = 'id';
    protected $connection = 'mongodb';
}
