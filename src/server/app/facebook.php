<?php

    $client_id = '927398294047553'; // Client ID
    $client_secret = '2d20681ace9f4b301ec4e329b2b2a1d9'; // Client secret
    $redirect_uri = 'http://luckfind-dev.me/app/facebook.php'; // Redirect URIs

    $url = 'https://www.facebook.com/dialog/oauth';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code',
        'scope'         => 'email,user_birthday'
    );

    if (isset($_GET['code'])) {

        include_once '../globals/common.php';
        include_once '../globals/db/db.php';

        $result = false;

        $params = array(
            'client_id'     => $client_id,
            'redirect_uri'  => $redirect_uri,
            'client_secret' => $client_secret,
            'code'          => $_GET['code']
        );

        $url = 'https://graph.facebook.com/oauth/access_token';

        $tokenInfo = null;
        parse_str(file_get_contents($url . '?' . http_build_query($params)), $tokenInfo);

        if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
            $params = array('access_token' => $tokenInfo['access_token']);

            $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);

            if (isset($userInfo)) {
                $userInfo = $userInfo;
                $result = true;
                $_fbid = $userInfo['id'];
                $_fbname = $userInfo['name'];

                if ( !isset($userInfo['email']) ) {$_fbmail = ' ';}
                if ( !isset($userInfo['user_birthday']) ) { $_fbuser_birthday = ' ';}
                $checkUserIDQuery = $pdoConnection->prepare("SELECT users.id FROM users WHERE Fuid = '$_fbid'");
                $checkUserIDQuery->execute();
                $resultUserIDQuery = $checkUserIDQuery->fetchAll();
                
                var_dump($resultUserIDQuery);
                die();

                if(!$resultUserIDQuery){
                    $insertUserQuery = $pdoConnection->prepare("INSERT INTO users (Fuid, username, Femail, Fbirthday) VALUES ($_fbid, '$_fbname', '$_fbmail', '$_fbuser_birthday')");
                    $insertUserQuery->execute();
                    $resultInsertUserQuery = $insertUserQuery->fetch();
                } else { 
                    $updateUserQuery = $pdoConnection->prepare("UPDATE users SET username = '$_fbname', Femail = '$_fbmail', Fbirthday = '$_fbuser_birthday' where Fuid = $_fbid");
                    $updateUserQuery->execute();
                }
                
                $_SESSION['user_id'] = $userInfo['id'];            
                $_SESSION['user_name'] = $userInfo['name'];            
            }
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
            exit();
        } else {
            die('fatal error!');
        }
    } else {
      header("Location: ".$url.'?'.urldecode(http_build_query($params)));
      exit();
    }
?>
