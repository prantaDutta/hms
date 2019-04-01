<?php
use Illuminate\Support\Facades\Session;
use App\students;
use App\Payment;
use Illuminate\Support\Facades\DB;
//$value = Session::get('studentID');
$s = DB::table('students')->where('id',$userID)->first();
//$p = DB::table('payments')->where('userID',$value)->first();
//$pay = DB::table('payments')->where('userID',$value)->latest()->first();
?>
        <!DOCTYPE html>
<html>
<head>
    <title>Sending Email for Payment Acknowledgement.</title>
</head>
<body>
<div class="container">
    <h1>Hostel Management System</h1>
    <p>Mr {{ $s->firstName ." ". $s->lastName }}, We are happy to inform you that your payment of tk.{{$amount}} for the month of {{$month}} with the due fine of {{ $dueFine }}tk. and refund of {{ $refund }}tk. is confirmed successfully. You can download the pdf of your payment receipt from the attachment of this email. Thank you for staying with us.</p>

</div>
</body>
</html>
