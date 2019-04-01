<?php

use App\Payment;
use App\students;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

$current = Carbon::now();
$day = $current->day;
$month = $current->format('F');
$year = $current->year;

//$t = DB::table('payments')->orderBy('userID')->where('userID',$t->id)->latest()->get();
$dinner = DB::table('foods')->where('day',$day)->where('month',$month)->where('year',$year)->where('meal','=','Dinner')->get();
$lunch = DB::table('foods')->where('day',$day)->where('month',$month)->where('year',$year)->where('meal','=','Lunch')->get();
/*echo $dinner;
echo $lunch;*/
?>

        <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Hostel Management System</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="/assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="/assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="/assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="assets/css/themify-icons.css" rel="stylesheet">

</head>
<body>

<div class="wrapper">

    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
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
                            <a href="{{ route('logOut') }}">
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

        <div class="content">
            <div class="container">
                <h3>New Student Created</h3>


                <table class="table">
                    <thead>
                    <tr>
                        <td>Username</td>
                        <td>Password</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $obj->username }}</td>
                        <td>{{ 123456 }}</td>
                        <td><a data-toggle="modal" data-target="#send" class="btn btn-primary">Send Email</a>&nbsp;
                            <div id="send" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Send email</h4>
                                        </div>
                                        <form method="post" action="{{ url('send') }}">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                <div class="col-md-6">
                                                    <input id="email" type="text" class="form-control" name="email" required >
                                                </div>
                                                <div class="modal-footer">
                                                    <!--
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                    </form> -->
                                                    <button type="submit" class="btn btn-primary">Send</button>

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><a data-toggle="modal" data-target="#sendsms" class="btn btn-primary">Send sms</a>&nbsp;
                            <div id="sendsms" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Send a sms</h4>
                                        </div>
                                        <form method="post" action="{{ url('sendSMS') }}">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No.') }}</label>

                                                <div class="col-md-6">
                                                    <input id="mobileNo" type="text" class="form-control" name="phone" required >
                                                </div>
                                                <div class="modal-footer">
                                                    <!--
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                    </form> -->
                                                    <button type="submit" class="btn btn-primary">Send</button>

                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, made by <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Pranta, Joy, Abir and Ashu.</a>
                </div>
            </div>
        </footer>

    </div>
</div>
</div>
</div>


</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio.js"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="assets/js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        demo.initChartist();

        $.notify({
            icon: 'ti-gift',
            message: "Welcome to <b>Hostel Management System</b> - a place you can consider home."

        },{
            type: 'success',
            timer: 4000
        });

    });
</script>

</html>
