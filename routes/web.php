<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* topic routes */


    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'auth'], function () {

        Route::get('topics', ['as' => 'topic-list', 'uses' => 'TopicsController@index']);
        Route::get('browse_topics', ['as' => 'browse-topic-list', 'uses' => 'TopicsController@browse']);
        Route::get('topics/{topicId}', ['as' => 'topic-show', 'uses' => 'TopicsController@show']);
        Route::post('topics', ['as' => 'topic-post', 'uses' => 'TopicsController@store']);

        Route::get('subtopics/topics/{topicId}', ['as' => 'subtopic-list', 'uses' => 'SubtopicsController@index']);
        Route::get('subtopics/{subtopicId}', ['as' => 'subtopic-show', 'uses' => 'SubtopicsController@show']);
        Route::post('subtopics', ['as' => 'subtopic-post', 'uses' => 'SubtopicsController@store']);

        Route::get('articles/subtopics/{subtopicId}', ['as' => 'article-list', 'uses' => 'ArticlesController@index']);
        Route::get('articles/{articleId}', ['as' => 'article-show', 'uses' => 'ArticlesController@show']);
        Route::post('articles', ['as' => 'article-post', 'uses' => 'ArticlesController@store']);
        Route::post('select-ajax', ['as' => 'select-ajax', 'uses' => 'AjaxController@selectAjax']);

        Route::get('examples/articles/{articleId}', ['as' => 'example-list', 'uses' => 'ExamplesController@index']);
        Route::get('examples/articles-quiz/{articleId}', ['as' => 'example-quiz-list', 'uses' => 'ExamplesController@quizIndex']);
        Route::get('examples/{exampleId}', ['as' => 'example-show', 'uses' => 'ExamplesController@show']);


        Route::post('examples', ['as' => 'example-post', 'uses' => 'ExamplesController@store']);
        Route::post('examples-quiz', ['as' => 'example-option-post', 'uses' => 'ExamplesController@storeOption']);

        Route::patch('/examples/{exampleId}/review', ['as' => 'example-review', 'uses' => 'ExamplesController@review']);
        Route::patch('/examples/{exampleId}/set-answer', ['as' => 'example-set-answer', 'uses' => 'ExamplesController@setAnswer']);

        Route::patch('/examples/{exampleId}/give-answer', ['as' => 'example-give-answer', 'uses' => 'ExamplesController@giveAnswer']);
        Route::get('example-statistics', ['as' => 'example-statistics', 'uses' => 'TopicsController@statisticsExample']);
        Route::get('quiz-statistics', ['as' => 'quiz-statistics', 'uses' => 'TopicsController@statisticsQuiz']);
    });

    Auth::routes();


