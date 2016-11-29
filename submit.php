<?php
$language = "en";
//extract data from the post
extract($_POST);

$savings = $debtamount * .021;
setcookie("savings", $savings);
setcookie("debtamount", $debtamount);
setcookie("firstname", $firstname);

//check for validity
if ($firstname==""||$lastname==""||$email==""||$phone_home==""||$state==""){
echo'required fields not inputted';
exit;
}
//clean up the phone number
$phone_home = preg_replace('/[^0-9]/','',$phone_home);
if ( isset($phone_work) )
  $phone_work = preg_replace('/[^0-9]/','',$phone_work);
if(strlen($phone_home)> 10||strlen($phone_home)< 10){
	echo'{ "Status": "Fail: Bad Phone number" }1';
	exit;
}

$url = 'http://leadsubmit.consolidatedcredit.org/addlead.aspx';

//set POST variables

$fields = array(
						'apikey' => 'adad11ddf0cf769fc147ec30e66dba83',
						'loginid' => '2300',
						'partnerid' => urlencode($partnerid),
						'appid' => '8',
						'jsonresponse' => 'true',
						'firstname' => urlencode($firstname),
						'lastname' => urlencode($lastname),
						'email' => urlencode($email),
						'country' => urlencode($country),
						'state' => urlencode($state),
						'debtamount' => urlencode($debtamount),
						'phone_home' => urlencode($phone_home),
						'language' => urlencode($language),
						'optout'=>'false',
						'submissionurl'=> urlencode($submissionurl),
						'ppc_keyword'=>urlencode($ppc_keyword),
						'ppc_matchtype'=>urlencode($ppc_matchtype),
						'ppc_network'=>urlencode($ppc_network),
						'ppc_placement'=>urlencode($ppc_placement),
						'ppc_adgroup'=>urlencode($ppc_adgroup),
						'ppc_adtag'=>urlencode($ppc_adtag),
						'ckm_campaign_id'=>urlencode($ckm_campaign_id),
						'ckm_key'=>urlencode($ckm_key)
          );
if (isset($phone_work))
  $fields['phone_work'] = urlencode($phone_work);
$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { 
$fields_string .= $key.'='.$value.'&'; 
}
rtrim($fields_string, '&');
/*
$fields_string = 'apikey=adad11ddf0cf769fc147ec30e66dba83&loginid=2300&partnerid=2300&appid=8&firstname=' .urlencode($firstname).'&lastname='.urlencode($lastname).'&email=' .urlencode($email).'&country=' .urlencode($country).'&state=' .urlencode($state).'&debtamount=' . urlencode($debtamount).'&phone'.$phonetype .'='. urlencode($phone);
*/

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);




//execute post
$result = curl_exec($ch);
echo $result;

//close connection
curl_close($ch);
exit;

//$result =  substr($result, 0, -1);



//$result = '{ "Status": "Fail: Duplicate Lead" }';
//$json = json_decode($result); 

//var_dump($json);
//exit;







/*
if($json->Status === "Success"){

echo $SuccessURL . '#uniqueIdforLeadTracking=' . $json->LeadID;

exit;
}
else{
echo ' no status match\n<br/> ';
var_dump($json);
exit;

}



if($result=='Success'){
header("Location:$SuccessURL");
}
if ($result=="Fail: Duplicate Lead1"){
echo '<br/>Your information is already in our system';
}
exit;


*/
?>
