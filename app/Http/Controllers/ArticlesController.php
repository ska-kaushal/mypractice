<?php

namespace App\Http\Controllers;

use App\Article;
use App\Subtopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mockery\Exception;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subtopicId)
    {
        //GET /articles/subtopics/topics/subtopic_id

        $articles = Article::with('users')->where(['subtopic_id'=>$subtopicId,'article_status'=>'1','is_approved'=>'1'])->orderby('article_id','desc')->paginate(5);
        $topicDetail = Subtopic::find($subtopicId)->topics()->where(['topic_status'=>'1'])->first();
        $subtopicDetail = Subtopic::where(['subtopic_id'=>$subtopicId])->first();
        $topicId = $subtopicDetail->topic_id;

        if($subtopicDetail->created_by == auth()->id())
            $articles = Article::where(['subtopic_id'=>$subtopicId,'article_status'=>'1'])->orderby('article_id','desc')->paginate(5);
        else{
            $articles = Article::has('examples')->where(['article_status'=>'1','subtopic_id'=>$subtopicId])->orderby('article_id','desc')->paginate(5);
        }

        return view('layouts.pages.articles',compact(['articles','topicId','subtopicId','topicDetail','subtopicDetail']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //POST /articles/create
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /articles

        $this->validate(request(),[
            'hdnTopicId' => 'required',
            'hdnSubtopicId' => 'required',
            'txtArticleName' => 'required',
            'txtArticleDesc' => 'required',
        ],
        [
            'txtArticleName.required' => 'Article name is required',
            'txtArticleDesc.required' => 'Article description is required'
        ]);

        try{
            //dd($request->all());
            $article = new Article();
            $topicId  = request('hdnTopicId');
            $subtopicId  = request('hdnSubtopicId');

            $article->topic_id     = request('hdnTopicId');
            $article->subtopic_id     = request('hdnSubtopicId');
            $article->article_name = request('txtArticleName');
            $article->article_description = request('txtArticleDesc');
            $article->article_status = '1';
            $article->created_by = auth()->id(); //session id
            $article->approved_by = 1;
            $article->is_approved = '1';
            $article->seq_id = 1;
            $article->save();

            return redirect()->back()->with('message', 'Article added Successfully');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something goes wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $articleId
     * @return \Illuminate\Http\Response
     */
    public function show($articleId)
    {
        //GET /articles/article_id
        $articles = Article::where(['article_id'=>$articleId,'article_status'=>'1','is_approved'=>'1'])->paginate(1);
        return view('layouts.pages.articles',compact(['articles','articleId']));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET /articles/article_id/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //PATCH /articles/article_id
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /articles/article_id
    }
}
