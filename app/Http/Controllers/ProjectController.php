<?php

namespace App\Http\Controllers;

use App\Food;
use App\Payment;
use App\students;
use Barryvdh\DomPDF\Facade as PDF;
use function GuzzleHttp\Psr7\str;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image as Image;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Carbon\Carbon;
use App\Rules\UniqueUsername;

class ProjectController extends Controller
{
    public function home(){
        return view('home');
    }
    public function services(){
        return view('services');
    }
    public function achievements(){
        return view('achievements');
    }
    public function aboutus(){
        return view('aboutus');
    }
    public function contactus(){
        return view('contactus');
    }
    public function login(){
        return view('login');
    }

    public function loginStore(Request $request) {
        $username = $request->username;
        $password = md5($request->password);

        $validatedData = $request->validate([
            'username' => 'required|max:50',
            'password' => 'required|max:50|min:6|',
        ]);

        $user = students::where('username','=',$username)
            ->where('password','=',$password)
            ->first();

        if($user){
            $obj = students::find($user->id);
            $role = $obj->role;
            if ($role == 'admin') {
                Session::put('adminID', $user->id);
                Session::put('adminUsername', $user->username);
                return redirect('aDashboard');
            }
            else if ($role == 'student'){
                Session::put('studentID',$user->id);
                Session::put('studentUsername',$user->username);
                return redirect('uDashboard');
            }
        }
        else{
            echo 'Oops, You entered wrong username or password combination';
        }
    }
    public function update(Request $request, $id){
        $obj = students::find($id);
        $password = $obj->password;

        $validatedData = $request->validate([
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|email|unique:students,email,'.$id.',id',
            'username' => 'required|unique:students,username,'.$id.',id',
            'dateOfBirth' => 'required|date',
            'address' => 'required',
            'education' => 'required',
            'institution' => 'required',
            'mobileNo' => 'required',
            'localGuardian' => 'required',
            'guardianNo' => 'required',
            'confirmPassword' => 'required|max:50|min:6',
        ]);

        $firstname  = $request->input( 'firstName' );
        $lastname  = $request->input( 'lastName' );
        $email = $request->input( 'email' );
        $username  = $request->input( 'username' );
        $dateOfBirth  = $request->input( 'dateOfBirth' );
        $address  = $request->input( 'address' );
        $education  = $request->input( 'education' );
        $institution  = $request->input( 'institution' );
        $mobileNo  = $request->input( 'mobileNo' );
        $localGuardian  = $request->input( 'localGuardian' );
        $guardianNo  = $request->input( 'guardianNo' );
        //$password1 = $request->input( 'password1' );
        //$password2 = $request->input( 'password2' );
        $confirmPassword = md5($request->input( 'confirmPassword' ));
        $originalImage= $request->file('filename');

        $thumbnailImage = Image::make($originalImage);
        //echo "connected";
        $thumbnailPath = public_path().'/thumbnail/';
        $originalPath = public_path().'/images/';
        $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
        $thumbnailImage->resize(150,150);
        $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());

        $obj->firstName = $firstname;
        $obj->lastname = $lastname;
        $obj->email = $email;
        $obj->username = $username;
        $obj->dateOfBirth = $dateOfBirth;
        $obj->address = $address;
        $obj->education = $education;
        $obj->institution = $institution;
        $obj->mobileNo = $mobileNo;
        $obj->localGuardian = $localGuardian;
        $obj->guardianNo = $guardianNo;
        //$obj->password = $confirmPassword;
        $obj->filename=time().$originalImage->getClientOriginalName();


        if($password == $confirmPassword){
            $obj->save();
            return redirect('studentProfile');
        }
        else
            echo "You need to enter your password correctly.";
    }
    public function newUserStore(Faker $faker)
    {
        $username = $faker->unique()->userName;
        $password = md5('123456');
        $rememberToken = str_random(20);
        do
        {
            $user_code = students::where('rememberToken', $rememberToken)->first();
        }
        while(!empty($user_code));

        echo $rememberToken;

        $obj = new students();
        $obj->username = $username;
        $obj->role = 'student';
        $obj->password = $password;
        $obj->rememberToken = $rememberToken;
        $obj->accountStatus = 'inActive';
        if($obj->save()){
            return redirect()->route('newUser');
        }
    }
    public function newUser(){
        $obj = DB::table('students')->latest()->first();
        return view('newUser',['obj'=>$obj]);
    }
    public function send(Request $request)
    {
        $email  = $request->input( 'email' );
        Mail::send('mail',['name','Pranta'],function($message) use($email){
            $message->to($email,'To User')->subject('Test Mail');
            $message->from('prantadutta1997@gmail.com','Pranta Dutta');
        });
        echo "Mail Successfully Delivered.";
    }

    public function sendSMS(Request $req){
        $code = rand(11111,99999);
        $num = $req->phone;
        $trxID = rand(00000000,99999999);

        $basic  = new \Nexmo\Client\Credentials\Basic('1e02a767', 'B1wuhwv0YP9cyatv');
        $client = new \Nexmo\Client($basic);
        $last = DB::table('students')->latest()->first();

        $message = $client->message()->send([
            'to' => '88'.(int)$num,
            'from' => 'HMS',
            'text' => 'Your username is '.$last->username.' and password is 123456. Please change your password to activate your account. Thank you.',
        ]);
        echo "message successfully delivered.";
    }

    public function editStudent(Request $request){
        $value = Session::get('studentID');
        $t = students::find($value);
        return view('editProfile',['t'=>$t]);
    }

    public function logout(Request $request){
        if($request->session()->has('adminID') || $request->session()->has('studentID')){
            $request->session()->flush();
        }
        return redirect('home');
    }
    public function payBill(Request $request,Faker $faker, $id){
        $currentforDay = Carbon::now('Asia/Dhaka');
        $day = $currentforDay->day;
        $currentMonth = $currentforDay->month;
        $currentMonthName = $currentforDay->format('F');
        //$new = new Carbon('last month');
        $currentforPreviousMonth = Carbon::now('Asia/Dhaka');
        $previousMonthName = $currentforPreviousMonth->startOfMonth()->subMonth()->format('F');
        $currentforNextMonth = Carbon::now('Asia/Dhaka');
        $nextMonthName = $currentforNextMonth->startOfMonth()->addMonth()->format('F');

        $year = $currentforDay->year;
        $date = $day."/".$currentMonth."/".$year;
        $student = students::find($id);

        $toCheckRefund = Carbon::now('Asia/Dhaka');
        $dayToCheck = $toCheckRefund->day;
        if($dayToCheck<=4)
            $setFine = 0;
        else if ($dayToCheck <=31)
            $setFine = $day * 10 - 40;

        $validatedData = $request->validate([
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required',
            'dueFine' => 'required',
            'refund' => 'required',
            'mobileNo' => 'required',
            'method' => 'required',
            'trxID' => 'required',
        ]);

        $firstname  = $request->input( 'firstName' );
        $lastname  = $request->input( 'lastName' );
        $name = $firstname." ".$lastname;
        $month = $request->input( 'month' );
        $year  = $request->input( 'year' );
        $amount  = $request->input( 'amount' );
        $dueFine  = $request->input( 'dueFine' );
        $refund = $request->input('refund');
        $mobileNo  = $request->input( 'mobileNo' );
        $method  = $request->input( 'method' );
        $trxID  = $request->input( 'trxID' );
        $email = $student->email;

        if($amount==1){
            $amount = 3000 + $dueFine - $refund;
        }
        else if ($amount == 2){
            $amount = 6000 + 300 + $dueFine - $refund;
            $month = $currentMonthName." + ".$previousMonthName;
        }
        else if ($amount ==3) {
            $amount = 6000 + $dueFine - $refund;
            $month = $currentMonthName." + ".$nextMonthName;
        }

        if ($setFine != $dueFine)
            return redirect()->back()->with('message', 'Something Went Wrong. Please Try Again.');

        $student = DB::table('foods')->groupBy('userID')->where('month' , $previousMonthName)->where('year' , $year)->count();
        $checkRefund = $student*40;

        if($checkRefund != $refund)
            return redirect()->back()->with('message', 'Something Went Wrong. Please Try Again.');

        $obj = new Payment();
        $obj->paymentID = $faker->unique()->numberBetween('111111','999999');
        $obj->userID = $id;
        $obj->name = $name;
        $obj->month = $month;
        $obj->year = $year;
        $obj->amount = $amount;
        $obj->dueFine = $dueFine;
        $obj->payDate = $date;
        $obj->refund = $refund;
        $obj->mobileNo = $mobileNo;
        $obj->method = $method;
        $obj->trxID = $trxID;
        $obj->Confirmation = 'No';

        if($obj->save()){
            Mail::send('paymentMail',['name','Pranta'],function($message) use($email){
                $message->to($email,'To User')->subject('Payment Mail');
                $message->from('prantadutta1997@gmail.com','Pranta Dutta');
            });
            return redirect()->back()->with('message', 'Payment Accepted. Please wait for confirmation.');
        }
    }
    public function cancellingFood(Request $request,$id){
        $obj = new Food();


        $current = Carbon::now('Asia/Dhaka');
        //$currentDate = $current->toArray();
        $currentYear = $current->year;
        $currentDay = $current->day;
        $currentMonth = $current->format('F');

        $meal = $request->input('meal');
        if ($meal != 'Dinner' && $meal != 'Lunch')
            return Redirect::back()->withErrors(['Your Meal value is invalid']);

        $findMeal = DB::table('foods')->where('userID',$id)->where('day',$currentDay)->where('month',$currentMonth)->where('year',$currentYear)->where('meal',$meal)->first();

        if ($findMeal){
            if ($findMeal->meal == 'Lunch')
                return Redirect::back()->withErrors(['You already cancelled Lunch.']);
            else if ($findMeal->meal == 'Dinner')
                    return Redirect::back()->withErrors(['You already cancelled Dinner.']);
        }

        $obj->userID = $id;
        $obj->meal = $meal;
        $obj->day = $currentDay;
        $obj->month = $currentMonth;
        $obj->year = $currentYear;

        if($obj->save()){
            return redirect()->back()->with('message', 'Meal Cancelled.');
        }
    }
    public function adminProfile(Request $request){
        $value = Session::get('adminID');
        $t = students::find($value);
        return view('adminProfile',['t'=>$t]);
    }

    public function updateAdmin(Request $request, $id){
        $obj = students::find($id);
        $password = $obj->password;

        $validatedData = $request->validate([
            'firstName' => 'required|max:50',
            'lastName' => 'required|max:50',
            'email' => 'required|email|unique:students,email,'.$id.',id',
            'username' => 'required|unique:students,username,'.$id.',id',
            'dateOfBirth' => 'required|date',
            'address' => 'required',
            /*'education' => 'required',
            'institution' => 'required',*/
            'mobileNo' => 'required',
            /*'localGuardian' => 'required',
            'guardianNo' => 'required',*/
            'confirmPassword' => 'required|max:50|min:6',
        ]);

        $firstname  = $request->input( 'firstName' );
        $lastname  = $request->input( 'lastName' );
        $email = $request->input( 'email' );
        $username  = $request->input( 'username' );
        $dateOfBirth  = $request->input( 'dateOfBirth' );
        $address  = $request->input( 'address' );
        /*$education  = $request->input( 'education' );
        $institution  = $request->input( 'institution' );*/
        $mobileNo  = $request->input( 'mobileNo' );
        /*$localGuardian  = $request->input( 'localGuardian' );
        $guardianNo  = $request->input( 'guardianNo' );*/
        //$password1 = $request->input( 'password1' );
        //$password2 = $request->input( 'password2' );
        $confirmPassword = md5($request->input( 'confirmPassword' ));

        if ($request->hasFile('filename')){
            $originalImage= $request->file('filename');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/thumbnail/';
            $originalPath = public_path().'/images/';
            $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName());
        }

        $obj->firstName = $firstname;
        $obj->lastname = $lastname;
        $obj->email = $email;
        $obj->username = $username;
        $obj->dateOfBirth = $dateOfBirth;
        $obj->address = $address;
        /*$obj->education = $education;
        $obj->institution = $institution;*/
        $obj->mobileNo = '0'.$mobileNo;
        /*$obj->localGuardian = $localGuardian;
        $obj->guardianNo = $guardianNo;*/
        //$obj->password = $confirmPassword;
        $obj->filename=time().$originalImage->getClientOriginalName();


        if($password == $confirmPassword){
            $obj->save();
            return redirect('adminProfile');
        }
        return Redirect::back()->withErrors(['msg', 'Your Password is Incorrect']);
    }

    public function payAccepted($id)
    {
        $obj = DB::table('payments')->where('paymentID', $id)->first();
        $student = DB::table('students')->where('id', $obj->userID)->first();
        $email = $student->email;
        $num = $student->mobileNo;

        //$obj->confirmation = 'Yes';
        DB::table('payments')->where('paymentID', $id)->update(['confirmation' => 'Yes']);

        Mail::send('paymentConfirmation', $data = [
            'userID' => $obj->userID,
            'amount' => $obj->amount,
            'month' => $obj->month,
            'dueFine' => $obj->dueFine,
            'refund' => $obj->refund], function ($message) use ($email) {
            $message->to($email, 'To User')->subject('Payment Mail');
            $message->from('prantadutta1997@gmail.com', 'Pranta Dutta');
        });

        $basic = new \Nexmo\Client\Credentials\Basic('1e02a767', 'B1wuhwv0YP9cyatv');
        $client = new \Nexmo\Client($basic);
        //$last = DB::table('students')->latest()->first();

        $message = $client->message()->send([
            'to' => '88'.(int)$num,
            'from' => 'HMS',
            'text' => 'Dear Mr. '.$student->firstName.' '.$student->lastName.' Your payment of tk. '.$obj->amount.' for the month of '.$obj->month.'. You can download the pdf copy of your receipt now. Thank you.',
        ]);

        return redirect()->back()->with('message', 'Payment Accepted!');
    }

    public function downloadPDF($id){
        $t = DB::table('payments')->where('paymentID', $id)->first();
        $pdf = PDF::loadView('paymentReceipt', compact('t'));
        //$pdf->setBasePath(public_path());
        return $pdf->download('paymentReceipt.pdf');
    }
    public function forgotPassword(Request $request){
        $email = $request->input('email');
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);
        $checkEmail = DB::table('students')->where('email', $email)->first();
        if ($checkEmail){
            //$token = $checkEmail->rememberToken;
            Mail::send('forgotPassword',$data = [
                'token' => $checkEmail->rememberToken,
                ],function($message) use($email){
                $message->to($email,'To User')->subject('Forgot Password Email');
                $message->from('prantadutta1997@gmail.com','Pranta Dutta');
            });
            return redirect()->back()->with('message', 'Email Successfully delivered.');
        }
        else
            return redirect()->back()->with('message', 'Email does not exist.');
    }

    public function confirmPassword(Faker $faker, $id){
        $check = DB::table('students')->where('rememberToken',$id)->first();
        if ($check){
            $rememberToken = str_random(20);
            do
            {
                $user_code = students::where('rememberToken', $rememberToken)->first();
            }
            while(!empty($user_code));
            DB::table('students')->where('id', $id)->update(['rememberToken' => $rememberToken]);;
            return view('changePassword',['t'=>$check]);
        }
        else{
            return redirect('login')->with('message','Something Went Wrong');
        }
    }

    public function passwordChange(Request $request,$id){
        $student = students::find($id);
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmPassword');
        if($password == $confirmPassword){
            $password = md5($password);
            $student->password = $password;
            $student->save();
            Session::put('studentID',$student->id);
            Session::put('studentUsername',$student->username);
            return redirect('uDashboard');
        }
        else
            return redirect()->back()->with('message','Passwords do not match');
    }
    public function getDayValue($id){
        $current = Carbon::now('Asia/Dhaka');
        $currentYear = $current->year;
        //$currentDay = $current->day;
        $currentMonth = $current->format('F');
        $value = Session::get('studentID');

        $data = DB::table('foods')->where('userID',$value)->where('day',$id)->where('month',$currentMonth)->where('year',$currentYear)->get();
        echo $data->meal;
        return response()->json([
            'error' => false,
            'mydata' => $data,
        ], 200);
    }
    public function index(){

    }
}
