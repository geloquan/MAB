<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TableModel extends Model
{
    protected $fillable = ['name'];

    public static function generateRandomName()
    {
        return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 10);
    }
}
