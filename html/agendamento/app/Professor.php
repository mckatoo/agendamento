<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    use SoftDeletes;
    protected $table = 'professores';

    protected $fillable = ['professor'];

    protected $dates = 'deleted_at';

}
