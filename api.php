YOUR API INFORMATION
Client ID : 2306
API Key : api66adc8929c367
API Status : active
API DOCUMENTATION
PICKUP REQUEST
You can use this endpoint directly for pickup request.

ENDPOINT	https://fardardomestic.com/api/p_request_v1.02.php
TYPE	GET OR POST
RETURN TYPE	JSON
PARAMETERS
Key	Value	Required
client_id	Your Fardar Express Domestic (PVT) LTD Client ID.	YES
api_key	Your Fardar Express Domestic (PVT) LTD API key.	YES
recipient_name	The Name of the Recipient.	YES
recipient_contact_no	The Number of the Recipient.	YES
recipient_address	The Address of the Recipient.	YES
recipient_city	The City of the Recipient.	YES
parcel_type	The Type of the Parcel.	YES
parcel_description	The Description of the Parcel.	YES
cod_amount	The COD Amount of the Parcel.	YES
order_id	The orderID (Invoice ID/ Reference No) of the Parcel.	YES
exchange	The Exchange Status of the Parcel. (1 - Exchange Parcel / 0 - Normal Parcel)	YES


RESPONSE SAMPLE
{
"status": 204,
"waybill_no": "100000"
}

RESPONSE PARAMETERS
Key	Description
status	Your Status Code
waybill_no	Your Inserted Waybill Number
STATUS CODE LIST
HTTP Response	Response
201	Inactive Client API Status
202	Invalid Apikey
203	Not Added the Parcel
204	Successfully Added the Parcel
205	Recipient Name Is Empty
206	Recipient Contact Number Is Empty
207	Recipient Address Is Empty
208	Recipient Contact Number is Invalid
209	Recipient City Is Empty
210	Parcel Type Is Empty
211	Parcel Type Is Not a Number
212	Parcel Description Is Empty
218	Recipient City Is Invalid
219	Parcel Type Is Not valid
220	COD amount Is Not a Number
221	Invalid COD amount. It must be greater than or equal to 0



<?php
  // pickup_request function

  function pickup_request($api_key,$client_id,$recipient_name,$recipient_contact_no,$recipient_address,$recipient_city,$parcel_type,$cod_amount,$parcel_description,$order_id,$exchange){

 // curl post

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://fardardomestic.com/api/p_request_v1.02.php");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,
  "client_id=$client_id&api_key=$api_key&recipient_name=$recipient_name&recipient_contact_no=$recipient_contact_no&recipient_address=$recipient_address&parcel_type=$parcel_type&recipient_city=$recipient_city&parcel_description=$parcel_description&cod_amount=$cod_amount&order_id=$order_id&exchange=$exchange");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  echo $server_output = curl_exec($ch);
  curl_close ($ch);

}

//call set parcel variables


$api_key               = "api66adc8929c367";
$client_id             = "2306";
$recipient_name        = "kamal";
$recipient_contact_no  = "0755555555";
$recipient_address     = "kottawa,pannipitiya";
$recipient_city        = "nugegoda";
$parcel_type           = "2";
$cod_amount            = "0";
$parcel_description    = "book";
$order_id              = "1022";
$exchange              = "0";


  //call pickup_request function


 pickup_request($api_key,$client_id,$recipient_name,$recipient_contact_no,$recipient_address,$recipient_city,$parcel_type,$cod_amount,$parcel_description,$order_id,$exchange);




?>


User ID : 27674
API Key : 8ZfgzJkzwhigCuMcWYLM
OnBeautyBar

nini
