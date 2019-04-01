<?php
    use Illuminate\Support\Facades\Session;
    use App\students;
    use App\Payment;
    use Illuminate\Support\Facades\DB;
    $value = Session::get('studentID');
    $s = DB::table('students')->where('id',$value)->first();
    $p = DB::table('payments')->where('userID',$value)->first();
    $id = $p->paymentID;
    $pay = DB::table('payments')->where('userID',$value)->latest()->first();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sending Email for Payment Acknowledgement.</title>
</head>
<body>
<div class="container">
    <h1>Hostel Management System</h1>
    <p>Mr {{$s->firstName ." ". $s->lastName}}, Thank you for for your payment of tk.{{$pay->amount}} for the month of {{$pay->month}}</p>
</div>
</body>
</html>