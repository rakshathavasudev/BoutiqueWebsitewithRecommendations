<?php 
    include_once("includes/common.php");
    if (isset($_SESSION['email'])) {
        # code...
        header('location:product.php');
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
       
        <div class="container">
            <div class="row row-style" >
                <div class="col-xs-6" >
                    <br>
                    <h2 align="center" >SIGN UP</h2>

                    <form action="signup_script.php" method="POST" >
                        <div class="form-group" >
                                <input class="form-control" name="name" placeholder="Name" required="true" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$"><br>
                        </div>
                        <div class="form-group" >
                              <input type="text" class="form-control" name="email"  placeholder="Email" required="true" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" ><?php 
                                if (isset($_GET['m1'])) {
                                    # code...
                                    $m1=$_GET['m1'];
                                    echo $m1;
                                }
                               ?><br>
                        </div>
                        <div class="form-group" >
                                 <input type="password" class="form-control" name="password" placeholder="Password" required="true" pattern=".{6,}" ><br>
                        </div>
                        <div class="form-group" >
                                <input type="text" class="form-control" name="contact"  placeholder="Contact" required="true" maxlength="10" size="10"><?php 
                                if (isset($_GET['m2'])) {
                                    # code...
                                    $m2=$_GET['m2'];
                                    echo $m2; 
                                }?><br>
                                
                        </div>
                        <div class="form-group" >
                                 <input type="text" class="form-control" name="city"  required="true" placeholder="City"><br>
                        </div>
                        <div class="form-group" >
                                <input type="text" class="form-control" name="address"  required="true" placeholder="Address"><br>
                        </div>
                        <div class="form-group">
                                <input type="submit" value="Submit" class="btn btn-primary btn-block" >
                        </div>
                            </form>
                </div>
            </div>      
        </div><br>
         <!--footer------>
     
        <?php 
            include("includes/footer.php")
         ?>
         
    </body>
</html>