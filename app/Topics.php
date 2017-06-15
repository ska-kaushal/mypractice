<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $table = 'topics';
    protected $primaryKey = 'topic_id';

    /**
     * Get the subtopics for the topics.
     */
    public function subtopics()
    {
        return $this->hasMany('\App\Subtopic', 'topic_id', 'topic_id');
    }

    /**
     * Get the article for the topics.
     */
    public function articles()
    {

        return $this->hasManyThrough('\App\Article', '\App\Subtopic', 'topic_id', 'subtopic_id');
    }

    public function users()
    {
        return $this->hasOne('\App\User','id','created_by');
    }
}
