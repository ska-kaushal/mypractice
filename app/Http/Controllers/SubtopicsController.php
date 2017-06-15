<?php

namespace App\Http\Controllers;

use App\Subtopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * Class SubtopicsController
 * @package App\Http\Controllers
 */
class SubtopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $topicId
     * @return \Illuminate\Http\Response
     */
    public function index($topicId)
    {
        $topicDetail = Subtopic::find($topicId)->topics()->where(['topic_status' => '1'])->first();

        if ($topicDetail->created_by == auth()->id())
            $subtopics = Subtopic::where(['topic_id' => $topicId, 'subtopic_status' => '1'])->orderby('subtopic_id','desc')->paginate(5);
        else {
            $subtopics = Subtopic::has('articles')->with('users')->where(['subtopic_status' => '1', 'subtopics.topic_id' => $topicId])->orderby('subtopic_id','desc')->paginate(5);
        }

        return view('layouts.pages.subtopics', compact(['subtopics', 'topicId', 'topicDetail']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //POST /subtopics/create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /subtopics

        $this->validate(request(), [
            'hdnTopicId' => 'required',
            'txtSubtopicName' => 'required',
            'txtSubtopicDesc' => 'required',
        ],
            [
                'txtSubtopicName.required' => 'Subtopic name is required',
                'txtSubtopicDesc.required' => 'Subopic description is required'
            ]);

        try {
            //dd($request->all());
            $subtopic = new Subtopic();
            $topicId = request('hdnTopicId');

            $subtopic->topic_id = request('hdnTopicId');
            $subtopic->subtopic_name = request('txtSubtopicName');
            $subtopic->subtopic_description = request('txtSubtopicDesc');
            $subtopic->subtopic_status = '1';
            $subtopic->created_by = auth()->id(); //session id
            $subtopic->seq_id = 1;

            $subtopic->save();
            return redirect()->back()->with('message', 'Subtopic added Successfully');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something goes wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $subtopicId
     * @return \Illuminate\Http\Response
     */
    public function show($subtopicId)
    {
        //GET /subtopics/subtopic_id
        $subtopics = Subtopic::where(['subtopic_id' => $subtopicId, 'subtopic_status' => '1'])->paginate(1);
        return view('layouts.pages.subtopics', compact(['subtopics', 'subtopicId']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET /subtopics/subtopic_id/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //PATCH /subtopic/subtopic_id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /subscription/subscription_id
    }
}
