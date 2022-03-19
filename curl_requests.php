<?php

// Setting up Env variables
require_once('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$api_key = $_ENV["API_KEY"];
$endpoint = $_ENV["NETWORK_ENDPOINT"];
$stake_address = $_ENV["STAKE_ADDRESS"];

// Setting up pagination info and default headers
$params = array(
  'count' => '10',
  'page' => '1',
  'order' => 'asc',
);
$query = http_build_query($params);

$headers = [
  'project_id: '.$api_key,
  'Content-Type: application/json'   
];

// function for executing GET through curl
function get_blockfrost($url, $query, $headers) {
  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, $url."?".$query );
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($curl);

  curl_close($curl);

  return $response;
}

// GET delagation history of account
$url = $endpoint."/accounts/".$stake_address."/delegations";
$response = get_blockfrost($url, $query, $headers);

echo "delegation history: \n";
echo $response . "\n";

// GET account assets

$url = $endpoint."/accounts/".$stake_address."/addresses/assets";
echo $url;
$response = get_blockfrost($url, $query, $headers);

echo "\nassets: \n";
echo $response . "\n";

// GET all info about address

$example_address = "addr1qxqs59lphg8g6qndelq8xwqn60ag3aeyfcp33c2kdp46a09re5df3pzwwmyq946axfcejy5n4x0y99wqpgtp2gd0k09qsgy6pz"; // from blockfrost docs
$url = $endpoint."/addresses/".$example_address;
$response = get_blockfrost($url, $query, $headers);

echo "\naddr info: \n";
echo $response . "\n";

// GET information about asset

$example_asset = "d2dd0187d927513f6e7b123918b09bc6fde1e7b7d1619d336ec5a9da4144463031363933";
$url = $endpoint."/assets/".$example_asset;
$response = get_blockfrost($url, $query, $headers);

echo "\nasset info: \n";
echo $response . "\n";

// GET assets of policy

$example_policy = "d2dd0187d927513f6e7b123918b09bc6fde1e7b7d1619d336ec5a9da";
$url = $endpoint."/assets/policy/".$example_policy;
$response = get_blockfrost($url, $query, $headers);

echo "\nasset policy: \n";
echo $response . "\n";

?>
