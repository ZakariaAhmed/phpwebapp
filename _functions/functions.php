<?php 

 function get_final_url( $url, $timeout = 5 )
 {
    $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

  $cookie = @tempnam("/tmp", "CURLCOOKIE");
$ch = curl_init();
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_ENCODING, "" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
$content = curl_exec( $ch );
$response = curl_getinfo( $ch );
curl_close ( $ch );

if ($response['http_code'] == 301 || $response['http_code'] == 302)
{
    ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
    $headers = get_headers($response['url']);

    $location = "";
    foreach( $headers as $value )
    {
        if ( substr( strtolower($value), 0, 9 ) == "location:" )
            return get_final_url( trim( substr( $value, 9, strlen($value) ) ) );
    }
}

if (    preg_match("/window\.location\.replace\('(.*)'\)/i", $content, $value) ||
        preg_match("/window\.location\=\"(.*)\"/i", $content, $value)
)
{
    return get_final_url ( $value[1] );
}
else
{
    return $response['url'];
   }
}


function get_redirect_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = curl_exec($ch);
    curl_close($ch);
    // Check if there's a Location: header (redirect)
    if (preg_match('/^Location: (.+)$/im', $headers, $matches))
        return trim($matches[1]);
    // If not, there was no redirect so return the original URL
    // (Alternatively change this to return false)
    return $url;
}
// FOLLOW ALL REDIRECTS:
// This makes multiple requests, following each redirect until it reaches the
// final destination.
function get_redirect_final_target($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirects
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // set referer on redirect
    curl_exec($ch);
    $target = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    if ($target)
        return $target;
    return false;
}


function get_http_response_code($theURL) {
    $headers = get_headers($theURL);
    return substr($headers[0], 9, 3);
}

function curlResponseCode($url) {
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_TIMEOUT,10);
$output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

return $httpcode;
}


function stripURL($userInput) {

$input = $userInput;

// in case scheme relative URI is passed, e.g., //www.google.com/
$input = trim($input, '/');

// If scheme not included, prepend it
if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
}

$urlParts = parse_url($input);

// remove www
$domain = preg_replace('/^www\./', '', $urlParts['host']);

return $domain;
}

function pure_url($url) {
   if ( substr($url, 0, 7) == 'http://' ) {
      $url = substr($url, 7);
   }
   if ( substr($url, 0, 8) == 'https://' ) {
      $url = substr($url, 8);
   }
   if ( substr($url, 0, 6) == 'ftp://') {
      $url = substr($url, 6);
   }
   if ( substr($url, 0, 4) == 'www.') {
      $url = substr($url, 4);
   }
   return $url;
}


function is_url($uri){
    if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
      return TRUE;
    }
    else{
        return false;
    }
}



function url_parser($url) {

// multiple /// messes up parse_url, replace 2+ with 2
$url = preg_replace('/(\/{2,})/','//',$url);

$parse_url = parse_url($url);

if(empty($parse_url["scheme"])) {
    $parse_url["scheme"] = "http";
}
if(empty($parse_url["host"]) && !empty($parse_url["path"])) {
    // Strip slash from the beginning of path
    $parse_url["host"] = ltrim($parse_url["path"], '\/');
    $parse_url["path"] = "";
}   

$return_url = "";

// Check if scheme is correct
if(!in_array($parse_url["scheme"], array("http", "https", "gopher"))) {
    $return_url .= 'http'.'://';
} else {
    $return_url .= $parse_url["scheme"].'://';
}

// Check if the right amount of "www" is set.
$explode_host = explode(".", $parse_url["host"]);

// Remove empty entries
$explode_host = array_filter($explode_host);
// And reassign indexes
$explode_host = array_values($explode_host);

// Contains subdomain
if(count($explode_host) > 2) {
    // Check if subdomain only contains the letter w(then not any other subdomain).
    if(substr_count($explode_host[0], 'w') == strlen($explode_host[0])) {
        // Replace with "www" to avoid "ww" or "wwww", etc.
        $explode_host[0] = "www";

    }
}
$return_url .= implode(".",$explode_host);

if(!empty($parse_url["port"])) {
    $return_url .= ":".$parse_url["port"];
}
if(!empty($parse_url["path"])) {
    $return_url .= $parse_url["path"];  
}
if(!empty($parse_url["query"])) {
    $return_url .= '?'.$parse_url["query"];
}
if(!empty($parse_url["fragment"])) {
    $return_url .= '#'.$parse_url["fragment"];
}


return $return_url;
}



 ?>