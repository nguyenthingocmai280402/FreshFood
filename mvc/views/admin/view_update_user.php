<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">

        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>Xem/Sửa người dùng</h3>
                        <div class="form">
                            <form action="<?= URL_ROOT . '/Admin_user/edit' ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data['Auser']['id'] ?>">
                                <p class="<?= $data['cssClass'] ?>"><?= isset($data['message']) ? $data['message'] : "" ?></p>
                               <label for="name">Tên </label>
                                <input type="text" id="name" name="fullName" required value="<?= $data['Auser']['fullName'] ?>">
                                <label for="email">Địa chỉ </label>
                                <input type="text" id="email" name="email" required value="<?= $data['Auser']['email'] ?>">
                                <label for="dob">Ngày sinh </label>
                                <input type="date" id="dob" name="dob" required value="<?= $data['Auser']['dob'] ?>">
                                <label for="address">Địa chỉ </label>
                                <input type="text" id="address" name="address" required value="<?= $data['Auser']['address'] ?>">
                                <label for="phone">Số điện thoại </label>
                                <input type="text" id="phone" name="phone" required value="<?= $data['Auser']['phone'] ?>">
                                <input type="submit" value="Lưu">
                                <a href="<?= URL_ROOT . '/Admin_user' ?>" class="back">Trở về</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    
</body>
</html>
