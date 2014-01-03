<html>
  <head>
     <title> Login </title>
	 
	 <link rel="stylesheet" href="css/style.css">
	 <link rel="stylesheet" href="css/zerogrid.css">
	 <link rel="stylesheet" href="css/responsiveslides.css" />
	 <link rel="stylesheet" href="css/responsive.css">
	 
   </head>
   
   <header> 
	<!--<div class="zerogrid"><h1>Wecome
		<div class="row">
			<div class="col05">
				
			</div>
			<div class="col06 offset05">
			   
			</div>
		</div>
	</div>--><div class="zerogrid"><div class="heading">Welcome to G-app</div></div>
    </header>
	
	<section id="content">
	<div class="zerogrid">
		<div class="row block">
			
			<div class="featured col16">
				<!--<div class="rslides_container">
					<ul class="rslides" id="slider">
						
					</ul>
				</div>-->
			</div>
			<div class="sidebar col05">
				<section>
					<div class="heading">About creator</div>
					<div class="content">
						R.V.College of Engineering <br/> Department of ISE
					</div>
				</section>
				<section>
					<div class="heading">you can</div>
					<div class="content">
						<ol>
							<li>1. Log in through gmail </li>
							<li>2. Retrieve your contacts from gmail </li>
							<li>3. View account Information</li>
							
						</ol>
						<br/>
					</div>
				</section>
				
				<section>
					<div class="heading"></div>
					<div class="content">
						<section>
							
							<h4></h4>
							<p> Log out from your google account</p> <br/>
							<a class="button" href="https://www.google.com/accounts/Logout"target="_blank">
							
							Logout from Google</a>
							
							<br/>
						</section>
						<section>
							
							<h4></h4>
							<p> </p>
							<br/>
							<br/>
						</section>
						
					</div>
				</section>
			</div>
   
    <div class="main-content col11">
				
				<article>
					<div class="heading">
						<h2>G-app Login </h2>
						<p class="info">-by rdk </p>
					</div>
					<div class="content">
								
						<p>Click below to login through your Gmail account </p>
						<br/>
						
						 <form id="login" action="?login" method="post"> 
                         <button class="button">Login with Google</button>
                         </form>
						
					</div>
				</article>
				
				<article>
					<div class="heading">
						<h2>Retrieve your contacts from gmail account</h2>
						<p class="info"> <br/> <br/> 
						<p class="more"> Click here to fetch your contacts list <br/>
						<a class="button" href="contact.php"> Go</a>
						</p>
						</p>
					</div>
					<br/>					
				</article>
				
				<article>
					<div class="heading">
						<h2>Your account Info</h2>
						<p class="info"> If it interests you, to view your log in credentials, with details of your own ID in gmail <br/> <br/> 
						<p class="more">  Click here <br/>
						<a class="button" href="info.php">Go </a>
						</p>
						</p>
					</div>
					<br/>					
				</article>
		</div>
	</div>	
</div>

<article>
	    <div class = "heading">
		  		
<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'openid.php';
try {
    $openid = new LightOpenID('localhost');
    if(!$openid->mode) 
	{
        if(isset($_GET['login'])) 
		{
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            header('Location: ' . $openid->authUrl());
        }
    }	  
	
	elseif($openid->mode == 'cancel') 
	{
        echo 'User has canceled authentication!';
    }
	else 
	 {  
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
     }
	} 
	catch(ErrorException $e) 
	{
    echo $e->getMessage();
    }
?>
	    </div>
	</article>
	
<article>
    <div class ="heading">
	
<?php
try {
    
    $openid = new LightOpenID('localhost');
    if(!$openid->mode) 
	{
        if(isset($_POST['openid_identifier'])) 
		{
            $openid->identity = $_POST['openid_identifier'];
            # The following two lines request email, full name, and a nickname
            # from the provider. Remove them if you don't need that data.
            $openid->required = array('contact/email');
            $openid->optional = array('namePerson/first','namePerson','namePerson/friendly');
			
            header('Location: ' . $openid->authUrl());
        }
		
    } 

	elseif($openid->mode == 'cancel') 
	    {
        echo 'User has canceled authentication!';
        } else 
		   {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
	    print_r($openid->getAttributes());
	
           }
    }
    	
catch(ErrorException $e) 
{
    echo $e->getMessage();
}
?>
    </div>
</article>

</html>	
