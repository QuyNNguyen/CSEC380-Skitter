<?php
#if(!isset($_POST['token'])){
#    header("Location: ../index.html");
#}else{
        if(isset($_POST["newSkit"])){
            if(!empty($_POST["newSkit"])) {
                if($stmt = $con->prepare("SELECT username FROM skitter.sessions WHERE session_id = ?")){
                    $session_id = strip_tags($_COOKIE['session']);
                    if($stmt->bind_param("s",$session_id)){
                        $stmt->execute();
                        $stmt->store_result();
                        if (!$stmt) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        }
                        if ($stmt->num_rows !== 1) exit('Unexpected row count');
                        $username = NULL;
                        $stmt->bind_result($username);
                        $stmt->fetch();
                        $_POST['user'] = $username;
                        $skit = array( 'newSkit' => $_POST["newSkit"], 'user' => $_POST['user']);
                        $url = 'http://node:8888/addSkit';
                        $curl = curl_init($url);
                        $curlString = http_build_query($skit, '', '&');
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlString);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        header("Location: /index.html");
                    }
                    echo "broke at bind";
                }
                echo "broke at prepare";
            }
        }
        if(isset($_POST["getSkit"])){
            if(!empty($_POST["getSkit"])) {
                if($stmt = $con->prepare("SELECT username FROM skitter.sessions WHERE session_id = ?")){
                    $session_id = strip_tags($_COOKIE['session']);
                    if($stmt->bind_param("s",$session_id)){
                        $stmt->execute();
                        $stmt->store_result();
                        if (!$stmt) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        }
                        if ($stmt->num_rows !== 0) exit('Unexpected row count');
                        $username = NULL;
                        $stmt->bind_result($username);
                        $stmt->fetch();
                        $_POST['user'] = $username;
                        $skit = array('user' => $_POST['user']);
                        $url = 'http://node:8888/getSkit';
                        $curl = curl_init($url);
                        $curlString = http_build_query($skit, '', '&');
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlString);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        echo "blah";
                        curl_close($curl);
                    }
                    echo "broke at bind";
                }
                echo "broke at prepare";
            }
        }
    }
#}
?>
