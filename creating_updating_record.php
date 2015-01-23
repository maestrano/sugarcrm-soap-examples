<?php

require_once __DIR__ . '/vendor/autoload.php';

$url = "http://{site_url}/service/v4_1/soap.php?wsdl";
$username = "admin";
$password = "password";

//retrieve WSDL
$client = new nusoap_client($url, 'wsdl');

//display errors
$err = $client->getError();
if ($err)
{
    echo $err;
    echo $client->getDebug();
    exit();
}

//login ----------------------------------------------------     
$login_parameters = array(
  'user_auth' => array(
    'user_name' => $username,
    'password' => md5($password),
    'version' => '1'
  ),
  'application_name' => 'SoapTest',
  'name_value_list' => array(
  ),
);

$login_result = $client->call('login', $login_parameters);
echo(json_encode($login_result));

//get session id
$session_id =  $login_result['id'];

//create account -------------------------------------     $set_entry_parameters = array(
  //session id
  "session" => $session_id,

  //The name of the module from which to retrieve records.
  "module_name" => "Accounts",

  //Record attributes
  "name_value_list" => array(
    //to update a record, you will nee to pass in a record id as commented below
    //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
    array("name" => "name", "value" => "Test Account"),
  ),
);

$set_entry_result = $client->call("set_entry", $set_entry_parameters);
echo(json_encode($set_entry_result));