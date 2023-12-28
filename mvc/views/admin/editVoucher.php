<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">

        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>Xem/Sửa voucher</h3>
                        <div class="form">
                            <form action="<?= URL_ROOT . '/voucherManage/edit' ?>" method="POST">
                                <input type="hidden" name="id" value="<?= $data['voucher']['id'] ?>">
                                <p class="<?= $data['cssClass'] ?>"><?= isset($data['message']) ? $data['message'] : "" ?></p>
                                <label for="name">Tên voucher</label>
                                <input type="varchar" id="code" name="code" required value="<?= $data['voucher']['code'] ?>">
                                <!-- <label for="name">Tên voucher</label>
                                <input type="varchar" id="code" name="code" required value="<?= $data['voucher']['code'] ?>"> -->
                                <input type="submit" value="Lưu">
                                <a href="<?= URL_ROOT . '/voucherManage' ?>" class="back">Trở về</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>
</body>

</html>