<?

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('UTC');

$url = "https://<sugarcrmhost>/service/v4_1/soap.php?wsdl";
$username = "sugar_username";
$password = "sugar_password";

//retrieve WSDL
echo "Retrieve WSDL\n";
$client = new nusoap_client($url, 'wsdl');

//display errors
$err = $client->getError();
echo json_encode($err);
if ($err)
{
    echo $err;
    echo $client->getDebug();
    exit();
}

// Prepare login parameters
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

// Login
$login_result = $client->call('login', $login_parameters);
echo(json_encode($login_result));

//get session id
$session_id =  $login_result['id'];
echo "Session ID is: " . $session_id . "\n";
