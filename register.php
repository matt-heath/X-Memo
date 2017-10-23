<?php session_start();
if(isset($_SESSION['username'])){
  header('Location: x-memos.php');
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>X-Memo</title>
    
    <!-- Minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.css">

    <style type="text/css">
      html, body {
        background-color: #eee;
      }
    </style>
  </head>
  <body>
    <!-- Navbar example from https://bulma.io/documentation/components/navbar/ -->
    <nav class="navbar is-transparent" style="border-bottom: 2px solid #00d1b2">
      <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
          <b>X-Memo</b>
        </a>
        <div class="navbar-burger burger" data-target="loginNavbar">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
      <div id="loginNavbar" class="navbar-menu">
        <a class="navbar-item " href="#">
          Home
        </a>
      </div>
    </nav>
    
    <div class="container column is-half is-offset-one-quarter">
      <div class="card">
        <div class="card-content">
          <p class="title has-text-centered">
            X-Memo Register
          </p>
          <form class="form-register" action="registerUserSubmit.php" method="POST">
            <div class="field">
              <p class="control has-icons-left has-icons-right">
                <input class="input" type="text" placeholder="Name" id="name" name="name" autofocus>
                <span class="icon is-small is-left">
                  <i class="fa fa-user-circle-o"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <p class="control has-icons-left has-icons-right">
                <input class="input" type="text" placeholder="Username" id="username" name="username" autofocus>
                <span class="icon is-small is-left">
                  <i class="fa fa-user-circle-o"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="password" placeholder="Password" id="password" name="password">
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <p class="control">
                <button class="button is-success" type="submit">
                  Register User
                </button>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div> 

    <!-- jQuery & Javascript -->
    <!-- External JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.js"></script>

    <!-- Memo-related JS -->
    <script src="js/registrationCheck.js"></script>
  </body>
</html>