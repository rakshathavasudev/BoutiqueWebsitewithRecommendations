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
include("includes/header.php");
       $button = $_GET [ 'submit' ]; 
       $search = $_GET [ 'search' ]; 
 
       /*if( !$button )
             echo "you didn't submit a keyword";
       else {*/
             if( strlen( $search ) <= 1 )
                    echo "Search term too short";
             else {
                    echo "You searched for <b> $search </b> <hr size='1' > </ br > ";
                    $conn=mysqli_connect( "localhost","root","","store") ; 
                    /*mysqli_select_db("store");*/
 
                    $search_exploded = explode ( " ", $search );
                    /*print_r ($search_exploded);
                    $x = 0; 
                    foreach( $search_exploded as $search_each ) {
                           $x++;
                           $construct = "";
                           if( $x == 1 )
                                  $construct .="keywords LIKE '%$search_each%'";
                           else
                                  $construct .= "LIKE '%$search_each%' ";
                    }
                    print_r($construct);*/
                    $construct = " SELECT * FROM tblproduct WHERE name like '%$search%' ";
                    
                    $run = mysqli_query( $conn,$construct );

                    $foundnum = mysqli_num_rows($run);
 
                    if ($foundnum == 0)
                           echo "Sorry, there are no matching result for <b> $search </b>. </br> </br> 1. Try more general words. for example: If you want to search 'how to create a website' then use general keyword like 'create' 'website' </br> 2. Try different words with similar  meaning </br> 3. Please check your spelling"; 
                    else {
                           echo "$foundnum results found !<p>";
 
                           while( $runrows = mysqli_fetch_assoc($run ) ) {
                                  $title = $runrows ['name'];
                                  $desc = $runrows ['code'];
                                  $url = $runrows ['image'];
 
                                  echo "<a href='product.php?action=add&code='> <b> $title </b> <p> <br> $desc <br> <img src='$url' $url  <p>";
                                
 
                           }
                    }
 
             }?>
     
</body>
</html>>