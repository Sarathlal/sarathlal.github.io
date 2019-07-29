<?php
// Fetching variables of the form
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$payment_option = $_POST['support-type'];
$content = $_POST['content'];
$page_url = $_POST['page-url'];
$website = $_POST['z-website'];
if(empty($website)) {
if($name !='' && $email !='' && $subject !='' && $content !='' && $page_url !='') {

define('MAILGUN_URL', 'https://api.mailgun.net/v3/mg.sarathlal.com');
define('MAILGUN_KEY', 'key-ba649f6b3632458ca45994c10d447b18'); 
function send_mail($to,$toname,$mailfromnane,$mailfrom,$subject,$html,$replyto){
    $array_data = array(
		'from'=> $mailfromname .'<'.$mailfrom.'>',
		'to'=>$toname.'<'.$to.'>',
		'subject'=>$subject,
		'html'=>$html,
		'h:Reply-To'=>$replyto
    );
    $session = curl_init(MAILGUN_URL.'/messages');
    curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  	curl_setopt($session, CURLOPT_USERPWD, 'api:'.MAILGUN_KEY);
    curl_setopt($session, CURLOPT_POST, true);
    curl_setopt($session, CURLOPT_POSTFIELDS, $array_data);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_ENCODING, 'UTF-8');
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($session);
    curl_close($session);
    $results = json_decode($response, true);
    return $results;
}

$new_subject = $subject . " - " . $payment_option;

$result = send_mail("hello@sarathlal.com","Sarathlal N", $name, $email, $new_subject, $content, $email);

if($result) { ?>
<script>
window.setTimeout(function() {
    window.location = '<?php echo $page_url; ?>';
  }, 5000);
</script>
<p>Message has been sent. You will redirect to page with in few seconds.</p>
<p><a href="<?php echo $page_url; ?>" title="Return Back">Return Back</a></p>
<?php	
} else {?>
<script>
window.setTimeout(function() {
    window.location = '<?php echo $page_url; ?>';
  }, 5000);
</script>
<p>Message not delivered. You will redirect to page & try one more.</p>
<p><a href="<?php echo $page_url; ?>" title="Return Back">Return Back</a></p>
<?php
}
} else { ?>
	<p>Please fill the form & come back again...</p>
<?php
}
} else { ?>
<script>
window.setTimeout(function() {
    window.location = '<?php echo $page_url; ?>';
  }, 5000);
</script>
<p>Message has been sent. You will redirect to page with in few seconds. :-)</p>
<p><a href="<?php echo $page_url; ?>" title="Return Back">Return Back</a></p>
<?php } ?>
