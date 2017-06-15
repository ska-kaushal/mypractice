<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userexample extends Model
{
    protected $table = 'userexamples';
    protected $primaryKey = 'user_example_id';

    /**
     * Get all of the subtopics for the topics.
     */
    static public function articles()
    {
        return SELF::belongsTo('\App\Article','article_id');
    }

    public function users()
    {
        return $this->hasOne('\App\User','id','created_by');
    }
}
