<?php

### Run a simple GET query via cURL. Use this for APIs that return JSON, XML, or some sort of dataset.
if( !function_exists('jp_curl') ){

    // http://codular.com/curl-with-php
    function jp_curl($request_url){

        // Get cURL resourse
        $curl = curl_init();

        // Set some options - we are passing in a useragent here too.
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $request_url,
            CURLOPT_USERAGENT => 'Simple cURL Request',
        ));

        // Send the request and save the response.
        $response = curl_exec($curl);

        // Close the request to clean up.
        curl_close($curl);

        // Return whatever response came back from the request.
        return $response;

    }

}
