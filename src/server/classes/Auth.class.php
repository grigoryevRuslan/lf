<?php

class User
{
    private $id;
    private $username;
    private $db;
    private $user_id;

    private $is_authorized = false;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->connectDb($this->db_name, $this->db_user, $this->db_pass, $this->db_host);
    }

    public function __destruct()
    {
        $this->db = null;
    }

    public static function isAuthorized()
    {
        if (!empty($_SESSION["user_id"])) {
            return (bool) $_SESSION["user_id"];
        }
        return false;
    }

    public function passwordHash($password, $salt = null, $iterations = 10)
    {
        $salt || $salt = uniqid();
        $hash = md5(md5($password . md5(sha1($salt))));

        for ($i = 0; $i < $iterations; ++$i) {
            $hash = md5(md5(sha1($hash)));
        }

        return array('hash' => $hash, 'salt' => $salt);
    }

    public function getSalt($username) {
        $query = "select salt from users where username = :username limit 1";
        $sth = $this->db->prepare($query);
        $sth->execute(
            array(
                ":username" => $username
            )
        );

        $row = $sth->fetch();
        if (!$row) {
            return false;
        }

        return $row["salt"];
    }

    public function authorize($username, $password, $remember=false)
    {
        $query = "select Fuid, username from users where
            username = :username and password = :password limit 1";
        $sth = $this->db->prepare($query);
        $salt = $this->getSalt($username);

        if (!$salt) {
            return false;
        }

        $hashes = $this->passwordHash($password, $salt);
        $sth->execute(
            array(
                ":username" => $username,
                ":password" => $hashes['hash'],
            )
        );
        $this->user = $sth->fetch();
        
        if (!$this->user) {
            $this->is_authorized = false;
        } else {
            $this->is_authorized = true;
            $this->user_id = $this->user['Fuid'];
            $this->saveSession($username);
        }

        return $this->is_authorized;
    }

    public function logout()
    {
        if (!empty($_SESSION["user_id"])) {
            unset($_SESSION["user_id"]);
        }
    }

    public function saveSession($username)
    {
        $_SESSION["user_id"] = $this->user_id;
        $_SESSION["user_name"] = $username;
    }

    public function create($username, $password) {
        $user_exists = $this->getSalt($username);
        $user_uniqueid = uniqid();

        if ($user_exists) {
            throw new \Exception("User exists: " . $username, 1);
        }

        $query = "insert into users (Fuid, username, password, salt)
            values (:unique_id, :username, :password, :salt)";

        $hashes = $this->passwordHash($password);
        $sth = $this->db->prepare($query);

        try {
            $this->db->beginTransaction();
            $result = $sth->execute(
                array(
                    ':unique_id' => $user_uniqueid,
                    ':username' => $username,
                    ':password' => $hashes['hash'],
                    ':salt' => $hashes['salt'],
                )
            );
            $this->db->commit();
        } catch (\PDOException $e) {
            $this->db->rollback();
            echo "Database error: " . $e->getMessage();
            die();
        }

        if (!$result) {
            $info = $sth->errorInfo();
            printf("Database error %d %s", $info[1], $info[2]);
            die();
        } 

        return $result;
    }

    public function connectdb($db_name, $db_user, $db_pass, $db_host = "localhost")
    {
        try {
            $this->db = new PDO("mysql:host=127.0.0.1;port=3320;dbname=find", 'root');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\pdoexception $e) {
            echo "database error: " . $e->getmessage();
            die($e->getmessage());
        }
        $this->db->query('set names utf8');

        return $this;
    }
}
