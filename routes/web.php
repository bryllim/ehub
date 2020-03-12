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
    Route::get('/changepassword', 'HomeController@changepassword')->name('changepassword');
    Route::get('/servicerequests', 'RequestController@index')->name('servicerequests');
    Route::get('/newRequest', 'RequestController@newRequest')->name('newRequest');
    Route::get('/request/{id}', 'RequestController@viewRequest')->name('viewRequest');
    Route::get('/accept/{id}', 'RequestController@accept')->name('accept');
    Route::get('/decline/{id}', 'RequestController@decline')->name('decline');
    Route::get('/complete/{id}', 'RequestController@complete')->name('complete');
    Route::get('/cancel/{id}', 'RequestController@cancel')->name('cancel');
    Route::get('/delete/{id}', 'RequestController@delete')->name('delete');
    
    Route::post('/passwordchange', 'HomeController@passwordchange')->name('passwordchange');

    Route::post('/newRemark', 'RemarkController@newRemark')->name('newRemark');
    
    Route::post('/newPost', 'PostController@newPost')->name('newPost');
    Route::post('/newComment', 'CommentController@newComment')->name('newComment');
    Route::post('/fetchComments', 'CommentController@fetchComments')->name('fetchComments');
    
    Route::post('/newAcknowledgement', 'AcknowledgementController@newAcknowledgement')->name('newAcknowledgement');
    Route::post('/fetchAcknowledgement', 'AcknowledgementController@fetchAcknowledgement')->name('fetchAcknowledgement');

    Route::post('/storeRequest', 'RequestController@storeRequest')->name('storeRequest');

    Route::get('/messages', 'MessageController@index')->name('messages');
    Route::get('/message/{id}', 'MessageController@conversation')->name('conversation');
    Route::post('/newMessage', 'MessageController@newMessage')->name('newMessage');
    Route::post('/readMessage', 'MessageController@readMessage')->name('readMessage');

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
    //Realtime Message Broadcasting
    Route::get('/broadcastMessage/{message_id}', function($message_id){
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
        
          $message = App\Message::find($message_id);
          $data['message'] = $message->message;
          $data['message_id'] = $message_id;
          $data['recepient_id'] = $message->recepient_id;
          $data['user_id'] = $message->user_id;
          $data['name'] = $message->user->name;
          $pusher->trigger('comment-channel', 'new-message', $data);
    });
    
});
