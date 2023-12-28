<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">
    <header>
    <p class="1" style="white-space:nowrap">Tìm kiếm danh mục</p>
        <div class="search-wrapper">
            <form action="<?= URL_ROOT ?>/categoryManage/index" method="get">
                <input type="search" placeholder="Tìm kiếm" name="keyword" oninput="checkLength(this)">
            </form>
        </div>

        <script>
        function checkLength(input) {
            if (input.value.length > 255) {
                alert("Vui lòng nhập dưới 255 ký tự");
                input.value = input.value.substring(0, 255);
            }
        }
        </script>

        </header>
        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <a href="<?= URL_ROOT . '/categoryManage/add' ?>" class="button right">Thêm mới</a>
                        <h3>Danh sách danh mục</h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    foreach ($data['categoryList'] as $key => $value) {
                                    ?>
                                        <tr>
                                            <td><?= ++$count ?></td>
                                            <td><?= $value['name'] ?></td>
                                            <?php
                                            if ($value['status']) { ?>
                                                <td><span class="active">Kích hoạt</span></td>
                                            <?php } else { ?>
                                                <td><span class="block">Đã Xoá</span></td>
                                            <?php }
                                            ?>
                                            <td>
                                                <?php
                                                if ($value['status']) { ?>
                                                    <a class="button-red" href="<?= URL_ROOT . '/categoryManage/changeStatus/' . $value['id'] ?>">Xoá</a>
                                                <?php } else { ?>
                                                    <a class="button-green" href="<?= URL_ROOT . '/categoryManage/changeStatus/' . $value['id'] ?>">Mở</a>
                                                <?php }
                                                ?>
                                                </a>
                                                <a class="button-normal" href="<?= URL_ROOT . '/categoryManage/edit/' . $value['id'] ?>">Sửa</a>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                         <!-- Tổng số bản ghi -->
                         <a href="">
                            <?php
                            // Kết nối đến cơ sở dữ liệu
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "thucphamsach";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Kiểm tra kết nối
                            if ($conn->connect_error) {
                                die("Kết nối không thành công: " . $conn->connect_error);
                            }

                            // Truy vấn SQL để đếm số lượng sản phẩm
                            $sql = "SELECT COUNT(*) AS total_category FROM 	categories";
                            $result = $conn->query($sql);

                            // Kiểm tra và lấy tổng số sản phẩm
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $totalCategory = $row['total_category'];
                                echo "Tổng số bản ghi: " . $totalCategory;
                            } else {
                                echo "Không có sản phẩm trong bảng 'categories'";
                            }

                            // Đóng kết nối
                            $conn->close();
                            ?>
                             </a>
                            <a href="<?= URL_ROOT ?>/categoryManage?page=<?= (isset($_GET['page'])) ? (($_GET['page'] <= 1) ? 1 : $_GET['page'] - 1) : 1 ?>">&laquo;</a>
                            <?php
                            if (isset($data['countPaging'])) {
                            for ($i = 1; $i <= $data['countPaging']; $i++) {
                                if (isset($_GET['page'])) {
                                    if ($i == $_GET['page']) { ?>
                                        <a class="active" href="<?= URL_ROOT ?>/categoryManage?page=<?= $i ?>"><?= $i ?></a>
                                    <?php } else { ?>
                                        <a href="<?= URL_ROOT ?>/categoryManage?page=<?= $i ?>"><?= $i ?></a>
                                    <?php  }
                                } else {
                                    if ($i == 1) { ?>
                                        <a class="active" href="<?= URL_ROOT ?>/categoryManage?page=<?= $i ?>"><?= $i ?></a>
                                    <?php  } else { ?>
                                        <a href="<?= URL_ROOT ?>/categoryManage?page=<?= $i ?>"><?= $i ?></a>
                                    <?php   } ?>
                                <?php  } ?>
                            <?php }
                            }
                            ?>
                            <a href="<?= URL_ROOT ?>/categoryManage?page=<?= (isset($_GET['page'])) ? ($_GET['page'] == $data['countPaging'] ? $_GET['page'] : $_GET['page'] + 1) : 2 ?>">&raquo;</a>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>
</body>

</html>