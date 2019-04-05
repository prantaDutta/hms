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
if ($checkMeal)
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
    if ($countCheckMeal == 1)
        $meal = $checkMeal->meal;
}
else
    $meal = '';
echo $meal;*/
$end = new Carbon('last day of last month');
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
    <h1>Select the Meal You want to cancel</h1>
    <form method="post" action="cancellingFood/{{ $t->id }}" enctype="multipart/form-data">
            {{ csrf_field() }}

        <div class="form-row">
            <div class="form-group">
                <label for="exampleInputEmail1" id="cancelDate">Cancel For</label>
                <div class="row">
                    <div class="col-xs-4 col-md-4 ">
                        <select class="form-control custom-select" id="day" name="day"></select>
                    </div>
                    <div class="col-xs-4 col-md-4">
                        <select class="form-control custom-select" id="month" name="month"></select>
                    </div>
                    <div class="col-xs-4 col-md-4">
                        <select class="form-control custom-select" id="year" name="year"></select>
                    </div>
                </div>
            </div>
        </div>


        <?php /*echo $checkMeal[0]->meal; */?>
        <div class="form-group">
            <label for="inputGroupSelect01">Cancel Meal</label>
            <select class="form-control custom-select meal" id="meal" name="meal">
                <option selected>Please Choose...</option>
                @if($countCheckMeal == 1 && $hour < 7)
                    @if ($checkMeal[0]->meal == 'Lunch')
                        <option value="Dinner">Cancel Dinner</option>
                    @elseif ($checkMeal[0]->meal == 'Dinner')
                        <option value="Lunch">Cancel Lunch</option>
                        @endif
                @elseif ($countCheckMeal == 1 && $hour < 17)
                    @if ($checkMeal[0]->meal == 'Lunch')
                        <option value="Dinner">Cancel Dinner</option>
                    @endif
                @elseif($countCheckMeal == 2)
                    <option disabled>You already cancelled Lunch and Dinner</option>
                @else
                    @if($hour > 7)
                        <option value="Dinner">Cancel Dinner</option>
                    @elseif ($hour > 17)
                        <option disabled="">Too Late to cancel.</option>
                    @else
                        <option value="Lunch">Cancel Lunch</option>
                        <option value="Dinner">Cancel Dinner</option>
                        @endif
                    @endif
            </select>
        </div>



        <button type="submit" class="btn btn-primary">Cancel</button>
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

<script type="text/javascript">
    $(document).ready(function () {

    })
</script>

<script>
    $(document).ready(function() {
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        var qntYears = 4;
        var selectYear = $("#year");
        var selectMonth = $("#month");
        var selectDay = $("#day");
        var currentYear = new Date().getFullYear();

        for (var y = 0; y < qntYears; y++){
            let date = new Date(currentYear);
            var yearElem = document.createElement("option");
            yearElem.value = currentYear;
            yearElem.textContent = currentYear;
            selectYear.append(yearElem);
            currentYear++;
        }

        for (var m = 0; m < 12; m++){
            let monthNum = new Date(2019, m).getMonth();
            let month = monthNames[monthNum];
            var monthElem = document.createElement("option");
            monthElem.value = monthNum;
            monthElem.textContent = month;
            selectMonth.append(monthElem);
        }

        var d = new Date();
        var month = d.getMonth();
        var year = d.getFullYear();
        var day = d.getDate();


        selectYear.val(year);
        selectYear.on("change", AdjustDays);
        selectMonth.val(month);
        selectMonth.on("change", AdjustDays);

        AdjustDays();
        selectDay.val(day);

        function AdjustDays(){
            var year = selectYear.val();
            var month = parseInt(selectMonth.val()) + 1;
            selectDay.empty();

//get the last day, so the number of days in that month
            var days = new Date(year, month, 0).getDate();

//lets create the days of that month
            for (var d = 1; d <= days; d++){
                var dayElem = document.createElement("option");
                dayElem.value = d;
                dayElem.textContent = d;
                selectDay.append(dayElem);
            }
        }

        var dayValue = $('#day').val();
        var monthValue = $('#month').val();
        var yearValue = $('#year').val();
        var $change = $("#day, #month, #year");

        /*$($change).change(function () {
            $("#meal").empty();
            $("day").append(dayValue);
            var checkMonthValue = parseInt(monthValue,'10');
            var newMonthValue = checkMonthValue + 1;

            $.ajax({
                url: "getDayValue/"+dayValue,
                type: "GET",
                //data : mydata,
                dataType: "json",
                success:function (data) {
                    //console.log(data.meal);
                }
            })
            //console.log(dayValue);
        })*/
    });
</script>
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