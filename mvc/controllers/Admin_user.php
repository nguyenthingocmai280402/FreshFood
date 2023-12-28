<?php 
class Admin_user extends ControllerBase{
    public function index()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }

        $Auser = $this->model("Auser_model");
        
        $AuserList = $Auser->getAll()->fetch_all(MYSQLI_ASSOC);

        $this->view("admin/admin_user", [
            "headTitle" => "Quản lý người dùng",
            "userList" => $AuserList // Sửa tên biến thành userList
        ]);
    }
public function changeStatus($id)
    {
        $Auser = $this->model("Auser_model");
        $result = $Auser->changeStatus($id);
        if ($result) {
            $this->redirect("Admin_user");
        }
    }

    public function add()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Khởi tạo model
            $user = $this->model("Auser_model");
            // Gọi hàm insert để thêm mới vào csdl
            $result = $user->insert(
                $_POST['fullName'],
                $_POST['email'],
                $_POST['dob'],
                $_POST['address'],
                $_POST['phone']
            );
            if ($result) {
                $this->view("admin/addNewAuser", [
                    "headTitle" => "Quản lý người dùng",
                    "cssClass" => "success",
                    "message" => "Thêm mới thành công!",
                    "name" => $_POST['name']
                ]);
            } else {
                $this->view("admin/addNewAuser", [
                    "headTitle" => "Quản lý người dùng",
                    "cssClass" => "error",
                    "message" => "Lỗi, vui lòng thử lại sau!",
                    "name" => $_POST['name']
                ]);
            }
        } else {
            $this->view("admin/addNewAuser", [
                "headTitle" => "Thêm mới người dùng",
                "cssClass" => "none",
            ]);
        }
    }
    
    public function edit($id = "")
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }

        $Auser = $this->model("Auser_model");
        $user = $Auser->getByIdAdmin($id); // Sử dụng fetch_assoc để lấy dữ liệu một cách chi tiết hơn

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $Auser->update($_POST['id'],$_POST['fullName'], $_POST['email'], $_POST['dob'], $_POST['address'], $_POST['phone']);
            // Gọi hàm getByIdAdmin
            $new = $Auser->getByIdAdmin($_POST['id']);
            if ($result) {
                $this->view("admin/view_update_user", [
                    "headTitle" => "Xem/Cập nhật người dùng",
                    "cssClass" => "success",
                    "message" => "Cập nhật thành công!",
                    "Auser" => $new->fetch_assoc() // Lấy dữ liệu mới sau khi cập nhật
                ]);
            } else {
                $this->view("admin/view_update_user", [
                    "headTitle" => "Xem/Cập nhật người dùng",
                    "cssClass" => "error",
                    "message" => "Lỗi, vui lòng thử lại sau!",
                    "Auser" => $new->fetch_assoc() // Trả về dữ liệu cũ nếu có lỗi
                ]);
            }
        } else {
            $this->view("admin/view_update_user", [
                "headTitle" => "Xem/Cập nhật người dùng",
                "cssClass" => "none",
                "Auser" =>  $user->fetch_assoc()
            ]);
        }
    }
    // public function edit2($id){
    //     $date=date("Y").":".date("m").":".date("d");
    //     if(isset($_POST['btn_edit'])){
    //         $name = $_POST['name'];
    //         $email = $_POST['email'];
    //         $phone_number = $_POST['phone_number'];
    //         $address = $_POST['address'];
    //         $role = $_POST['role'];
    //         $status = $_POST['status'];
    //     }
    //     $this->Auser_model->edit($id,$name,$email,$phone_number,$address,$role,$status,$date);
    //     header("Refresh: 0.001;url=http://localhost/thucphamsach/Admin_user");
    // }
}
?>