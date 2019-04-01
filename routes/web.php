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
use App\students;
use App\Payment;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'adminloggedin'], function(){
    Route::get('/aDashboard', function () {
        return view('aDashboard');
    });

    Route::get('/checkBill', function () {
        //$value = Session::get('adminID');
        $t = DB::table('payments')->where('confirmation','=','No')->get();
        return view('checkBill',['t'=>$t]);
    });

    Route::get('/payDetails/{paymentID}', function ($paymentID) {
        //$value = Session::get('adminID');
        $t = DB::table('payments')->where('paymentID',$paymentID)->first();
        return view('paymentDetails',['t'=>$t]);
    });

    Route::post('/newUser','ProjectController@newUserStore');

    Route::get('/newUser','ProjectController@newUser')->name('newUser');

    Route::post('/send','ProjectController@send');

    Route::post('/sendSMS','ProjectController@sendSMS');

    Route::get('/adminProfile','ProjectController@adminProfile');

    Route::post('/updateAdmin/{id}','ProjectController@updateAdmin');

    Route::post('/payDetails/payAccepted/{id}','ProjectController@payAccepted');

    Route::get('/foodInfo', function () {
        return view('foodInfo');
    });

    Route::get('/studentVerify', function () {
        $t = DB::table('students')->where('accountStatus','=','inActive')->get();
        return view('studentVerify',['t'=>$t]);
    });
});

Route::group(['middleware' => 'studentloggedin'], function(){
    Route::get('/uDashboard', function () {
        return view('uDashboard');
    });

    Route::get('/payBill', function () {
        $value = Session::get('studentID');
        $t = students::find($value);
        return view('payBill',['t'=>$t]);
    });


    Route::get('/studentProfile','ProjectController@editStudent');

    Route::post('/updateStudent/{id}','ProjectController@update');

    Route::post('/payBill/{id}','ProjectController@payBill');

    Route::get('/paymentDetailsCheck/{id}', function ($id) {
        $t = students::find($id);
        return view('paymentDetailsCheck',['t'=>$t]);
    });

    Route::get('/cancelFood', function () {
        $value = Session::get('studentID');
        $t = students::find($value);
        return view('cancelFood',['t'=>$t]);
    });

    Route::post('/cancellingFood/{id}','ProjectController@cancellingFood');

    Route::get('/paymentDetailsCheck/downloadPDF/{id}','ProjectController@downloadPDF');

    Route::get('/help', function () {
        $value = Session::get('studentID');
        $t = students::find($value);
        return view('help',['t'=>$t]);
    });
});


Route::get('home','ProjectController@home');

Route::post('forgotPassword','ProjectController@forgotPassword');


Route::get('services','ProjectController@services');

Route::get('achievements','ProjectController@achievements');

Route::get('aboutus','ProjectController@aboutus');

Route::get('contactus','ProjectController@contactus');

Route::get('logOut','ProjectController@logout')->name('logOut');

Route::get('login','ProjectController@login')->name('login');

Route::post('loginStore','ProjectController@loginStore');


