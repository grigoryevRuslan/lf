<?php

    $client_id = '1688370178097956';
    $client_secret = 'f69e29f8eff6d0d2924f2a7dd734d082';
    $redirect_uri = 'http://www.luckfind.me/app/facebook.php';

    $url = 'https://www.facebook.com/dialog/oauth';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code',
        'scope'         => 'email,user_birthday'
    );

    if (isset($_GET['code'])) {

        include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';

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

                if(!$resultUserIDQuery){
                    $insertUserQuery = $pdoConnection->prepare("INSERT INTO users (Fuid, username, Femail, Fbirthday) VALUES ($_fbid, '$_fbname', '$_fbmail', '$_fbuser_birthday')");
                    $insertUserQuery->execute();
                } else { 
                    $updateUserQuery = $pdoConnection->prepare("UPDATE users SET username = '$_fbname', Femail = '$_fbmail', Fbirthday = '$_fbuser_birthday' where Fuid = $_fbid");
                    $updateUserQuery->execute();
                }
                
                $_SESSION['user_id'] = $userInfo['id'];            
                $_SESSION['user_name'] = $userInfo['name'];
                $_SESSION['user_avatar'] = "https://graph.facebook.com/".$_SESSION['user_id']."/picture";       
            }
            header('Location: '.$_SESSION['from_uri']);
            exit();
        } else {
            die('fatal error!');
        }
    } else {
        $_SESSION['from_uri'] = urldecode($_GET['from_uri']);
        header("Location: ".$url.'?'.urldecode(http_build_query($params)));
        exit();
    }
?>
