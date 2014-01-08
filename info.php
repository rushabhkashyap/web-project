<?php

?>

<!DOCTYPE html>
  <head>
     <title> Information </title> 
	   
	 <link rel="stylesheet" href="style.css">
	 <link rel="stylesheet" href="zerogrid.css">
	 <link rel="stylesheet" href="responsiveslides.css" />
	 <link rel="stylesheet" href="responsive.css">

<style>

 .eventTime {
    color:#0CF;
 }

 .eventTitle {
    color:#0FC; 
 }

 </style>
	 
   </head>
   
   <header> 
	<!--<div class="zerogrid"><h1>Wecome
		<div class="row">
			<div class="col05">
				
			</div>
			<div class="col06 offset05">
			   
			</div>
		</div>
	</div>--><div class="zerogrid"><div class="heading"></div></div>
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
							<p> Log out from your google account</p>
							<a class="button" href="https://www.google.com/accounts/Logout"target="_blank">
							
							Logout from Google </a>
							
							<br/>
						</section>
						<section>
							
							<h4></h4>
							<p><h4>Go to login page</h4></p>
							<a class="button"  href="login.php">Login </a>
						
						</section>
						
					</div>
				</section>
			</div>
   
            <div class="main-content col11">
				
				<article>
					<div class="heading">
						<h2>Log in Details</h2>

<?php
require 'openid.php';
						
try
{
    
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
     
    //Not already logged in
    if(!$openid->mode)
    {
        //The google openid url
        $openid->identity = 'https://www.google.com/accounts/o8/id';
         
        //Get additional google account information about the user , name , email , country
        $openid->required = array('contact/email' , 'namePerson/first' , 'namePerson/last' , 'pref/language' , 'contact/country/home'); 
         
        //start discovery
        header('Location: ' . $openid->authUrl());
    }
     
    else if($openid->mode == 'cancel')
    {
        echo 'User has canceled authentication!';
        //redirect back to login page ??
    }
     
    //Echo login information by default
    else
    {
        if($openid->validate())
        {
            //User logged in
            $d = $openid->getAttributes();
             
            $first_name = $d['namePerson/first'];
            $last_name = $d['namePerson/last'];
            $email = $d['contact/email'];
            $language_code = $d['pref/language'];
            $country_code = $d['contact/country/home'];
		/*	$birthdate = $d['birthDate/dob'];
            $gender = $d['person/gender'];
            $pincode = $d['contact/postalCode/home'];
		    $timezone = $d['pref/timezone'];
             
              $data = array(
                'first_name' => $first_name ,
                'last_name' => $last_name ,
                'email' => $email ,  
            );
              */
                foreach($d as $attr => $val)
                  print (" $attr : $val <br/>");
				  
    
        }
        else
        {
            // do nothing
        }
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
					<div class="heading">
						<h2>Your calendar</h2>
<?php 
/* 
$email = $d['contact/email'];
$url = "http://www.google.com/calendar/feeds/".$email."/public/full";
$xml = file_get_contents($url);

$feed = simplexml_load_string($xml);
$ns = $feed->getNamespaces(true);

 foreach ($feed->entry as $entry) {
    $when=$entry->children($ns["gd"]);
    $when_atr=$when->when[0]->attributes();

    $title=$entry->title;
    echo "<div class='eventTitle'>".$title . "</div>";

    $start = new DateTime($when_atr['startTime']);
    echo "<div class='eventTime'>".$start->format('D F jS, g:ia') . " to ";    

    $end = new DateTime($when_atr['endTime']);
    echo $end->format('g:ia')."</div>" . '<br />' ;    
}
*/
 ?> 
			
									
				</article>
            </div>
	    </div>	
    </div>
</html>






