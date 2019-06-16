<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Cve extends Eloquent {

    // Connection
    protected $connection = 'mongodb';

    // Table name
    protected $table      = 'cve';

    // The attributes that are mass assignable.
    protected $guarded = [];
}
