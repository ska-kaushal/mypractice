<?php

namespace App\Http\Controllers;

use App\Topics;
use App\Userexample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;
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
        $topics = Topics::where(['topic_status' => '1', 'created_by' => auth()->id()])->orderby('topic_id','desc')->paginate(5);
        return view('layouts.pages.topics', compact('topics'));
    }

    public function browse()
    {
        //GET /topics
        $browseTopics = Topics::has('articles')->with('users')->where('topics.created_by', '!=', auth()->id())->orderby('topic_id','desc')->paginate(5);
        return view('layouts.pages.browse-topics', compact('browseTopics'));
    }

    public function statistics(){

        return view('layouts.pages.statistics');
    }

    public function statisticsExample()
    {
        //GET /topics
        $exampleStat = DB::table('userexamples')
            ->select(DB::raw('count(*) as total'), 'is_approved')
            ->where(['example_type'=>'0'])
            ->whereNull('example_id')
            ->groupBy('is_approved')
            ->orderBy('is_approved')
            ->pluck('total');

        if(count($exampleStat) > 0){

            $rejectReview    = $exampleStat[0];
            $approveReview   = $exampleStat[1];
            $pendingReview  = $exampleStat[2];

            $totalReview = (integer)($rejectReview + $approveReview + $pendingReview);

            $rejectPer  = ($rejectReview * 100)/ $totalReview;
            $approvePer = ($approveReview * 100)/ $totalReview;
            $pendingPer = ($pendingReview * 100)/ $totalReview;

            $lava = new Lavacharts; // See note below for Laravel

            $reasons = $lava->DataTable();

            $reasons->addStringColumn('Example')
                ->addNumberColumn('Percent')
                ->addRow(['Approved Request', $approvePer])
                ->addRow(['Rejected Request', $rejectPer])
                ->addRow(['Pending Request', $pendingPer]);

            $lava->PieChart('Example Review', $reasons, [
                'title'  => 'Example Review',
                'is3D'   => false,
                'slices' => [
                    ['offset' => 0.0],
                    ['offset' => 0.0]
                ]
            ]);

            echo $lava->render('PieChart', 'Example Review', 'chart-div');
        }
         return view()->make('layouts.pages.example-statistics');
    }

    public function statisticsQuiz()
    {
        //GET /topics
        $quizStat = DB::table('userexamples')
            ->select(DB::raw('count(*) as total'), 'examples.is_answer')
            ->leftJoin('examples', ['userexamples.example_id' => 'examples.example_id'])
            ->where(['userexamples.example_type'=>'1','examples.example_type'=>'1'])
            ->whereNotNull('userexamples.example_id')
            ->groupBy('examples.is_answer')
            ->orderBy('examples.is_answer')
            ->pluck('total');

        if(count($quizStat) > 0){
            $wrong = $quizStat[0];
            $correct = $quizStat[1];
            $total = (integer)$wrong+$correct;

            $wrongPer = ($wrong * 100)/ $total;
            $correctPer = ($correct * 100)/ $total;

            $lava = new Lavacharts; // See note below for Laravel

            $reasons = $lava->DataTable();

            $reasons->addStringColumn('Quiz')
                ->addNumberColumn('Percent')
                ->addRow(['Correct Answer', $correctPer])
                ->addRow(['Wrong Answer', $wrongPer]);

            $lava->PieChart('Quiz Review', $reasons, [
                'title'  => 'Quiz Review',
                'is3D'   => false,
                'slices' => [
                    ['offset' => 0.0]
                ]
            ]);

            echo $lava->render('PieChart', 'Quiz Review', 'chart-div-2');
        }

         return view()->make('layouts.pages.quiz-statistics');

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //POST /topics

        $this->validate(request(), [
            'txtTopicName' => 'required',
            'txtTopicDesc' => 'required',
        ],
            [
                'txtTopicName.required' => 'Topic name is required',
                'txtTopicDesc.required' => 'Topic description is required'
            ]);

        try {
            $topic = new Topics;

            $topic->topic_name = request('txtTopicName');
            $topic->topic_description = request('txtTopicDesc');
            $topic->topic_status = '1';
            $topic->created_by = auth()->id(); //session id
            $topic->seq_id = 1;
            $topic->save();

            return redirect()->back()->with('message', 'Topic added Successfully');

        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Something goes wrong');
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
     * @param  int $topicId
     * @return \Illuminate\Http\Response
     */
    public function show($topicId)
    {
        //GET /topics/topic_id
        $topics = Topics::where(['topic_id' => $topicId, 'topic_status' => '1'])->get();
        return view('topics', compact('topics'));
    }

    /**
     * Show the form for editing the specified topic.
     *
     * @param  int $topicId
     * @return \Illuminate\Http\Response
     */
    public function edit($topicId)
    {
        //GET /topics/id/edit
    }

    /**
     * Update the specified topic in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $topicId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $topicId)
    {
        //PATCH /topics/id
    }

    /**
     * Remove the specified topic from storage.
     *
     * @param  int $topicId
     * @return \Illuminate\Http\Response
     */
    public function destroy($topicId)
    {
        //DELETE /topics/id
    }
}
