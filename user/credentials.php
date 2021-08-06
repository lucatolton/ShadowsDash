<?php
require("../require/page.php");

$userdb = mysqli_query($cpconn, "SELECT * FROM users where discord_id = '". $_SESSION["user"]->id. "'")->fetch_object();
if (isset($_POST['reset_creds'])) {
    $username = file_get_contents($_CONFIG["proto"] . $_SERVER['SERVER_NAME'] . "/api/randompassword?l=20");
    $password = file_get_contents($_CONFIG["proto"] . $_SERVER['SERVER_NAME'] . "/api/randompassword?l=20");

    $panel_id = $userdb->panel_id;

    $ch = curl_init($_CONFIG["ptero_url"] . "/api/application/users/$panel_id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_CONFIG["ptero_apikey"],
        'Content-Type: application/json',
        'Accept: application/json'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
        'username' => $username,
        'first_name' =>  $_SESSION["user"]->username,
        'last_name' => $_CONFIG["name"],
        'email' => $_SESSION["user"]->email,
        'password' => $password,
        'language' => 'en'
    )));
    $updateUserResult = curl_exec($ch);
    curl_close($ch);
    $updateUserResult = json_decode($updateUserResult, true);

    if (!isset($updateUserResult['object'])) {
        if(curl_errno($ch)){
            $_SESSION["error"] = "An error occured while doing the request: " . curl_error($ch);
        }
    }
    else {
        $cpconn->query("UPDATE users SET panel_username = '" . $username . "' WHERE discord_id = '" . $_SESSION["user"]->id . "'");
        $cpconn->query("UPDATE users SET panel_password = '$password' WHERE discord_id = '"  . $_SESSION["user"]->id . "'");
        $_SESSION["success"] = "Your password got changed successfully";
    }
}

$password = $userdb->panel_password;
$stars = "";
for ($i = 1; $i <= strlen($password); $i++) {
    $stars = $stars . "*";
}
?>
<!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Game panel credentials</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="/user/me">My account</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Game panel credentials</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-confirmpasswordreset">Regenerate your password</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row justify-content-center">
        <div class="col-lg-8 card-wrapper">
          <!-- Alerts -->
            <?php
            if (isset($_SESSION["success"])) {
                echo '<div class="alert alert-success" role="alert"><strong>Success!</strong> ' . $_SESSION["success"] . '</div>';
                unset($_SESSION["success"]);
            }
            ?>
            <?php
            if (isset($_SESSION["error"])) {
                echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> ' . $_SESSION["error"] . '</div>';
                unset($_SESSION["error"]);
            }
            ?>
          <div class="card">
            <div class="card-header">
              <h3 class="mb-0"><img src="https://i.imgur.com/WtzMfm7.png" width="30"> Your credentials</h3>
            </div>
            <div class="card-body">
                <i>Theses credentials are for access to your game panel account. Do not share theses! We recommend to enable 2FA on your account.</i>
                <br/><br/>
                <div style="text-align: center;">
                    <img src="https://i.imgur.com/1e90xFP.png" width="90"><br/>
                    <h3>Username: <code><?= $userdb->panel_username ?></code></h3>
                    <h3>Password: <code id="passwordView"><?= $stars ?></code><a href="#" onclick="viewPassword()" id="viewpassbutton" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></h3>
                    <br/><br/>
                    <a href="<?= $_CONFIG["ptero_url"] ?>" target="_blank"><button class="btn btn-primary" type="button"><i class="fas fa-external-link-alt"></i> Open game panel</button></a>
                </div>
            </div>
          </div>

      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
                &copy; 2021 <a href="https://shadow-baguet.xyz" class="font-weight-bold ml-1" target="_blank">X_Shadow_#5962</a> - Theme by <a href="https://creativetim.com" target="_blank">Creative Tim</a>
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
        <div class="modal fade" id="modal-confirmpasswordreset" tabindex="-1" role="dialog" aria-labelledby="modal-confirmpasswordreset" aria-hidden="true">
            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                <div class="modal-content bg-gradient-danger">

                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-notification">We need your confirmation</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="py-3 text-center">
                            <img src="https://i.imgur.com/oPhz3k5.png" width="90">
                            <h4 class="heading mt-4">Are you sure?</h4>
                            <p>This will change your password. You'll be logged out of every device your account is connected to.</p>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <form method="POST">
                            <button name="reset_creds" type="button" class="btn btn-white">Confirm</button>
                        </form>
                        <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script>
      var viewingPassword = false;
      function viewPassword() {
          if (!viewingPassword) {
              document.getElementById('passwordView').innerHTML = "<?= $password ?>";
              document.getElementById('viewpassbutton').innerHTML = '<i class="fas fa-eye-slash"></i>';
              viewingPassword = true;
          } else {
              document.getElementById('passwordView').innerHTML = "<?= $stars ?>";
              document.getElementById('viewpassbutton').innerHTML = '<i class="fas fa-eye"></i>';
              viewingPassword = false;
          }
      }
  </script>
  <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/vendor/js-cookie/js.cookie.js"></script>
  <script src="/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="/assets/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>
  <!-- Argon JS -->
  <script src="/assets/js/argon.js?v=1.2.0"></script>
  <!-- Demo JS - remove this in your project -->
  <script src="/assets/js/demo.min.js"></script>
</div>

</html>