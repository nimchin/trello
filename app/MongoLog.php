<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class MongoLog extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'crud_logs';

    protected $fillable = ['crud_type', 'entity_type', 'entity_id', 'message', 'author_id', 'created_at'];
}
