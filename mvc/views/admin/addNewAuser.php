<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    

    <div class="main-content">

        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>Thêm mới người dùng</h3>
                        <div class="form">
                            <form action="<?= URL_ROOT . '/Admin_user/add' ?>" method="POST" enctype="multipart/form-data">
                            
                                <p class="<?= $data['cssClass'] ?>"><?= isset($data['message']) ? $data['message'] : "" ?></p>
                               <label for="name">Tên </label>
                                <input type="text" id="name" name="fullName" required >
                                <label for="email">Email </label>
                                <input type="text" id="email" name="email" required >
                                <label for="dob">Ngày sinh </label>
                                <input type="date" id="dob" name="dob" required >
                                <label for="address">Địa chỉ </label>
                                <input type="text" id="address" name="address" required >
                                <label for="phone">Số điện thoại </label>
                                <input type="text" id="phone" name="phone" required >
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
