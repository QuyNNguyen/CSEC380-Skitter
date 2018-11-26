<?php



//authenticate users here
if(isset($_POST['usr'], $_POST['pass'])){
    if(!empty($_POST['usr']) && !empty($_POST['pass'])) {
        $user = strip_tags($_POST['usr']);
        $pass = strip_tags($_POST['pass']);
        $creds = array( 'eml' => $user, 'passwd' => $pass);
        
        $url = 'http://authserver:8080/login';
        $curl = curl_init($url);
        $curlString = http_build_query($creds, '', '&');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = htmlspecialchars("$response", ENT_QUOTES, 'UTF-8');
        list($code, $cooke_value) = explode(":", $data);
        if(strcmp($code, "success") == 0){
            if(strlen($cooke_value) == 30){
                setcookie("session", $cooke_value, time() + 10800, "/");
                echo "success";
            }
        }else{
            echo "fail";
        }
    }
}



// generate csrf token
$_SESSION['token'] = bin2hex(random_bytes(32));

?>