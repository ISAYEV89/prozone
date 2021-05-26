<!DOCTYPE html>
<html lang="en">
<?php  $site_url="http://".$_SERVER['HTTP_HOST']."/cms/"; ?>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Webcity! | </title>

    <link rel="icon" href="<?php echo $site_url; ?>template/production/images/ff.ico" type="image/ico" />
    <!-- Bootstrap -->
    <link href="<?php echo $site_url; ?>template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo $site_url; ?>template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo $site_url; ?>template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo $site_url; ?>template/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo $site_url; ?>template/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action='index.php'>
              <img style="width: 35%;" src="<?php echo $site_url; ?>/images/logoesas1.svg">
              <h1>LNS Login</h1>
              <div>
                <input name="flogin" type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input name="password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default" >Log in</button>
              <!--   <a class="reset_pass" href="#">Lost your password?</a> -->
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <!--<p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p> !-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img style="width: 12%;" src="<?php echo $site_url; ?>/images/logoesas1.svg"></h1>
                  <p>©2018 All Rights Reserved. Powered by LNS International LTD!  Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>