<?php 
    include("includes/common.php");
    if (!isset($_SESSION['email'])) {
    header('location: index.php');
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

        <script>

            function getclickdata(data)
            {
                console.log(data)
                var xhr = new XMLHttpRequest();
                var url = "http://127.0.0.1:5000/";
                console.log(url);
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    console.log("hello")
                    // if (xhr.readyState === 4 && xhr.status === 200) {
                    //     var json = JSON.parse(xhr.responseText);
                    //     console.log(json);
                    //     return json;
                       
                    // }
                };
                xhr.send(data);
            }

          </script> 


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <meta name="viewport" content="width=device-width initial-scale=1" >
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="styles.css">

    </head>
    <body>
            <!--https://getbootstrap.com/components/#glyphicons-->
        <?php 
        include("includes/header.php");
        //include("includes/check-if-added.php");
         ?>
        <div class="container" >
            <div class="jumbotron" >
                <h1>Welcome to our Lifestyle Store</h1>
                <p>We have the best dresses,t-shirts,pants,coats and ethnic wears.We have it all in one place.</p>
            </div>
        </div>
        
        <?php
//session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
    case "add":

        if(!empty($_POST["quantity"])) {
            $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
            $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
            $c=$productByCode[0]["code"];
            echo "<script type='text/javascript'> getclickdata('$c'); </script>";
            
            if(!empty($_SESSION["cart_item"])) {

                if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                    }
                } else {
                    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                }
            } else {
                $_SESSION["cart_item"] = $itemArray;
            }

        }

    break;
    case "remove":
        if(!empty($_SESSION["cart_item"])) {
            foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);              
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
            }
        }
    break;
    case "empty":
        unset($_SESSION["cart_item"]);
    break;  
}
}
?>
        <div id="product-grid">
    <div class="txt-heading"><h3>Dresses</h3></div>
    <?php
    $product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
    if (!empty($product_array)) { 
        foreach($product_array as $key=>$value){
            //echo "$key";
    ?>
        <div class="product-item" >
            <form method="post" action="product.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
            <div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
            <div class="product-tile-footer">
            <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
            <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction btn btn-primary" /></div>
            </div>
            </form>
        </div>
    <?php
        }
    }
    ?>
</div>
         



       <!-- <footer class="profooter">
            <div class="container" >
            <p allign="center">Copyright &copy; Lifestyle Store. All Rights Reserved.| Contact Us: +91 90000 00000</p>
            </div>
        </footer>-->
        <!--<?php include("includes/footer.php");?>-->
    </body>
    </html>