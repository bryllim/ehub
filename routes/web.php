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

Route::get('/', ['middleware' => 'guest', function()
{
    return view('auth.login');
}]);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/servicerequests', 'RequestController@index')->name('servicerequests');
    Route::get('/newRequest', 'RequestController@newRequest')->name('newRequest');
    
    Route::post('/newPost', 'PostController@newPost')->name('newPost');
    Route::post('/newComment', 'CommentController@newComment')->name('newComment');
    Route::post('/fetchComments', 'CommentController@fetchComments')->name('fetchComments');
    
    Route::post('/newAcknowledgement', 'AcknowledgementController@newAcknowledgement')->name('newAcknowledgement');
    Route::post('/fetchAcknowledgement', 'AcknowledgementController@fetchAcknowledgement')->name('fetchAcknowledgement');

    Route::post('/storeRequest', 'RequestController@storeRequest')->name('storeRequest');

    //Realtime Comment Broadcasting
    Route::get('/broadcastComment/{post_id}', function($post_id){
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
          );
          $pusher = new Pusher\Pusher(
            '378b727ac032138844eb',
            '4e22ed055b9e20179c93',
            '956675',
            $options
          );
        
          $data['message'] = $post_id;
          $pusher->trigger('comment-channel', 'new-comment', $data);
    });
    //Realtime Acknowledgement Broadcasting
    Route::get('/broadcastAcknowledgement/{post_id}/{number}', function($post_id, $number){
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
          );
          $pusher = new Pusher\Pusher(
            '378b727ac032138844eb',
            '4e22ed055b9e20179c93',
            '956675',
            $options
          );
        
          $data['message'] = $post_id;
          $data['number'] = $number;
          $pusher->trigger('comment-channel', 'new-acknowledgement', $data);
    });
    
});
