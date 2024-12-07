<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'name_xaphuong', 'type', 'maqp'
    ];

    protected $primaryKey ='xaid';
    protected $table ='tbl_xaphuongthitran';
}
