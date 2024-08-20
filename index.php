
<?php


function get_curl_response($endpoint, $key, $description)
{

    $url = $endpoint;
    // Build query only if array is not 0
    $params = array(
        'k' => $key,
        'q' => $description
    );

    //print($params['q']);

    if ($params !== 0) {
        $url = $endpoint . '?' . http_build_query($params);
        //print($url);
    }
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    /*curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $key,
        'Accept: application/json'
    ));*/

    // Execute cURL request
    $response = curl_exec($ch);

    // Check response
    if ($response === false) {
        echo "cURL error: " . curl_error($ch);
        curl_close($ch);
        return [];
    } else {
        // Decode the JSON response
        //print(gettype($response));
        curl_close($ch);
        return $response;
    }
}


$endpoint = 'https://www.napikano.com/api/rcallv1.php';
$key = '';

$country = 'Argentina';
$city = 'Buenos Aires';
$start = '8/20/2024';
$end = '8/24/2024';
$size = 'solo';
$age = '20-25';
$currency = 'USD';

$q = sprintf('Give me an itinerary of two tourist attractions per day in the country of %s, the city of %s, starting on %s and ending in %s. The attractions should be for people traveling %s, age range of %s. 


Format the answer as JSON do not add inner quotation marks inside the values to avoid parsing errors, keep the quotation marks that are needed for the JSON format.

{"day": "1", 
"time": "Morning or Afternoon", 
"date": "XX-XX-XXXX", 
"attraction": "Attraction Name",
"description": "Attraction Description",
"duration": "Attraction Duration",
"price": "Attraction Price in %s"
} do not add any other text.', $country, $city, $start, $end, $size, $age, $currency);
// add variable to change currency
// 

$answer = get_curl_response($endpoint, $key, $q);
print($answer);

echo '<br/>';
echo '<br/>';
$answer = '[' . $answer . ']';
$formated = json_decode($answer, true);
echo '<br/>';
echo '<br/>';


foreach ($formated as $item) {
    echo $item['day'] . ' ' . $item['attraction'] . '<br>';
}
