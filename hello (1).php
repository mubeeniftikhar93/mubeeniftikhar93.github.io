<?php

$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody);
$req_dump = print_r($_POST, true);
$myfile = fopen("covessa.txt", "a") or die("Unable to open file!");
$val = $data->params->TFID->value;
echo 'post is done';

$str_arr = explode (',', $val);
$string = '<<<';
$total = (sizeof($str_arr)-1);
for ($i=0; $i<=$total; $i++)
{
    if (strpos($str_arr[$i], $string) !== FALSE) { 
    unset($str_arr[$i]);
 }
    }
fwrite($myfile, $val);
fclose($myfile);
// $val = array("$val");
for ($i=0; $i<count($str_arr); $i++) {    
$url = "https://api.glideapp.io/api/function/mutateTables";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer e0d66f6a-f210-422d-8df6-1f62d5c4783e"
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
    "appID": "C34ss53WDJnXeenSrXr6",
    "mutations": [
        {
            "kind": "delete-row",
            "tableName": "native-table-9wWTR8VRlbaBmjX4YcRr",
            "rowID": "$str_arr[$i]"
        }
    ]
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);    
}    

?>