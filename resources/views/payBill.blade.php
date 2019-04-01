<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Payment;
use App\Food;
$current = Carbon::now();
$currentDate = $current->toArray();
$currentYear = $current->year;
$currentMonth = $current->format('F');
$currentforPreviousMonth = Carbon::now('Asia/Dhaka');
$previousMonth = $currentforPreviousMonth->startOfMonth()->subMonth()->format('F');
$currentforDay = Carbon::now('Asia/Dhaka');
$day = $currentforDay->day;
if($day<=4)
    $setFine = 0;
else if ($day <=31)
    $setFine = $day * 10 - 40;

$student = DB::table('foods')->groupBy('userID')->where('month' , $previousMonth)->where('year' , $currentYear)->count();
$refund = $student*40;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="assets/css/themify-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="{{ url('uDashboard') }}">Back to Dashboard</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-panel"></i>
                        <p>Stats</p>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="ti-bell"></i>
                        <p class="notification">5</p>
                        <p>Notifications</p>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Notification 1</a></li>
                        <li><a href="#">Notification 2</a></li>
                        <li><a href="#">Notification 3</a></li>
                        <li><a href="#">Notification 4</a></li>
                        <li><a href="#">Another notification</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="ti-settings"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li>
                    <a href="logOut">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<div class="container">
    <h1>Pay Your Due Bill</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="post" action="payBill/{{ $t->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-row">
            <div class="form-group col-md-6 forLeftRight1">
                <label for="exampleFirstName">First Name</label>
                <input type="text" class="form-control" id="exampleFirstName" value="{{ $t->firstName }}" name="firstName">
            </div>
            <div class="form-group col-md-6 forLeftRight2">
                <label for="exampleLastName">Last Name</label>
                <input type="text" class="form-control" id="exampleLastName" value="{{ $t->lastName }}" name="lastName">
            </div>
        </div>
        <div class="form-group">
            <label for="exampleUserName">User Name</label>
            <input type="text" class="form-control" id="exampleUserName" value="{{ $t->username }}" name="username">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 forLeftRight1">
                <label for="inputGroupSelect01">Month</label>
            <select class="form-control custom-select" id="inputGroupSelect01" name="month">
                <option selected value="{{ $currentMonth }}">{{ $currentMonth }}</option>
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
                {{--<option value="withPreviousMonth">With Previous Month</option>
                <option value="withNextMonth">With Next Month</option>--}}
            </select>
            </div>
            <div class="form-group col-md-6 forLeftRight2">
                <label for="inputGroupSelect01">Year</label>
            <select class="form-control custom-select" id="inputGroupSelect01" name="year">
                <option selected value="{{ $currentYear }}">{{ $currentYear }}</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleBirthDate">Amount to pay</label>
            {{--<input type="text" class="form-control" id="exampleBirthDate" name="amount">--}}
            <select class="form-control custom-select" id="inputGroupSelect01" name="amount">
                <option selected value="">Choose...</option>
                <option value="1">Pay 3000tk. for One Month</option>
                <option value="2">Pay 6300 + due fine for Two Months(For Previous Month + Current Month)</option>
                <option value="3">Pay 6000 + due fine for Two Months(For Next Month + Current Month)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Due Fine</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $setFine }}" name="dueFine" readonly>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Refund</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $refund }}" name="refund" readonly>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Payment Method</label>
            <select class="form-control custom-select" id="inputGroupSelect01" name="method">
                <option selected>Choose Payment Method...</option>
                <option value="bkash">Bkash</option>
                <option value="rocket">Rocket</option>
                <option value="ucash">Ucash</option>
                <option value="purecash">PureCash</option>
                <option value="gpay">Gpay</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Mobile No</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="mobileNo">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Transaction ID</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="trxID">
        </div>
        {{--<div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" value="" name="confirmPassword">
        </div>--}}
        <button type="submit" class="btn btn-primary p-5">Submit</button>
    </form>
</div>



</body>
</html>
<style>
    .forLeftRight1{
        padding-right: 1rem;
        padding-left: 0;
    }
    .forLeftRight2{
        padding-right: 0;
        padding-left:  1rem;
    }
</style>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5c9be2d11de11b6e3b058b23/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->