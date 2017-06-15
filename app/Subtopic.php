<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{

    protected $table = 'subtopics';
    protected $primaryKey = 'subtopic_id';

    /**
     * Get the topic from the subtopics.
     */
    public function topics(){

        return $this->belongsTo('\App\Topics','topic_id');
    }

    /**
     * Get the article for the subtopics.
     */
    public function articles()
    {
        return $this->hasMany('\App\Article','subtopic_id');
    }

    public function users()
    {
        return $this->hasOne('\App\User','id','created_by');
    }
}
