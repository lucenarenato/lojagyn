<?php

if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    header('HTTP/1.1 304 Not Modified');
    header('Last-Modified: ' . $_SERVER['HTTP_IF_MODIFIED_SINCE'], true, 304);
    exit;
}

function mbstring_binary_safe_encoding($reset = false) {
    static $encodings = array();
    static $overloaded = null;

    if (is_null($overloaded))
        $overloaded = function_exists('mb_internal_encoding') && ( ini_get('mbstring.func_overload') & 2 );

    if (false === $overloaded)
        return;

    if (!$reset) {
        $encoding = mb_internal_encoding();
        array_push($encodings, $encoding);
        mb_internal_encoding('ISO-8859-1');
    }

    if ($reset && $encodings) {
        $encoding = array_pop($encodings);
        mb_internal_encoding($encoding);
    }
}

try {

    include_once ('libs/Requests/Requests.php');
    Requests::register_autoloader();

    // Avoid issues where mbstring.func_overload is enabled.
    mbstring_binary_safe_encoding();


    $request_url = !empty($_REQUEST['url'])?$_REQUEST['url']:'';
    if($request_url){
        if(substr($request_url, 0, 4) !== "http"){
            $request_url = "https:".$request_url;
        }else{
            $request_url = $request_url;    
        }
    }

    $requests_response = Requests::get($request_url, array('Accept-Encoding' => ''), array('timeout' => 30, 'useragent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36', 'verify' => false, 'sslverify' => false, 'verifyname' => false));

    foreach ($requests_response->headers->getAll() as $name => $values) {
        if (in_array(strtolower($name), array('content-length', 'content-type', 'cache-control', 'last-modified', 'expires', 'date'))) {
            foreach ($values as $value) {
                header("$name: $value");
            }
        }
    }

    echo $requests_response->body;
} catch (Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    exit;
}