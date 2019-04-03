<?php
use Illuminate\Support\Facades\Session;
use App\students;
use App\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

$s = DB::table('students')->where('rememberToken',$token)->first();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sending Email for Payment Acknowledgement.</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Hostel Management System</h1>
    <p>Mr {{ $s->firstName ." ". $s->lastName }}, you are receiving this email because we received a forgot password request regarding this email. Please click the following link to reset your password.</p>

    {{--<a class="btn btn-success" href="localhost:8000/forgotPassword/{$token}">Click here to change password</a>
--}}
    <a href="{{ URL::to('http://localhost:8000/confirmPassword/'.$token) }}"  class="m_-7665989017284319294button m_-7665989017284319294button-primary" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3490dc;border-top:10px solid #3490dc;border-right:18px solid #3490dc;border-bottom:10px solid #3490dc;border-left:18px solid #3490dc" target="_blank">Verify Email Address</a>
</div>
</body>
</html>