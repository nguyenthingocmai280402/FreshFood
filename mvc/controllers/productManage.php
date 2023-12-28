<?php

class productManage extends ControllerBase
{
    public function index()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }

        // khởi tạo model
        $product = $this->model("productModel");
        // Gọi hàm addAllAdmin
        if (isset($_GET['keyword'])) {
            $result = $product->searchAdmin($_GET["keyword"]);
             $productList=[];
            if ($result) {
               $productList = $result->fetch_all(MYSQLI_ASSOC);
            }
            $this->view("admin/product", [
                "headTitle" => "Quản lý sản phẩm",
                "productList" => $productList
            ]);
        }else {
            $productList = ($product->getAllAdmin($_GET['page']))->fetch_all(MYSQLI_ASSOC);
            $countPaging = $product->getCountPaging(8);
            $this->view("admin/product", [
                "headTitle" => "Quản lý sản phẩm",
                "productList" => $productList,
                "countPaging" => $countPaging
            ]);
        }

    }

    public function add()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }


        $category = $this->model("CategoryModel");
        $result = $category->getAllClient();
        $categoryList = $result->fetch_all(MYSQLI_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product = $this->model("productModel");
            $result = $product->insert($_POST);
            if ($result) {
                $this->view("admin/addNewproduct", [
                    "headTitle" => "Quản lý sản phẩm",
                    "cssClass" => "success",
                    "message" => "Thêm mới thành công!",
                    "name" => $_POST['name'],
                    "categoryList" => $categoryList
                ]);
            } else {
                $this->view("admin/addNewproduct", [
                    "headTitle" => "Quản lý sản phẩm",
                    "cssClass" => "error",
                    "message" => "Lỗi, vui lòng thử lại sau!",
                    "name" => $_POST['name']
                ]);
            }
        } else {
            $this->view("admin/addNewproduct", [
                "headTitle" => "Thêm mới sản phẩm",
                "cssClass" => "none",
                "categoryList" => $categoryList
            ]);
        }
    }

    public function edit($id = "")
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {
            $this->redirect("home");
        }
        
        $category = $this->model("CategoryModel");
        $result = $category->getAllAdmin();
        $categoryList = $result->fetch_all(MYSQLI_ASSOC);

        $product = $this->model("productModel");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $r = $product->update($_POST);
            $new = $product->getByIdAdmin($_POST['id']);
            if ($r) {
                $this->view("admin/editproduct", [
                    "headTitle" => "Xem/Cập nhật sản phẩm",
                    "cssClass" => "success",
                    "message" => "Cập nhật thành công!",
                    "categoryList" => $categoryList,
                    "product" => $new->fetch_assoc()
                ]);
            } else {
                $this->view("admin/editproduct", [
                    "headTitle" => "Xem/Cập nhật sản phẩm",
                    "cssClass" => "error",
                    "message" => "Lỗi, vui lòng thử lại sau!",
                    "categoryList" => $categoryList,
                    "product" => $new->fetch_assoc()
                ]);
            }
        } else {
            $p = $product->getByIdAdmin($id);
            $this->view("admin/editproduct", [
                "headTitle" => "Xem/Cập nhật sản phẩm",
                "cssClass" => "none",
                "categoryList" => $categoryList,
                "product" => $p->fetch_assoc()
            ]);
        }
    }

    public function changeStatus($id)
    {
        $product = $this->model("productModel");
        $result = $product->changeStatus($id);
        if ($result) {
            $this->redirect("productManage");
        }
    }
}
