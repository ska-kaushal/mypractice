<?php

namespace App\Http\Controllers;

use App\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TopicsController extends Controller
{
    /**
     * Display a listing of Topics.
     * Ex: English,Laravel,PHP
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //GET /topics
        $topics = Topics::where(['topic_status'=>'1'])->paginate(5);

        return view('layouts.pages.topics',compact('topics'));
    }

    /**
     * Show the form for creating a new topic.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //POST /topics/create
    }

    /**
     * Store a newly created topic in topics table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /topics

        $this->validate(request(),[
            'txtTopicName' => 'required',
            'txtTopicDesc' => 'required',
        ],
        [
            'txtTopicName.required' => 'Topic name is required',
            'txtTopicDesc.required' => 'Topic description is required'
        ]);

        try{
            $topic = new Topics;

            $topic->topic_name = request('txtTopicName');
            $topic->topic_description = request('txtTopicDesc');
            $topic->topic_status = '1';
            $topic->created_by = auth()->id(); //session id
            $topic->seq_id = 1;
            $topic->save();

            return redirect("/topics");

        }catch (Exception $exception){
            dd($exception);
        }

        /*

        Topics::create([
            'topic_name' => request('txtTopicName'),
            'topic_description' => request('txtTopicDesc'),
            'topic_status' => 1,
            'created_by' => 1, //session id
            'seq_id' => 1,
        ]);

        */
    }

    /**
     * NOT NEEDED BECAUSE CLICK ON TOPIC WILL REDIRECT TO LIST OF SUBTOPICS
     * Display the specified topic.
     *
     * @param  int  $topicId
     * @return \Illuminate\Http\Response
     */
    public function show($topicId)
    {
        //GET /topics/topic_id
        $topics = Topics::where(['topic_id'=>$topicId,'topic_status'=>'1'])->get();
        return view('topics',compact('topics'));
    }

    /**
     * Show the form for editing the specified topic.
     *
     * @param  int  $topicId
     * @return \Illuminate\Http\Response
     */
    public function edit($topicId)
    {
        //GET /topics/id/edit
    }

    /**
     * Update the specified topic in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $topicId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $topicId)
    {
        //PATCH /topics/id
    }

    /**
     * Remove the specified topic from storage.
     *
     * @param  int  $topicId
     * @return \Illuminate\Http\Response
     */
    public function destroy($topicId)
    {
        //DELETE /topics/id
    }
}
