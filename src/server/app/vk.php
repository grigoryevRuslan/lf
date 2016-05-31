<?php

    $client_id = '5483966';
    $client_secret = 'Bvtsi3LDvRwcTFPkFSLF';
    $redirect_uri = 'http://www.luckfind.me/app/vk.php';

    $url = 'http://oauth.vk.com/authorize';

    $params = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );

    if (isset($_GET['code'])) {

        include_once $_SERVER['DOCUMENT_ROOT'].'/globals/common.php';
        include_once $_SERVER['DOCUMENT_ROOT'].'/globals/db/db.php';
        
        $result = false;
        $params = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_GET['code'],
            'redirect_uri' => $redirect_uri
        );

        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

        if (isset($token['access_token'])) {
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                'access_token' => $token['access_token']
            );

            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
            if (isset($userInfo['response'][0]['uid'])) {
                $userInfo = $userInfo['response'][0];
                $result = true;
            }
        }

        if ($result) {
            $_fbid = $userInfo['uid'];
            $_fbname = $userInfo['first_name'];
            $_fbuser_birthday = $userInfo['bdate'];

            $checkUserIDQuery = $pdoConnection->prepare("SELECT users.id FROM users WHERE Fuid = '$_fbid'");
            $checkUserIDQuery->execute();
            $resultUserIDQuery = $checkUserIDQuery->fetchAll();

            if(!$resultUserIDQuery){
                $insertUserQuery = $pdoConnection->prepare("INSERT INTO users (Fuid, username, Fbirthday) VALUES ($_fbid, '$_fbname', '$_fbuser_birthday')");
                $insertUserQuery->execute();
            } else { 
                $updateUserQuery = $pdoConnection->prepare("UPDATE users SET username = '$_fbname', Fbirthday = '$_fbuser_birthday' where Fuid = $_fbid");
                $updateUserQuery->execute();
            }
            
            $_SESSION['user_id'] = $userInfo['uid'];            
            $_SESSION['user_name'] = $userInfo['first_name'];
            $_SESSION['user_avatar'] = $userInfo['photo_big'];    
        }

        header('Location: '.$_SESSION['from_uri']);
        exit();
    } else {
        $_SESSION['from_uri'] = urldecode($_GET['from_uri']);
        header("Location: ".$url.'?'.urldecode(http_build_query($params)));
        exit();
    }
?>