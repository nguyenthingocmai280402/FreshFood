<?php
class productModel
{
    private static $instance = null;

    
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new productModel();
        }

        return self::$instance;
    }
        private $db;
    
        public function __construct() {
            // Kết nối đến cơ sở dữ liệu MySQL
            $this->db = new mysqli('localhost', 'root', '', 'thucphamsach');
    
            if ($this->db->connect_error) {
                die('Kết nối tới cơ sở dữ liệu thất bại: ' . $this->db->connect_error);
            }
        }
    
        public function search($keyword) {
            $keyword = $this->db->real_escape_string($keyword); // Để tránh SQL injection
    
            // Thực hiện truy vấn tìm kiếm trong cơ sở dữ liệu
            $query = "SELECT * FROM products WHERE name LIKE '%$keyword%' OR des LIKE '%$keyword'";
            $result = $this->db->query($query);
    
            if ($result) {
                $products = [];
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products;
            } else {
                return [];
            }
        }
    
        public function getProductSuggest($keyword, $id) {
            $keyword = $this->db->real_escape_string($keyword); // Để tránh SQL injection
    
            // Thực hiện truy vấn gợi ý sản phẩm trong cơ sở dữ liệu
            $query = "SELECT * FROM products WHERE id != $id AND name LIKE '%$keyword%' LIMIT 4";
            $result = $this->db->query($query);
    
            if ($result) {
                $products = [];
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products;
            } else {
                return [];
            }
        }
    
    public function getById($Id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM products WHERE Id='$Id' AND status=1";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getByIdAdmin($Id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM products WHERE Id='$Id'";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getByCateId($page = 1, $total = 8, $CateId)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $tmp = ($page - 1) * $total;
        $db = DB::getInstance();
        $sql = "SELECT * FROM products WHERE cateId='$CateId' AND status=1 LIMIT $tmp,$total";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getByCateIdSinglePage($CateId, $Id)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM products WHERE cateId='$CateId' AND status=1 AND id != $Id ORDER BY soldCount DESC LIMIT 4";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getFeaturedproducts()
    {
        $db = DB::getInstance();
        $sql = "SELECT p.id, p.name, p.image, p.originalPrice, p.promotionPrice, p.qty as qty, p.soldCount as soldCount FROM products p JOIN categories c ON p.cateId = c.id WHERE p.status=1 AND c.status = 1 AND soldCount > 0 order BY soldCount DESC LIMIT 4";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getNewproducts()
    {
        $db = DB::getInstance();
        $sql = "SELECT p.id, p.name, p.image, p.originalPrice, p.promotionPrice, p.qty as qty, p.soldCount as soldCount FROM products p JOIN categories c ON p.cateId = c.id WHERE p.status=1 AND c.status = 1 order BY id DESC LIMIT 4";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getDiscountproducts()
    {
        $db = DB::getInstance();
        $sql = "SELECT p.id, p.name, p.image, p.originalPrice, p.promotionPrice, p.qty as qty, p.soldCount as soldCount FROM products p JOIN categories c ON p.cateId = c.id WHERE p.status=1 AND c.status = 1 AND p.promotionPrice < p.originalPrice LIMIT 4";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function getAllAdmin($page = 1, $total = 8)
    {
        if ($page <= 0) {
            $page = 1;
        }
        $tmp = ($page - 1) * $total;
        $db = DB::getInstance();
        $sql = "SELECT * FROM products ORDER BY createdDate DESC LIMIT $tmp,$total";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }

    public function searchAdmin($keyword)
    {
        $db = DB::getInstance();
        $sql = "SELECT * FROM products WHERE name LIKE '%$keyword%'";
        $result = mysqli_query($db->con, $sql);
        if (mysqli_num_rows($result)) {
            return $result;
        }
        return false;
    }

    public function checkQuantity($Id, $qty)
    {
        $db = DB::getInstance();
        $sql = "SELECT qty FROM products WHERE status=1 AND Id='$Id'";
        $result = mysqli_query($db->con, $sql);
        $product = $result->fetch_assoc();
        if (intval($qty) > intval($product['qty'])) {
            return false;
        }
        return true;
    }

    // public function updateQuantity($Id, $qty)
    // {
    //     $db = DB::getInstance();
    //     $sql = "UPDATE products SET qty = qty - $qty WHERE id = $Id";
    //     $result = mysqli_query($db->con, $sql);
    //     return $result;
    // }
    public function updateQuantity($Id, $qty)
{
    $db = DB::getInstance();
    
    // Prepare the SQL statement
    $sql = "UPDATE products SET qty = qty - ? WHERE id = ?";
    $stmt = mysqli_prepare($db->con, $sql);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ii", $qty, $Id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            return true; // Return true to indicate a successful update
        } else {
            return false; // Return false to indicate a failed update
        }
    } else {
        return false; // Return false if the SQL statement couldn't be prepared
    }
}

    public function changeStatus($Id)
{
    $db = DB::getInstance();
    
    // Prepare and execute an SQL statement to update the status
    $sql = "UPDATE products SET status = NOT status WHERE Id = ?";
    $stmt = mysqli_prepare($db->con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $Id);
        $result = mysqli_stmt_execute($stmt);
    } else {
        $result = false;
    }

    // Check if the update was successful
    if ($result) {
        // Assuming the status update was successful, now trigger the Solr full-import
        // Make an HTTP request to Solr
        $solrImportUrl = "http://localhost:80/solr/products/dataimport?command=full-import";
        file_get_contents($solrImportUrl);

        return true;
    } else {
        return false;
    }
}
    // public function insert($product)
    // {
    //     $db = DB::getInstance();
    
    //     // Check and move product images
    //     $uploaded_images = [];
    //     $image_fields = ['image', 'image2', 'image3'];
    
    //     foreach ($image_fields as $field) {
    //         $file_name = $_FILES[$field]['name'];
    //         $file_temp = $_FILES[$field]['tmp_name'];
    
    //         if (!empty($file_name) && is_uploaded_file($file_temp)) {
    //             $div = explode('.', $file_name);
    //             $file_ext = strtolower(end($div));
    //             $unique_image = substr(md5(time() . $field), 0, 10) . '.' . $file_ext;
    //             $uploaded_image = APP_ROOT . "../../public/images/" . $unique_image;
    
    //             if (move_uploaded_file($file_temp, $uploaded_image)) {
    //                 $uploaded_images[$field] = $unique_image;
    //             }
    //         }
    //     }
    
    //     // Prepare and execute an SQL statement to insert the product
    //     $sql = "INSERT INTO products (name, originalPrice, promotionPrice, image, image2, image3, createdBy, createdDate, cateId, qty, des, status, soldCount, weight)
    //             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //     $stmt = mysqli_prepare($db->con, $sql);
    
    //     if ($stmt) {
    //         // Bind parameters
    //         $createdDate = date("Y-m-d H:i:s");
    //         $status = 1;  // Assuming a new product is active
    //         $soldCount = 0;  // Initial sold count
    
    //         mysqli_stmt_bind_param(
    //             $stmt,
    //             "ssssssisissii",
    //             $product['name'],
    //             $product['originalPrice'],
    //             $product['promotionPrice'],
    //             $uploaded_images['image'],
    //             $_SESSION['user_id'],
    //             $createdDate,
    //             $product['cateId'],
    //             $product['qty'],
    //             $product['des'],
    //             $status,
    //             $soldCount,
    //             $product['weight'],
    //             $uploaded_images['image2'],
    //             $uploaded_images['image3']
    //         );
            
    
    //         $result = mysqli_stmt_execute($stmt);
    
    //         if ($result) {
    //             // Assuming the product insertion was successful, now trigger the Solr full-import
    //             $solrImportUrl = "http://localhost:80/solr/products/dataimport?command=full-import";
    //             file_get_contents($solrImportUrl);
    //         }
    //     } else {
    //         $result = false;
    //     }
    
    //     return $result;
    // }
    public function insert($product)
    {
        $db = DB::getInstance();
        // Check image and move to upload folder
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = APP_ROOT . "../../public/images/" . $unique_image;
        move_uploaded_file($file_temp, $uploaded_image);

        $file_name2 = $_FILES['image2']['name'];
        $file_temp2 = $_FILES['image2']['tmp_name'];

        $div2 = explode('.', $file_name2);
        $file_ext2 = strtolower(end($div2));
        $unique_image2 = substr(md5(time() . '2'), 0, 10) . '.' . $file_ext2;
        $uploaded_image2 = APP_ROOT . "../../public/images/" . $unique_image2;
        move_uploaded_file($file_temp2, $uploaded_image2);

        $file_name3 = $_FILES['image3']['name'];
        $file_temp3 = $_FILES['image3']['tmp_name'];

        $div3 = explode('.', $file_name3);
        $file_ext3 = strtolower(end($div3));
        $unique_image3 = substr(md5(time() . '3'), 0, 10) . '.' . $file_ext3;
        $uploaded_image3 = APP_ROOT . "../../public/images/" . $unique_image3;
        move_uploaded_file($file_temp3, $uploaded_image3);


        $sql = "INSERT INTO `products` (`id`, `name`, `originalPrice`, `promotionPrice`, `image`,`image2`,`image3`, `createdBy`, `createdDate`, `cateId`, `qty`, `des`, `status`, `soldCount`,`weight`) VALUES (NULL, '" . $product['name'] . "', " . $product['originalPrice'] . ", " . $product['promotionPrice'] . ", '" . $unique_image . "', '" . $unique_image2 . "', '" . $unique_image3 . "', " . $_SESSION['user_id'] . ", '" . date("y-m-d H:i:s") . "', " . $product['cateId'] . ", " . $product['qty'] . ", '" . $product['des'] . "', 1, 0, " . $product['weight'] . ")";
        $result = mysqli_query($db->con, $sql);
if (!$result) {
    die('Lỗi trong truy vấn SQL: ' . mysqli_error($db->con));
}

        // file_get_contents("http://localhost:80/solr/products/dataimport?command=full-import");
        return $result;
    }
    
    public function update($product)
{
    // Initialize empty variables for images
    $unique_image = $unique_image2 = $unique_image3 = '';

    // Check and move product images
    if (!empty($_FILES['image']['name'])) {
        // Handle file upload and update $unique_image
        // ... (your file upload logic)

        // Make sure to validate the file, check for errors, and handle security.
    }

    if (!empty($_FILES['image2']['name'])) {
        // Handle file upload and update $unique_image2
        // ... (your file upload logic)
    }

    if (!empty($_FILES['image3']['name'])) {
        // Handle file upload and update $unique_image3
        // ... (your file upload logic)
    }

    $db = DB::getInstance();
    $sql = "UPDATE `products` SET name = ?, originalPrice = ?, promotionPrice = ?, qty = ?";

    // Append image fields to the SQL query if they were updated
    $sql_params = [$product['name'], $product['originalPrice'], $product['promotionPrice'], $product['qty']];

    if (!empty($unique_image)) {
        $sql .= ", image = ?";
        $sql_params[] = $unique_image;
    }

    if (!empty($unique_image2)) {
        $sql .= ", image2 = ?";
        $sql_params[] = $unique_image2;
    }

    if (!empty($unique_image3)) {
        $sql .= ", image3 = ?";
        $sql_params[] = $unique_image3;
    }

    $sql .= ", cateId = ?, des = ?, weight = ? WHERE id = ?";

    // Add the remaining parameters to the SQL parameters array
    $sql_params[] = $product['cateId'];
    $sql_params[] = $product['des'];
    $sql_params[] = $product['weight'];
    $sql_params[] = $product['id'];

    // Use a prepared statement to execute the query
    $stmt = mysqli_prepare($db->con, $sql);

    if ($stmt) {
        // Bind parameters to the statement
        $param_types = str_repeat('s', count($sql_params)); // Assuming all parameters are strings
        mysqli_stmt_bind_param($stmt, $param_types, ...$sql_params);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
    } else {
        $result = false;
    }

    return $result;
}

    
    public function getCountPaging($row = 8)
    {
        $db = DB::getInstance();
        $sql = "SELECT COUNT(*) FROM products";
        $result = mysqli_query($db->con, $sql);
        if ($result) {
            $totalrow = intval((mysqli_fetch_all($result, MYSQLI_ASSOC)[0])['COUNT(*)']);
            return ceil($totalrow / $row);
        }
        return false;
    }

    public function getCountPagingByClient($cateId, $row = 8)
    {
        $db = DB::getInstance();
        $sql = "SELECT COUNT(*) FROM products WHERE cateId = $cateId AND status=1";
        $result = mysqli_query($db->con, $sql);
        if ($result) {
            $totalrow = intval((mysqli_fetch_all($result, MYSQLI_ASSOC)[0])['COUNT(*)']);
            return ceil($totalrow / $row);
        }
        return false;
    }

    public function getSoldCountMonth()
    {
        $db = DB::getInstance();
        $sql = "SELECT SUM(p.soldCount) AS total, p.name FROM `orders` o JOIN order_details od ON o.id  JOIN products p ON od.productId = p.id WHERE MONTH(o.createdDate) = MONTH(NOW()) AND o.paymentStatus=1 GROUP BY p.id, MONTH(o.createdDate), YEAR(o.createdDate)";
        $result = mysqli_query($db->con, $sql);
        return $result;
    }
}
