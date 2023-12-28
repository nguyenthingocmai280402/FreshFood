<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">
        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <!-- <a href="<?php echo URL_ROOT . '/Admin_user/add' ?>" class="button right">Thêm mới</a> -->
                        <h3>Danh sách người dùng</h3>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Ngày sinh</th>
                                        <th>Địa chỉ</th>
                                        <th>Điện thoại</th>
                                        <th>Phân quyền</th>
                                        <th>Trạng thái </th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0; foreach ($data['userList'] as $value) : ?>
                                        <tr>
                                        <td><?= ++$count ?></td>
                                            <td><?php echo $value['fullName'] ?></td>
                                            <td><?php echo $value['email'] ?></td>
                                            <td><?php echo $value['dob'] ?></td>
                                            <td><?php echo $value['address'] ?></td>
                                            <td><?php echo $value['phone'] ?></td>
                                            <td><?php echo ($value["roleId"] == 1) ? "Admin" : "Normal"; ?></td>

                                            <td>
                                                <?php if ($value['status']) : ?>
                                                    <span class="active">Kích hoạt</span>
                                                <?php else : ?>
                                                    <span class="block">Đã Xoá</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($value['status']) : ?>
                                                    <a class="button-red" href="<?= URL_ROOT . '/Admin_user/changeStatus/' . $value['id'] ?>">Xoá</a>
                                                <?php else : ?>
                                                    <a class="button-green" href="<?= URL_ROOT . '/Admin_user/changeStatus/' . $value['id'] ?>">Mở</a>
                                                <?php endif; ?>
                                                <a class="button-normal" href="<?= URL_ROOT . '/Admin_user/edit/' . $value['id'] ?>">Sửa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
