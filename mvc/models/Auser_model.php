<?php
class Auser_model
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Auser_model();
        }

        return self::$instance;
    }

    public function getAll()
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM users";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getById($id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM user WHERE id='$id' AND status=1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }
    // public function getByIdAdmin($id)
    // {
    //     $db = DB::getInstance();
    //     $sql = "SELECT * FROM users WHERE id='$id'";
    //     $result = mysqli_query($db->con, $sql);
    //     return $result;
    // }
    public function getByIdAdmin($id)
    {
        $db = DB::getInstance();
        $stmt = mysqli_prepare($db->con, "SELECT * FROM users WHERE id = ?");
        
        if ($stmt) {
            // Bind the parameter
            mysqli_stmt_bind_param($stmt, "i", $id); // "i" indicates an integer
            
            // Execute the statement
            mysqli_stmt_execute($stmt);
            
            // Get the result
            $result = mysqli_stmt_get_result($stmt);
            
            return $result;
        } else {
            return false;
        }
    }
    public function changeStatus($Id)
    {
        $db = DB::getInstance();
        $sql = "UPDATE users SET status = !status WHERE Id='$Id'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    // public function insert($fullName,$email,$dob,$address,$phone)
    // {
    //     $db = DB::getInstance();
    //     $sql = "INSERT INTO users VALUES (NULL, $fullName[fullName], $email[email], '$dob[dob]', '$address[address]','$phone[phone]',1,0)";
    //     $result = mysqli_query($db->con, $sql);
    //     return $result;
    // }
    // Trong Auser_model.php
public function insert($fullName, $email, $dob, $address, $phone)
{
    $db = DB::getInstance();
    $sql = "INSERT INTO users VALUES (NULL, '$fullName', '$email', '$dob', '$address', '$phone', 1, 0)";
    $result = mysqli_query($db->con, $sql);
    return $result;
}

    public function update($id,$fullName,$email,$dob,$address,$phone)
    {
        $db = DB::getInstance();
        $sql = "UPDATE users SET fullName = '$fullName', email = '$email' ,dob =  '$dob' ,address = '$address', phone = '$phone' where id='$id';";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

   

}
