



<div id="alert" class="alert alert-danger red-text text-center" role="alert">
          <?php
          echo $_SESSION['error'];
          unset($_SESSION['error']);
          ?>
        </div>