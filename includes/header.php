<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div class="navbar navbar-inverse navbar-fixed-top">     
	<div class="container">         
		<div class="navbar-header">             
			<button type="button" class="navbar-toggle" data-toggle="collapse" datatarget="#myNavbar">                 
				<span class="icon-bar"></span>                 
				<span class="icon-bar"></span>                 
				<span class="icon-bar"></span>                                     
			</button>             
			<a class="navbar-brand" href="index.php">Lifestyle Store</a>         
		</div>         
		<div class="collapse navbar-collapse" id="myNavbar">             
			<ul class="nav navbar-nav navbar-right">                 
				<?php                 
				if (isset($_SESSION['email'])) {
					?>  
					<li style="margin-top: 5px;">
					<div class="search-container">
    					<form action="search.php" method="GET">
      						<input type="text" placeholder="Search.." name="search">
      						<button type="submit" name="submit"><i class="fa fa-search"></i></button>
    					</form>
  					</div> 
  					</li>                                    
					<li><a href = "cart.php"><span class = "glyphicon glyphicon-shoppingcart"></span> Cart </a></li>                     
					<!--<li><a href = "settings.php"><span class = "glyphicon glyphicon-user"></span>Measurements</a></li> -->
					
                                        
 						<li><div class="dropdown" style="margin-top: 5px;">
    					<button class="btn dropdown-toggle" type="button"  width="10%" data-toggle="dropdown">Measurements
    						<span class="caret"></span></button>
    						<ul class="dropdown-menu">
      							
      							<li><a href="newuser.php">Add User</a></li>
    						</ul>
  						</div>
  					</li>
					           
					<li><a href = "logout.php"><span class = "glyphicon glyphicon-log-in"></span> Logout</a></li>                     
					?>                     
					<?php
					  } else {                     
					  	?>                     
					  	<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>                     

					  	<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>                         
					  	<?php                     
					  }                     
					  ?>             
					</ul>         
				</div>     
			</div> 
		</div> 
  