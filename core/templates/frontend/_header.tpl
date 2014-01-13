<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="[[description]]">
    <meta name="author" content="[[author]]">
    <title>[[title]]</title>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <!--[if IE 7]>
      <link rel="stylesheet" href="/css/font-awesome-ie7.css">
    <![endif]-->
    <link rel="stylesheet" href="/css/application.css">

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Project name</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="/public/about">About</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>


          <div class="navbar-right navbar-btn btn-group">
            <?php if ( $me ) { ?>
              <a href="/user/profile" class="btn btn-success">
                <i class="icon-info-sign"></i>
                <?php echo $me->email; ?>
              </a>
              <a href="/auth/logout" class="btn btn-warning">
                <i class="icon-signout"></i>
                Sign out
              </a>
            <?php } else { ?>
              <a href="/auth/login" class="btn btn-success">
                <i class="icon-signin"></i>
                Sign in
              </a>
            <?php } ?>
          </div>


        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="container">
