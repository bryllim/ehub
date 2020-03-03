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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function(){

    $acknowledged_users = App\Acknowledgement::where('post_id', 3)->get();
    $users = App\User::all();

    $acknowledged = [];
    $unacknowledged = [];

    foreach($users as $user){
        if($acknowledged_users->contains('user_id', $user->id)){
            array_push($acknowledged, $user->name);
        }else{
            array_push($unacknowledged, $user->name);
        }
    }

    $acknowledgements = [$acknowledged, $unacknowledged];

    return $acknowledgements;
});

Route::post('/newPost', 'PostController@newPost')->name('newPost');
Route::post('/newComment', 'CommentController@newComment')->name('newComment');
Route::post('/fetchComments', 'CommentController@fetchComments')->name('fetchComments');

Route::post('/newAcknowledgement', 'AcknowledgementController@newAcknowledgement')->name('newAcknowledgement');
Route::post('/fetchAcknowledgement', 'AcknowledgementController@fetchAcknowledgement')->name('fetchAcknowledgement');
