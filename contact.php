<!DOCTYPE html>
  <head>
     <title> Contacts </title> 
	   
	 <link rel="stylesheet" href="style.css">
	 <link rel="stylesheet" href="zerogrid.css">
	 <link rel="stylesheet" href="responsiveslides.css" />
	 <link rel="stylesheet" href="responsive.css">
	 
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
							
							Logout from Google</a>
							
							<br/>
						</section>
						<section>
							
							<h4></h4>
							<p><h4>Go to login page</h4></p>
							<a class="button" href="login.php">
							Login
							</a>
						
						</section>
						
					</div>
				</section>
			</div>
   
    <div class="main-content col11">
				
				<article>
					<div class="heading">
						<h2>Contacts</h2>		
					</div>
				</article>

<?php

// disable warnings
if (version_compare(phpversion(), "5.3.0", ">=")  == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE); 

$sClientId = '378103376714.apps.googleusercontent.com';
$sClientSecret = 'l7c-EjPp22VD6khGkJZo5WQ5';
$sCallback = 'http://redriderapps.net46.net/contact.php'; 
$iMaxResults = 30; // max results
$sStep = 'auth'; // current step

// include GmailOath library  https://code.google.com/p/rspsms/source/browse/trunk/system/plugins/GmailContacts/GmailOath.php?r=11
include_once('GmailOath.php');


session_start();

// prepare new instances of GmailOath  and GmailGetContacts
$oAuth = new GmailOath($sClientId, $sClientSecret, $argarray, false, $sCallback);
$oGetContacts = new GmailGetContacts();

if ($_GET && $_GET['oauth_token']) 
{

    $sStep = 'fetch_contacts'; // fetch contacts step

    // decode request token and secret
    $sDecodedToken = $oAuth->rfc3986_decode($_GET['oauth_token']);
    $sDecodedTokenSecret = $oAuth->rfc3986_decode($_SESSION['oauth_token_secret']);

    // get 'oauth_verifier'
    $oAuthVerifier = $oAuth->rfc3986_decode($_GET['oauth_verifier']);

    // prepare access token, decode it, and obtain contact list
    $oAccessToken = $oGetContacts->get_access_token($oAuth, $sDecodedToken, $sDecodedTokenSecret, $oAuthVerifier, false, true, true);
    $sAccessToken = $oAuth->rfc3986_decode($oAccessToken['oauth_token']);
    $sAccessTokenSecret = $oAuth->rfc3986_decode($oAccessToken['oauth_token_secret']);
    $aContacts = $oGetContacts->GetContacts($oAuth, $sAccessToken, $sAccessTokenSecret, false, true, $iMaxResults);

    // turn array with contacts into html string
    $sContacts = $sContactName = '';
     
	if (is_array($aContacts) && count($aContacts))
    foreach($aContacts as $k => $aInfo) 
	{
      //  $phone1 = end($aInfo['gd$phoneNumber'][0]);
    //    $note = end($aInfo['content']);
    //   $address = end($aInfo['gd$postalAddress'][0]);
 // echo $contact['feed']['entry'][0]['gd$email'][0]['address'][0]['gd$phoneNumber'][0]['phone1'];
        $sContactName = end($aInfo['title']);
        $aLast = end($aContacts[$k]);
        foreach($aLast as $aEmail) {
            $sContacts .= '<p>' . $sContactName . '(' . $aEmail['address'] . ')</p>';
        }; 
    };
	
}
    else 
	{
    // prepare access token and set it into session
    $oRequestToken = $oGetContacts->get_request_token($oAuth, false, true, true);
    $_SESSION['oauth_token'] = $oRequestToken['oauth_token'];
    $_SESSION['oauth_token_secret'] = $oRequestToken['oauth_token_secret'];
    }

?>


				<article>
					<div class="heading">
						<?php   if ($sStep == 'auth'):  ?>
                            <h2></h2>
                            <p class="info"> Click below in order to fetch the contacts </p>
							<p class="more">
							<a class="button" href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oAuth->rfc3986_decode($oRequestToken['oauth_token']) ?>"> Check Authorization </a>
                            </p>
                                     <?php echo "<pre>";                //print array to console
                                           {print_r($sContacts);}
                                            echo "</pre>"; ?>
						<?php  elseif ($sStep == 'fetch_contacts'):  ?>
                            <h3></h3>
                            
                        <?= $sContacts  ?>
                        <?php  endif ?>
					    
					</div>
					<br/>					
				</article>
				
				
		</div>
	</div>	
</div>
</html>
