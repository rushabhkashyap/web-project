<!DOCTYPE html>
  <head>
     <title> Contacts </title> 
	   
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
							<li>1. Log in using your gmail account</li>
							<li>2. Sign up </li>
							<li>3. Retrieve your contacts from gmail</li>
							
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
							<a class="button" href="http://localhost/gapp/login.php">
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
$sCallback = 'http://localhost/gapp/contact.php'; 
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

	function curl_file_get_contents($url)
{
 $curl = curl_init();
 $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
 
 curl_setopt($curl,CURLOPT_URL,$url); //The URL to fetch. This can also be set when initializing a session with curl_init().
 curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
 curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5); //The number of seconds to wait while trying to connect.	
 
 curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
 curl_setopt($curl, CURLOPT_FAILONERROR, TRUE); //To fail silently if the HTTP code returned is greater than or equal to 400.
 curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
 curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
 curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.	
 
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
 
 $contents = curl_exec($curl);
 curl_close($curl);
 return $contents;
}

?>


				<article>
					<div class="heading">
						<?php if ($sStep == 'auth'): ?>
                            <h2></h2>
                            <p class="info"> Click below in order to fetch the contacts </p>
							<p class="more">
							<a class="button" href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oAuth->rfc3986_decode($oRequestToken['oauth_token']) ?>"> Check Authorization </a>
                            </p>
						<?php elseif ($sStep == 'fetch_contacts'): ?>
                            <h3></h3>
                            
                        <?= $sContacts ?>
                        <?php endif ?>
					    <?php 
						     /*
							 $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$iMaxResults.'&alt=json&v=3.0&oauth_token='.$sDecodedToken;
                             $xmlresponse =  curl_file_get_contents($url);
 
                             $temp = json_decode($xmlresponse,true);
                             if (!empty($temp)) 
							 {
                              foreach($temp['feed']['entry'] as $cnt)
   							    {
	                           echo $cnt['title']['$t'] . " --- " . $cnt['gd$email']['0']['address'] . "</br>";
                                }
							 }	
                             	*/					 
                        ?> 
					</div>
					<br/>					
				</article>
				
				<article>
					<div class="heading">
						
                            <h2></h2>
                            
                            <?php echo $contact['feed']['entry'][0]['gd$email'][0]['address']; ?>
                       
                        
					</div>
					<br/>					
				</article>
		</div>
	</div>	
</div>
</html>
