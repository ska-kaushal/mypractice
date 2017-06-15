<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'article_id';


    /**
     * Get the examples for the article.
     */
    public function examples()
    {
        return $this->hasMany('\App\Example','article_id');
    }

    /**
     * Get the subtopic from the article.
     */
    public function subtopics()
    {
        return $this->belongsTo('\App\Subtopic','subtopic_id');
    }

    /**
     * Get the topic from the article.
     */
    public function topics()
    {
        return $this->belongsTo('\App\Topics','topic_id');
    }

    public function users()
    {
        return $this->hasOne('\App\User','id','created_by');
    }

    static public function isArticleCreator($articleId,$userId){

        return Article::where(['article_status'=>'1','article_id'=>$articleId,'created_by'=>$userId])
            ->orderBy('seq_id', 'asc')->first();
    }
}
