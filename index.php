
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

$country = 'USA';
$city = 'New York';
$start = '8/20/2024';
$end = '8/27/2024';
$size = 'solo';
$age = '20-25';
$currency = 'USD';

$q = sprintf('Give me an itinerary of two tourist attractions per day in the country of %s, the city of %s, starting on %s and ending in %s. The attractions should be for people traveling %s, age range of %s. 

Ensure that there are two attractions per day for the dates given so if 7 days 14 attractions.

Format the answer as JSON and ensure that any quotation marks within the fields are properly escaped. Do not add any other text and check that the response is a list of JSON separated by commas, do not add square brackets. The answer should look like this:

{"day": "1", 
"time": "Morning or Afternoon", 
"date": "00-00-0000", 
"attraction": "Attraction Name",
"description": "Attraction Description",
"duration": "Attraction Duration",
"price": "Attraction Price in %s"
} 
Separate each object with only a comma.
Ensure that the end of the answer does not contain any symbol.

', $country, $city, $start, $end, $size, $age, $currency);
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
