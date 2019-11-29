<?php
require("includes/common.php");
// Redirects the user to products page if logged in.
if (isset($_SESSION['email'])) {
    header('location: product.php');
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Lifestyle Store</title>


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width initial-scale=1" >
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
            <!--https://getbootstrap.com/components/#glyphicons-->
          <<?php 
        include("includes/header.php")
         ?>
        <div class="container" >
            <div class="row row_style" >
                <div class="col-xs-6" >
                   
                    <div class="panel panel-primary" >
                        <div class="panel-heading" >
                            
                        </div>
                        <div class="panel-body" >
                            <p class="text-warning" >Login to purchase</p>
                            <form method="POST" action="login_submit.php" >
                                <div class="form-group" >
                                <input type="text" name="email" class="form-control" placeholder="email" required="true" ><br>
                                </div>
                                <div class="form-group" >
                                <input type="password" name="password" class="form-control" placeholder="password" required="true" ></div><br>
                                <input type="submit" value="Submit" class="btn btn-primary btn-block" >

                            </form>
                        </div>
                        <div class="panel-footer" >
                            <p>Don't have an account?<a href="signup.php"> Register?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <!--footer------>
        <?php 
            include("includes/footer.php")
         ?>
    </body>
</html>