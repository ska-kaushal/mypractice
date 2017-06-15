<?php

namespace App\Http\Controllers;

use App\Article;
use App\Example;
use App\Subtopic;
use App\Userexample;
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

        $subtopicDetail = Article::find($articleId)->subtopics()->where(['subtopic_status' => '1'])->first();
        $subtopicId = $subtopicDetail->subtopic_id;

        $topicDetail  = Subtopic::find($subtopicId)->topics()->where(['topic_status' => '1'])->first();
        $topicId = $topicDetail->topic_id;

        $articleDetail  = Article::where(['article_id'=>$articleId,'article_status' => '1'])->first();

        $examples       = Example::where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '0'])->orderby('example_id','desc')->paginate(8);

        if (Article::isArticleCreator($articleId, auth()->id())) {
            $userExamples   = Userexample::with('users')->where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '0'])->orderby('user_example_id','desc')->paginate(8);
        } else {
            $userExamples = Userexample::where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '0','created_by' => auth()->id()])->orderby('user_example_id','desc')->paginate(6);
        }
        return view('layouts.pages.article-details', compact(['examples', 'userExamples', 'articleDetail', 'subtopicDetail', 'topicDetail', 'subtopicId', 'topicId']));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function quizIndex($articleId)
    {
        //GET /examples/article/article_id

        $subtopicDetail = Article::find($articleId)->subtopics()->where(['subtopic_status' => '1'])->first();
        $subtopicId = $subtopicDetail->subtopic_id;

        $topicDetail  = Subtopic::find($subtopicId)->topics()->where(['topic_status' => '1'])->first();
        $topicId = $topicDetail->topic_id;

        $articleDetail  = Article::where(['article_id'=>$articleId,'article_status' => '1'])->first();

        $examples       = Example::where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '1'])->orderby('example_id','asc')->paginate(8);

        if (Article::isArticleCreator($articleId, auth()->id())) {
            $userExamples = Userexample::with('users')->where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '1'])->orderby('user_example_id','desc')
                ->paginate(8);
        } else {
            $userExamples = Userexample::where(['article_id' => $articleId, 'example_status' => '1', 'example_type' => '1'])
                ->whereIn('created_by', [auth()->id()])->orderby('user_example_id','desc')->first();
        }


        return view('layouts.pages.article-quiz-details', compact(['examples', 'userExamples', 'articleDetail', 'subtopicDetail', 'topicDetail', 'subtopicId', 'topicId']));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /examples

        $this->validate(request(), [
            'hdnTopicId' => 'required',
            'hdnSubtopicId' => 'required',
            'hdnArticleId' => 'required',
            'txtExample' => 'required',
        ], [
            'txtExample.required' => 'Example is required'
        ]);

        try {
            $topicId = request('hdnTopicId');
            $subtopicId = request('hdnSubtopicId');
            $articleId = request('hdnArticleId');

            if (Article::isArticleCreator($articleId, auth()->id())) {
                //dd($request->all());
                $example = new Example();

                $example->topic_id = request('hdnTopicId');
                $example->subtopic_id = request('hdnSubtopicId');
                $example->article_id = request('hdnArticleId');
                $example->example = request('txtExample');
                $example->example_status = '1';
                $example->created_by = auth()->id(); //session id
                $example->approved_by = auth()->id();
                $example->is_approved = '1';
                $example->seq_id = '1';
                $example->save();

            } else {
                //dd($request->all());
                $example = new Userexample();

                $example->topic_id = request('hdnTopicId');
                $example->subtopic_id = request('hdnSubtopicId');
                $example->article_id = request('hdnArticleId');
                $example->example = request('txtExample');
                $example->example_status = '1';
                $example->created_by = auth()->id(); //session id
                $example->approved_by = 0;
                $example->is_approved = '0';
                $example->seq_id = '0';
                $example->save();
            }

            return redirect()->back()->with('message', 'Your example added Successfully');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something goes wrong');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeOption(Request $request)
    {
        //POST /examples

        $this->validate(request(), [
            'hdnTopicId' => 'required',
            'hdnSubtopicId' => 'required',
            'hdnArticleId' => 'required',
            'txtExample' => 'required',
        ], [
            'txtExample.required' => 'Example is required'
        ]);

        try {
            $topicId = request('hdnTopicId');
            $subtopicId = request('hdnSubtopicId');
            $articleId = request('hdnArticleId');

            if (Article::isArticleCreator($articleId, auth()->id())) {
                //dd($request->all());
                $example = new Example();

                $example->topic_id = request('hdnTopicId');
                $example->subtopic_id = request('hdnSubtopicId');
                $example->article_id = request('hdnArticleId');
                $example->example = request('txtExample');
                $example->example_status = '1';
                $example->is_answer = '0';
                $example->example_type = '1';
                $example->created_by = auth()->id(); //session id
                $example->approved_by = auth()->id();
                $example->is_approved = '1';
                $example->seq_id = '1';
                $example->save();

            }
            return redirect()->back()->with('message', 'Your option added Successfully');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something goes wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $exampleId
     * @return \Illuminate\Http\Response
     */
    public function show($exampleId)
    {
        //GET /examples/example_id
        $articles = Example::where(['example_id' => $exampleId, 'example_status' => '1', 'is_approved' => '1'])->paginate(1);
        return view('layouts.pages.article-details', compact(['articles', 'exampleId']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //GET /examples/example_id/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function review(Request $request, $exampleId)
    {
        //PATCH /examples/example_id

        Userexample::where('user_example_id', '=', $exampleId)
            ->update(['is_approved' => request('status'), 'approved_by' => auth()->id()]);

        if (request('status') == 1)
            return response()->json(['info' => 'Example was approved successfully']);
        elseif (request('status') == 2)
            return response()->json(['info' => 'Example was rejected successfully']);
        else
            return response()->json(['info' => 'Something goes wrong ...']);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function setAnswer(Request $request, $exampleId)
    {
        //PATCH /examples/example_id

        $setAnswer = Example::where(['example_id' => $exampleId, 'example_type' => '1'])
            ->update(['is_answer' => '1', 'is_approved' => '1', 'approved_by' => auth()->id()]);

        if ($setAnswer)
            return response()->json(['info' => 'Answer is set successfully']);
        else
            return response()->json(['info' => 'Something goes wrong ...']);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function giveAnswer(Request $request, $exampleId)
    {
        //PATCH /examples/example_id

        $exampleDetail = Example::where(['example_id' => $exampleId])->first();

        if ($exampleDetail) {
            $example = new Userexample();
            $example->topic_id = $exampleDetail->topic_id;
            $example->subtopic_id = $exampleDetail->subtopic_id;
            $example->article_id = $exampleDetail->article_id;
            $example->example_id = $exampleId;
            $example->example_type = $exampleDetail->example_type;
            $example->example_status = '1';
            $example->created_by = auth()->id(); //session id
            $example->approved_by = 0;
            $example->is_approved = '0';
            $example->seq_id = '0';

            $example->save();

            if ($exampleDetail->is_answer == '1') {
                return response()->json(['resp' => 'yes']);
            } else {
                return response()->json(['resp' => 'no']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /examples/example_id
    }
}
