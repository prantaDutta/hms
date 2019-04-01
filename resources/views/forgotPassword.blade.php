<?php
use Illuminate\Support\Facades\Session;
use App\students;
use App\Payment;
use Illuminate\Support\Facades\DB;

$s = DB::table('students')->where('rememberToken',$token)->first();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sending Email for Payment Acknowledgement.</title>
</head>
<body>
<div class="container">
    <h1>Hostel Management System</h1>
    <p>Mr {{ $s->firstName ." ". $s->lastName }}, you are receiving this email because we received a forgot password request regarding this email. Please click the following link to reset your password.</p>

    <a>
        <button class="btn btn-success" href="localhost:8000/forgotPassword/{{ $token }}">Click here to change password</button>
    </a>
</div>
</body>
</html>
<style>

    .container .btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}

    .container .btn-success{color:#fff;background-color:#28a745;border-color:#28a745}.btn-success:hover{color:#fff;background-color:#218838;border-color:#1e7e34}.btn-success.focus,.btn-success:focus{box-shadow:0 0 0 .2rem rgba(40,167,69,.5)}.btn-success.disabled,.btn-success:disabled{color:#fff;background-color:#28a745;border-color:#28a745}.btn-success:not(:disabled):not(.disabled).active,.btn-success:not(:disabled):not(.disabled):active,.show>.btn-success.dropdown-toggle{color:#fff;background-color:#1e7e34;border-color:#1c7430}.btn-success:not(:disabled):not(.disabled).active:focus,.btn-success:not(:disabled):not(.disabled):active:focus,.show>.btn-success.dropdown-toggle:focus{box-shadow:0 0 0 .2rem rgba(40,167,69,.5)}.btn-info{color:#fff;background-color:#17a2b8;border-color:#17a2b8}

</style>