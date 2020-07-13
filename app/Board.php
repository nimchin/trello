<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'boards';

    protected $fillable = ['author_id'];
}
