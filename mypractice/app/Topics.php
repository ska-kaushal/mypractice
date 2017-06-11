<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    //
    static public function getActiveTopics(){

        return Topics::where(['topic_status'=>'1'])
            ->orderBy('seq_id', 'asc')->pluck('topic_name', 'topic_id');
    }
    static public function getTopicById($topicId){

        return Topics::select('topic_id', 'topic_name', 'topic_description','created_by')->where(['topic_status'=>'1','topic_id'=>$topicId])
            ->orderBy('seq_id', 'asc')->first();
    }
}
