<?php
include_once(APP_ROOT . '/libs/PHPMailer.php');
include_once(APP_ROOT . '/libs/Exception.php');
include_once(APP_ROOT . '/libs/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;

class adminModel
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new adminModel();
        }

        return self::$instance;
    }

    public function checkLogin($email, $password)
    {
        $db = DB::getInstance();
        // Mã hóa password
        $md5Password = md5($password);
        $sql = "SELECT u.id, u.fullName, r.name AS RoleName FROM users u JOIN role r ON u.roleId = r.id WHERE email='$email' AND password='$md5Password' AND isConfirmed=1 AND status = 1";
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function checkCurrentPassword($userId, $password)
    {
        $db = DB::getInstance();
        // Mã hóa password
        $md5Password = md5($password);
        $sql = "SELECT * FROM users WHERE id='$userId' AND password='$md5Password' AND isConfirmed=1";
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function checkEmail($email)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM users WHERE email='$email' AND isConfirmed=1";
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPhone($phone)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM users WHERE phone='$phone' AND isConfirmed=1";
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

   

    public function confirm($email, $captcha)
    {
        $db = DB::getInstance();

        $sql = "SELECT * FROM users WHERE email='$email' AND captcha='$captcha'";
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            // Update user is confirmed
            $sql = "UPDATE users SET isConfirmed=1 WHERE email='$email'";
            $re = mysqli_query($db->con, $sql);
            if ($re) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getRole($userId)
    {
        $db = DB::getInstance();
        $sql = "SELECT roleId FROM users WHERE id='$userId'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getById($userId)
    {
        $db = DB::getInstance();
        $sql = "SELECT u.fullName, u.id, u.phone, u.dob, u.email, u.address, p.name as provinceName, d.name as districtName, w.name as wardName FROM users u JOIN province p ON u.provinceId=p.id JOIN district d ON u.districtId = d.id JOIN ward w ON u.wardId = w.id WHERE u.id='$userId'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getTotalClient()
    {
        $db = DB::getInstance();
        $sql = "SELECT COUNT(*) AS total FROM users WHERE roleId != 1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function checkPhoneUpdate($phone)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM users WHERE phone='$phone' AND isConfirmed=1 AND id!=" . $_SESSION['user_id'];
        $result = mysqli_query($db->con, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function update($user)
    {
        $db = DB::getInstance();
        $sql = "UPDATE `users` SET `fullName`='" . $user['fullName'] . "',`dob`='" . $user['dob'] . "',`address`='" . $user['address'] . "',`phone`='" . $user['phone'] . "', `provinceId` = " . $user['ls_province'] . ", `districtId` = " . $user['ls_district'] . ", `wardId` = " . $user['ls_ward'] . " WHERE id=" . $_SESSION['user_id'];
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function updatePassword($userId, $password)
    {
        $db = DB::getInstance();
        // Mã hóa password
        $md5Password = md5($password);
        $sql = "UPDATE `users` SET `password`='" . $md5Password . "' WHERE id=" . $userId;  
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function delete($userId)
    {
        $db = DB::getInstance();
        $sql = "UPDATE `users` SET status = 0 WHERE id=" . $userId;  
        $result = mysqli_query($db->con, $sql);
        return $result;
    }
}