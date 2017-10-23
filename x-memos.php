<?php session_start();
if(!isset($_SESSION['username'])){
  header("Location: index.php");
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>X-Memo</title>

    <!-- Minified CSS -->
    <!-- BULMA CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Sweet Alert 2 CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />

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
        <a class="navbar-item" href="#">
          <b>X-Memo</b>
        </a>

        <div class="navbar-burger burger" data-target="xMemoNavbar">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>

      <div id="xMemoNavbar" class="navbar-menu">
        <a class="navbar-item " href="#">
          Home
        </a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="field is-grouped">
            <p class="control">
              <a data-target="#modal" class="button is-primary modal-button"><b>Add Memo</b>
              </a>
            </p>
            <p class="control">
              <a class="navbar-item" href="logout.php">Logout
                <span class="icon">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
                </span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </nav>
    <!-- Hero example from https://bulma.io/documentation/layout/hero/ -->
    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <h1 class="title">
            X-Memo
          </h1>
          <h2 class="subtitle">
            An XML database of memos
          </h2>
        </div>
      </div>
    </section>
  
    <!-- Modal examples adapted from https://bulma.io/documentation/components/modal/ -->
    <!-- ADD MODAL -->
    <div id="modal" class="modal">
      <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Add X-Memo</p>
            <button class="delete" id="delete" aria-label="close"></button>
          </header>
          <section class="modal-card-body">
            <form class="form-memo" action="addMemo.php" method="POST">
              <div class="field">
                <label class="label">Memo Title (*)</label>
                <div class="control">
                  <input class="input" type="text" placeholder="Memo title" id="title" required>
                </div>
              </div>
              <div class="field">
                <div class="control">
                  <input type="hidden" class="input" id="senderModalSelect" value=" " readonly>
                </div>
              </div>
              <div class="field">
                <label class="label">Recipient (*)</label>
                <div class="control">
                  <div class="select is-multiple is-small">
                    <select multiple id="recipientsModalSelect" required></select>
                  </div>
                </div>
              </div>
              <div class="field">
                <label class="label">Memo Summary (*)</label>
                <textarea id="summary" placeholder="Enter your x-memo content..." class="textarea" required></textarea>
              </div>
              <div>
                <label class="label">Associated URL</label>
                <input class="input" type="text" placeholder="Associated URL" id="url">
              </div>        
              <input type="hidden" id="date" placeholder="Date" value=<?php echo date('d/m/Y')?> readonly>
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success modal-save" type="submit">Save changes</button>
            </form>
            <button class="button cancelAdd" id="cancelAdd">Cancel</button>
          </footer>
            
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div id="updateModal" class="modal">
      <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Update X-Memo</p>
            <button class="delete cancelEdit" id="delete" aria-label="close"></button>
          </header>
          <section class="modal-card-body">
            <form class="form-update" action="editMemo.php" method="POST">          
              <input type="hidden" name="updateID" id="updateID" name="updateID" value=" ">
              <div class="field">
                <label class="label">Update Title (*)</label>
                <input class="input" type="text" placeholder="Memo Title" name="updateTitle" id="updateTitle" value=" " required>
              </div> 
              <div class="field">
                <label class="label">Update Summary (*)</label>
                <textarea name="updateSummary" id="updateSummary" value=" " class="textarea" required></textarea>
              </div>

              <div class="field">
                <label class="label">Update Associated URL</label>
                <input class="input" type="text" placeholder="Associated URL" name="updateURL" id="updateURL" value=" ">
              </div> 
              <br>
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success modal-save" type="submit">Save changes</button>
            </form>
            <button class="button cancelEdit" id="cancelEdit">Cancel</button>
          </footer>
            
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div id="deleteModal" class="modal">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Delete X-Memo</p>
          <button class="delete cancelDelete" id="delete" aria-label="close"></button>
        </header>

        <section class="modal-card-body">
          <form class="form-delete" action="deleteMemo.php" method="POST">
            <h2 class="form-signin-heading">Delete X-Memo</h2>
            <input type="hidden" name="deleteID" id="deleteID" value=" ">
            <br>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success modal-save" type="submit">Delete Memo</button>
        </footer>
          </form>
      </div>
    </div>


    <div class="card" style="padding-bottom:1.5rem !important">
      <div class="card-content">
        <!-- DROPDOWN SECTION - Dropdowns using classes from 'select2.js'-->
        <div class="container column box">
          <div class="columns">
            <div class="container column">
              <label class="label" for="senderDropdown">Author:</label>
              <select id="senderDropdown" class="js-example-basic-single" style="width:100% !important" value></select>
            </div>
            <div class="container column">
              <label class="label" for="recipientsDropdown">Recipient:</label>
              <select class="js-example-basic-single" style="width:100% !important" id="recipientsDropdown" name="recipient[]" value></select>
            </div>
            <div class="container column">
              <label class="label" for="memoid">Memo ID:</label>
              <select  class="js-example-basic-single" style="width:100% !important" id="memoid" value></select>
            </div>
            <div class="container column">
              <label class="label" for="dateSelect">Date:</label>
              <select class="js-example-basic-single" style="width:100% !important" id="dateSelect" value></select>
            </div>
            <div class="container column">
              <label class="label" for="titleSelect">Title:</label>
              <select class="js-example-basic-single" style="width:100% !important" id="titleSelect" value></select>
            </div>
          </div>

          <a class="button is-danger is-outlined" id="resetDropdowns" type="submit">Reset Dropdowns</a><br><br>

          <!-- Provides a column to hold memos - targeted through jQuery -->
          <!-- MEMOS SECTION -->
          <div class="column" id="memos"></div>
          <div id="noMemosFound"></div>
        </div>
      </div>
    </div>
    <br>

    <!-- jQuery & Javascript -->
    <!-- External JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.js"></script>
    <script src="https://use.fontawesome.com/9dc33453f7.js"></script>
    
    <!-- Memo-related JS -->
    <script src="js/getValues.js"></script>
    <script src="js/retrieveUserMemos.js"></script>

    <!-- See custom.js - Needed to create my own Javascript/jQuery for certain aspects of the project as Bulma currently doesn't have an associated JS file for their CSS. I found out how to add classes to the target element online however I cannot find the link again -->
    <script src="js/custom.js"></script>
    <script src="js/createDisplayMemos.js"></script>
    <script src="js/editMemos.js"></script>
    <script src="js/addMemos.js"></script>
    <script src="js/deleteMemos.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //Initialises select2.js
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
      });
    </script>
  </body>
</html>
