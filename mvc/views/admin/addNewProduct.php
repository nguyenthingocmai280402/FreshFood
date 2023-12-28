<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>rch
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">
        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>Thêm mới sản phẩm</h3>
                        <div class="form">
                            <form action="<?= URL_ROOT . '/productManage/add' ?>" method="POST" enctype="multipart/form-data">
                                <p class="<?= $data['cssClass'] ?>"><?= isset($data['message']) ? $data['message'] : "" ?></p>
                                <!-- Tên sản phẩm -->
                                <style>
                                    .clear-button {
                                        position: absolute;
                                        right: 5px;
                                        top: 50%;
                                        transform: translateY(-50%);
                                        display: none;
                                        cursor: pointer;
                                    }
                                </style>

                                <label for="name">Tên sản phẩm</label>
                                <div style="position: relative;">
                                    <input type="text" id="name" name="name" required oninput="checkLength(this)">
                                    <span id="clearButton" class="clear-button" onclick="clearInput()">x</span>
                                </div>

                                <script>
                                function checkLength(input) {
                                    var maxLength = 255;
                                    var clearButton = document.getElementById("clearButton");

                                    if (input.value.length > maxLength) {
                                        alert("Vui lòng nhập dưới 255 ký tự");
                                        input.value = input.value.substring(0, maxLength);
                                    }

                                    if (input.value.length > 0) {
                                        clearButton.style.display = "block";
                                    } else {
                                        clearButton.style.display = "none";
                                    }
                                }

                                function clearInput() {
                                    var input = document.getElementById("name");
                                    var clearButton = document.getElementById("clearButton");
                                    input.value = "";
                                    clearButton.style.display = "none";
                                }
                                </script>

                <!-- Danh mục  -->
                                <label for="cate">Danh mục</label>
                                <select name="cateId" id="cate">
                                    <?php
                                    foreach ($data['categoryList'] as $key => $value) { ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <label for="image">Hình ảnh 1</label>
                                <input type="file" id="image" name="image" required>
                                <label for="image">Hình ảnh 2</label>
                                <input type="file" id="image2" name="image2" required>
                                <label for="image">Hình ảnh 3</label>
                                <input type="file" id="image3" name="image3" required>
                                <label for="originalPrice">Giá gốc</label>
                                <input type="number" id="originalPrice" name="originalPrice" required>
                                <label for="promotionPrice">Giá khuyến mãi</label>
                                <input type="number" id="promotionPrice" name="promotionPrice" required>
                                <!-- <label for="qty">Số lượng</label>
                                <input type="number" id="qty" name="qty" required>
                                <label for="weight">Trọng lượng (g):</label>
                                <input type="number" id="weight" name="weight" required> -->
                                <!-- Số lượng, trọng lượng -->
                                <style>
                                    .error-message {
                                        color: red;
                                        display: block;
                                        margin-top: 5px; /* Khoảng cách giữa input và thông báo */
                                    }
                                </style>

                                <label for="qty">Số lượng</label>
                                <input type="number" id="qty" name="qty" required oninput="validateNumberInput(this, 11)">
                                <span id="qtyError" class="error-message"></span>

                                <label for="weight">Trọng lượng (g):</label>
                                <input type="number" id="weight" name="weight" required oninput="validateNumberInput(this, 11)">
                                <span id="weightError" class="error-message"></span>

                                <script>
                                function validateNumberInput(input, maxLength) {
                                    var value = input.value;

                                    // Kiểm tra xem giá trị có chứa chữ không
                                    if (/[^0-9]/.test(value)) {
                                        // Nếu có chữ, loại bỏ chữ và hiển thị thông báo
                                        input.value = value.replace(/\D/g, '');
                                        var errorSpan = document.getElementById(input.id + "Error");
                                        errorSpan.textContent = "Chỉ được nhập số";
                                    } else {
                                        // Nếu là số, kiểm tra độ dài
                                        if (value.length > maxLength) {
                                            input.value = value.substring(0, maxLength);
                                            var errorSpan = document.getElementById(input.id + "Error");
                                            errorSpan.textContent = "Vui lòng nhập dưới " + maxLength + " ký tự";
                                        } else {
                                            // Độ dài hợp lệ, ẩn thông báo
                                            var errorSpan = document.getElementById(input.id + "Error");
                                            errorSpan.textContent = "";
                                        }
                                    }
                                    
                                    // Kiểm tra nếu không có giá trị (không nhập số)
                                    if (value === "") {
                                        var errorSpan = document.getElementById(input.id + "Error");
                                        errorSpan.textContent = "Yêu cầu nhập giá trị là số";
                                    }
                                }
                                </script>

                                <label for="des">Mô tả</label>
                                <textarea name="des" id="des" cols="30" rows="10"></textarea>
                                <input type="submit" value="Lưu">
                                <a href="<?= URL_ROOT . '/productManage' ?>" class="back">Trở về</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </main>

    </div>
</body>

</html>