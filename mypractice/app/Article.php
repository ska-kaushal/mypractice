<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    static public function getArticleById($articleId){

        return Article::where(['article_status'=>'1','article_id'=>$articleId])
            ->orderBy('seq_id', 'asc')->first();
    }
    static public function isArticleCreator($articleId,$userId){

        return Article::where(['article_status'=>'1','article_id'=>$articleId,'created_by'=>$userId])
            ->orderBy('seq_id', 'asc')->first();
    }
}
