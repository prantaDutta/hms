<?php
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\students;
use Illuminate\Support\Facades\DB;

$value = Session::get('studentID');
$current = Carbon::now('Asia/Dhaka');
$tomorrow = Carbon::tomorrow('Asia/Dhaka');
$currentDate = $current->toArray();
$day = $current->day;
$nextDay = $tomorrow->day;
$hour = $current->hour;
$currentYear = $current->year;
$currentMonth = $current->format('F');
$previousMonth = $current->subMonth()->format('F');
$d = $current->daysInMonth;
$toCalculateDay = Carbon::now()->setTimezone('Asia/Dhaka');
$dToCalculate = $toCalculateDay->daysInMonth;
/*$start = new Carbon('first day of this month');
$end = $start = new Carbon('last day of this month');
$states = $start->setDate();
$value = $end->setDate();*/

//$checkMeal = DB::table('foods')->where('userID',$value)->where('day',$day)->where('month',$currentMonth)->where('year',$currentYear)->first();
$checkMeal = DB::table('foods')->where('userID',$value)->where('day',$day)->where('month',$currentMonth)->where('year',$currentYear)->get();
$countCheckMeal = count($checkMeal);
$list=array();
for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, date('m'), $d, date('Y'));
    if (date('m', $time)==date('m'))
        $list[]=date('d', $time);
}
//echo $list[6];
//var_dump($list);
/*for($i = 1; $i <=  date('t'); $i++)
{
    // add the date to the dates array
    $dates[] = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
    //$currentMonthDates[] = $forDates->day;
}*/
//echo $dates[0];
//var_dump($currentMonthDates);

/*if ($checkMeal){
    $meal = $checkMeal->meal;
}
else
    $meal = '';
echo $meal;*/
?>

        <!DOCTYPE html>
<html>
<head>
    <title>Cancel Food</title>
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

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h1>Select the Period You want to reques the leave</h1>
    <form method="post" action="leaveRequest/{{ $t->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="exampleBirthDate">Start Date</label>
            <input type="date" class="form-control" id="startDate" value="Swag" name="startDate" />
        </div>
        <div class="form-group">
            <label for="inputGroupSelect01">Start Date Meal</label>
            <select class="form-control custom-select meal" id="meal" name="startDateMeal">
                <option selected>Please Choose...</option>
                <option value="Lunch">Cancel Lunch</option>
                <option value="Dinner">Cancel Dinner</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleBirthDate">End Date</label>
            <input type="date" class="form-control" id="endDate" value="Swag" name="endDate" />
        </div>
        <div class="form-group">
            <label for="inputGroupSelect01">End Date Meal</label>
            <select class="form-control custom-select meal" id="meal" name="endDateMeal">
                <option selected>Please Choose...</option>
                <option value="Lunch">Cancel Lunch</option>
                <option value="Dinner">Cancel Dinner</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function(){

        demo.initChartist();

        $.notify({
            icon: 'ti-food',
            message: "Your food is successfully <b>cancelled.</b>"

        },{
            type: 'success',
            timer: 4000
        });
    });
</script>
<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>

{{--<script type="text/javascript">
    $(document).ready(function () {
        $("#day").change(function () {
            var selectDay = $('#day').val();
            $.ajax({
                url: "/getDayValue/"+selectDay,
                type: "GET",
                //data: data,
                dataType : "json",
                success: function (data) {
                    console.

                    /*var temp = data;
                    $('#meal').empty();
                    alert(data);
                    $.each(data, function (i,obj) {

                    })*/
                }
            });

        });
    });
</script>--}}

{{--<script>
    $(document).ready(function () {
        $('#day').change(function () {
            if ($(this).val()!=''){
                var select = $(this.attr("id"));
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                $.ajax({
                    url: "/getDayValue/"+selectDay,
                    method: "GET",
                    data: {select:select, value: value, dependent: dependent},
                    success::function (result) {

                    }
                })
            }
        })
    })
</script>--}}

{{--<script type="text/javascript">
    $(document).ready(function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var today = dd + '/' + mm + '/' + yyyy;
        //$("#startDate").append("<input type=\"date\" class=\"form-control\" id=\"startDate\" value='today' name=\"startDate\">");
        document.getElementById("startDate").value = today;

        var tomorrow = new Date();
        var dd = tomorrow.getDate()+1;
        var mm = tomorrow.getMonth() + 2; //January is 0!

        var yyyy = tomorrow.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var tomorrow = dd + '/' + mm + '/' + yyyy;
        //$("#startDate").append("<input type=\"date\" class=\"form-control\" id=\"startDate\" value='today' name=\"startDate\">");
        document.getElementById("endDate").value = tomorrow;
    });

</script>--}}
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