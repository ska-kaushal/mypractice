<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subtopic;
use DB;

class AjaxController extends Controller
{
    /**
     * Show the application selectAjax.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectAjax(Request $request)
    {
        if($request->ajax()){
            $subtopicList = Subtopic::where('topic_id',$request->topicId)->pluck("subtopic_name","subtopic_id");
            $data = view('ajax-select',compact('subtopicList'))->render();
            return response()->json(['options'=>$data]);
        }
    }
}
