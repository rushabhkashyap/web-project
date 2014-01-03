
<?php
/* function process_signup_login($data)
{
    $email = $data['email'];
    $username = $data['username'];
    $source = $data['source'];
     
   // $result = $this->db->get_where('users' , array('email' => $email));
     
        //if the user already exists , then log him in rightaway
    if($result->num_rows() > 0)
    {
        //already registered , just login him
        $row = $result->row_array();
        $this->do_login($row);
    }
        //new user, first sign him up, then log him in
    else
    {
        //register him , and login
        $toi = array(
            'email' => $email ,
            'username' => $username ,
            'password' => md5($this->new_password()) ,
            'source' => $source ,
        );
         
        $this->db->insert('users' , $toi);
         
        $result = $this->db->get_where('users' , array('email' => $email));
         
        if($result->num_rows() > 0)
        {
            $row = $result->row_array();
            $this->do_login($row);
        }
    }
     
        //redirect to somewhere
    redirect(site_url());
}
 
/**
    Do login taking a row of resultset
*/ /*
function do_login($row)
{
    session_set('uid' , $row['id']);
    session_set('email' , $row['email']);
    session_set('logged_in' , true);
     
    return true;
}
 */
?>

<!DOCTYPE html>
  <head>
     <title> Information </title> 
	   
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
							<p> Log out from your google account</p>
							<a class="button" href="https://www.google.com/accounts/Logout"target="_blank">
							
							Logout from Google </a>
							
							<br/>
						</section>
						<section>
							
							<h4></h4>
							<p><h4>Go to login page</h4></p>
							<a class="button"  href="http://localhost/gapp/login.php">Login </a>
						
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
				  
                        
          //  process_signup_login($data);
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
			<iframe src="https://www.google.com/calendar/embed?src=<?php $d['contact/email']; ?>%40gmail.com&ctz=Asia/Calcutta" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>			
									
				</article>
            </div>
	    </div>	
    </div>
</html>






