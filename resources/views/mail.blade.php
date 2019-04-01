<?php
$last = DB::table('students')->latest()->first();
?>
        <!DOCTYPE html>
<html>
<head>
    <title>Sending Email for Login Credentials</title>
</head>
<body>
<div class="container">
    <h1>Hostel Management System</h1>
    <p>Thank you for Registration.</p>
    <h3 class="color">Your username is {{ $last->username }}</h3>
    <h3 class="color">Your password is 123456</h3>
</div>
</body>
</html>