<?php

namespace App\Http\Controllers;

use App\Article;
use App\Subtopic;
use App\Topics;
use App\Example;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ExamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($articleId)
    {
        //GET /examples/article/article_id

        $articleDetail = Article::getArticleById($articleId);

        $subtopicId = $articleDetail->subtopic_id;
        $subtopicDetail = Subtopic::getSubtopicById($subtopicId);

        $topicId = $articleDetail->topic_id;
        $topicDetail = Topics::getTopicById($topicId);

        $examples = Example::where(['article_id'=>$articleId,'example_status'=>'1'])->paginate(8);
        if(Article::isArticleCreator($articleId,auth()->id())){
            $examples = Example::where(['article_id'=>$articleId,'example_status'=>'1'])->paginate(8);
        }else{
            $examples = Example::where(['article_id'=>$articleId,'example_status'=>'1'])
                ->whereIn('created_by',[$articleDetail->created_by,auth()->id()])->paginate(8);
        }
        //dd(compact(['examples','articleDetail','subtopicDetail','topicDetail','subtopicId','topicId']));
        return view('layouts.pages.article-details',compact(['examples','articleDetail','subtopicDetail','topicDetail','subtopicId','topicId']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //POST /examples/create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /examples

        $this->validate(request(),[
            'hdnTopicId' => 'required',
            'hdnSubtopicId' => 'required',
            'hdnArticleId' => 'required',
            'txtExample' => 'required',
        ],[
            'txtExample.required'=>'Example is required'
        ]);

        try{
            //dd($request->all());
            $example = new Example();
            $topicId  = request('hdnTopicId');
            $subtopicId  = request('hdnSubtopicId');
            $articleId  = request('hdnArticleId');

            $creator = 0;
            if(Article::isArticleCreator($articleId,auth()->id()))
                $creator = 1;

            $example->topic_id     = request('hdnTopicId');
            $example->subtopic_id     = request('hdnSubtopicId');
            $example->article_id     = request('hdnArticleId');
            $example->example = request('txtExample');
            $example->example_status = '1';
            $example->created_by = auth()->id(); //session id
            $example->approved_by = ($creator==1) ? auth()->id() : 0;
            $example->is_approved = ($creator==1) ? '1' : '0';
            $example->seq_id = ($creator==1) ? '1' : '0';
            $example->save();

            return redirect("/examples/articles/".$articleId);

        }catch (Exception $exception){
            dd($exception);
        }
    }

    /**
     * Review a created resource by user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve($exampleId)
    {
        //POST /examples/example_id/review
    }
    /**
     * Review a created resource by user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject($exampleId)
    {
        //POST /examples/example_id/review
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($exampleId)
    {
        //GET /examples/example_id
        $articles = Example::where(['example_id'=>$exampleId,'example_status'=>'1','is_approved'=>'1'])->paginate(1);
        return view('layouts.pages.article-details',compact(['articles','exampleId']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET /examples/example_id/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request, $exampleId)
    {
        //PATCH /examples/example_id

        Example::where('example_id', '=', $exampleId)
            ->update(['is_approved' => request('status'), 'approved_by'=>auth()->id()]);

        if(request('status')== 1)
            return response()->json(['info'=>'Example was approved successfully']);
        elseif(request('status')== 2)
            return response()->json(['info'=>'Example was rejected successfully']);
        else
            return response()->json(['info'=>'Something goes wrong ...']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /examples/example_id
    }
}
