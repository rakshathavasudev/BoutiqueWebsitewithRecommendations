<?php
require("includes/common.php");
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
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
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
       
        <?php
//session_start();
        include("includes/header.php");
        //include("includes/check-if-added.php");
         
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
    case "add":

        if(!empty($_POST["quantity"])) {


            $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
            $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
            
            
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
        <div id="shopping-cart">
<div class="txt-heading">Shopping Cart</div>

<a id="btnEmpty" href="cart.php?action=empty">Empty Cart</a>
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>  

<table class="tbl-cart" cellpadding="20" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Select User</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>  

<?php  
    //echo $_SESSION["cart_item"];  
    $items = array();  
    foreach ($_SESSION["cart_item"] as $item){
        array_push($items,$item["code"]);
        //echo $item["code"];
        $query =  "INSERT INTO user_items (code) VALUES ('" . $item["code"] . "' )";
        mysqli_query($con, $query) or die(mysqli_error($con));
        $item_price = $item["quantity"]*$item["price"];
        ?>
                <tr>
                <td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
                <td style="text-align: left;"><!--<div class="dropdown">
                        <button class="btn dropdown-toggle" type="button"  width="10%" data-toggle="dropdown">Select User
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <table>-->
                                    <select>
                                 <?php $query =  "SELECT * FROM newusers";
                                 $result=mysqli_query($con, $query) or die(mysqli_error($con));
                                 $num = mysqli_num_rows($result);
                                 while($resultarray=mysqli_fetch_array($result)){
                                    
                                    
                                    echo "<option>".($resultarray['name'])."</option>";
                                    
                                 } ?>         
                               <!-- </table> 
                            </ul>
                        </div>--></select></td>
                
                <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                <td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
                <td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
                <td style="text-align:center;"><a href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
                </tr>
                <?php
                $total_quantity += $item["quantity"];
                $total_price += ($item["price"]*$item["quantity"]);

        }
        
        
            //print_r($items);
        
        ?>

      <script type="text/javascript">
   
         //var movies = <?php echo json_encode($items); ?>
    
     //var list= getrecdata(movies);

         //console.log("hello",list);
  //       <?php 
  //       $someJSON = JSON.stringify(list); 

  // // Convert JSON string to Array
  //       $someArray = json_decode($someJSON, true);
  //       print_r($someArray);        // Dump all data of the Array
  //        echo $someArray[0]["prodname"]; // Access Array data
  //           ?>

        </script>

        <script>

            function addrecdata()
            {   
                var final_rec;
                var xhr = new XMLHttpRequest();
                var url = "http://127.0.0.1:5000/rec/";
                console.log(url);
                xhr.open("GET", url, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    console.log("hello")
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var json = JSON.parse(xhr.response);
                        //console.log(json)\
                        var mystring="";
                        for(var keys in json)
                        {
                            //console.log(json[keys]["Product_Name"]);
                            
mystring+= '<div id="demo" style="color:black;background-color: #A9A9A9;padding:20px;margin:10px;">'+json[keys]["Product_Name"]+'</br>'+'<img src="'+json[keys]["IMG"]+'"/>'+'</br>'+json[keys]["Price"]+'</div>';
        

                    }
                         document.getElementById("demo").innerHTML=mystring;
                        
                       

                       
                    }
                
                };
              
                xhr.send();
            }
            addrecdata();
            
          </script> 
    
    
<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>        
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>
</div>

<a  href="success.php?action=empty"><div class="btn btn-primary">Place Order
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
} ?></div> </a>
</br></br>
<div class="btn btn-danger">Recommendations</div>
<div id="demo"></div>

        <!--<?php include("includes/footer.php"); ?>-->
    </body>
</html>




