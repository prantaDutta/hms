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
            <a class="navbar-brand" href="#">Student Profile</a>
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
    <h1>Edit Profile</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="updateAdmin/{{ $t->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="exampleFirstName">First Name</label>
            <input type="text" class="form-control" id="exampleFirstName" value="{{ $t->firstName }}" name="firstName">
        </div>
        <div class="form-group">
            <label for="exampleLastName">Last Name</label>
            <input type="text" class="form-control" id="exampleLastName" value="{{ $t->lastName }}" name="lastName">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $t->email }}" name="email">
        </div>
        <div class="form-group">
            <label for="exampleUserName">User Name</label>
            <input type="text" class="form-control" id="exampleUserName" value="{{ $t->username }}" name="username">
        </div>
        <div class="form-group">
            <label for="exampleBirthDate">Date of Birth</label>
            <input type="date" class="form-control" id="exampleBirthDate" value="{{ $t->dateOfBirth }}" name="dateOfBirth">
        </div>
        <div class="form-group">
            <label for="exampleBirthDate">Permanent Address</label>
            <input type="text" class="form-control" id="exampleBirthDate" value="{{ $t->address }}" name="address">
        </div>
        {{--<div class="form-group">
            <label for="exampleBirthDate">Educational Status</label>
            <input type="text" class="form-control" id="exampleBirthDate" value="{{ $t->education }}" name="education">
        </div>
        <div class="form-group">
            <label for="exampleBirthDate">Educational Institution</label>
            <input type="text" class="form-control" id="exampleBirthDate" value="{{ $t->institution }}" name="institution">
        </div>--}}
        <div class="form-group">
            <label for="exampleInputEmail1">Mobile No</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $t->mobileNo }}" name="mobileNo">
        </div>
        {{--<div class="form-group">
            <label for="exampleInputEmail1">Guardian Name</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $t->localGuardian }}" name="localGuardian">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Guardian's Number</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $t->guardianNo }}" name="guardianNo">
        </div>--}}
        {{--<div class="form-group">
          <label for="exampleInputPassword1">Current Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" value="" name="password1">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">New Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" value="" name="password1">
        </div>--}}
        <div class="form-group">
            <label for="exampleFormControlFile1">Upload Profile Picture</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="filename">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" value="" name="confirmPassword">
        </div>
        <div class="m-5 p-5">
            <small id="emailHelp" class="form-text text-muted ct-red mb-5"><strong>Important! You must confirm your password to save changes.</strong></small>
        </div>
        <button type="submit" class="btn btn-primary p-5">Submit</button>
    </form>
</div>
</body>
</html>