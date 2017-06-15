<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $table = 'examples';
    protected $primaryKey = 'example_id';

    /**
     * Get the article from the example.
     */
    public function articles()
    {
        return $this->belongsTo('\App\Article','article_id');
    }

    /**
    * Get the subtopic from the example.
    */
    public function subtopics()
    {
        return $this->belongsTo('\App\Subtopic','subtopic_id');
    }

    /**
     * Get the topic from the example.
     */
    public function topics()
    {
        return $this->belongsTo('\App\Topics','topic_id');
    }

    public function users()
    {
        return $this->hasOne('\App\User','id','created_by');
    }
}
