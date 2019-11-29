<?php 
    include_once("includes/common.php");
    if (!isset($_SESSION['email'])) {
        # code...
        header('location:index.php');
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
                    <h2 align="center" >ADD MEASUREMENTS(NEW USER)</h2>
                </br>
                    <form action="newuser_script.php" method="POST" >
                        <div class="form-group" >
                                <input class="form-control" name="name" placeholder="Name" required="true" pattern="^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$"><br>
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
                                 <input type="text" class="form-control" name="shoulder"  required="true" placeholder="Shoulder length"><br>
                        </div>
                        <div class="form-group" >
                                <input type="text" class="form-control" name="waist"  required="true" placeholder="Waist"><br>
                        </div>
                        <div class="form-group" >
                                <input type="text" class="form-control" name="chest"  required="true" placeholder="Chest"><br>
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