<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtopic extends Model
{
    //
    static public function getActiveSubtopics(){

        return Subtopic::where(['subtopic_status'=>'1'])
            ->orderBy('seq_id', 'asc')->pluck('subtopic_name', 'subtopic_id');
    }
    static public function getSubtopicById($subtopicId){

        return Subtopic::where(['subtopic_status'=>'1','subtopic_id'=>$subtopicId])
            ->orderBy('seq_id', 'asc')->first();
    }
}
