<?php
if(isset($_POST['eml'])){
    if(!empty($_POST['eml'])) {
        $creds = array( 'eml' => $_POST['eml']);
        $url = 'http://authserver:8080/register';
        $curl = curl_init($url);
        $curlString = http_build_query($creds, '', '&');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        echo htmlspecialchars("$response", ENT_QUOTES, 'UTF-8');
    }
}  
?>

