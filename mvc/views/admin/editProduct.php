<?php require APP_ROOT . '/views/admin/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/admin/inc/sidebar.php'; ?>

    <div class="main-content">
        <main>
            <section class="recent">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h3>Cập nhật sản phẩm</h3>
                        <div class="form">
                            <form action="<?= URL_ROOT . '/productManage/edit' ?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $data['product']['id'] ?>">
                                <p class="<?= $data['cssClass'] ?>"><?= isset($data['message']) ? $data['message'] : "" ?></p>
                                <!-- <label for="name">Tên sản phẩm</label>
                                <input type="text" id="name" name="name" required value="<?= $data['product']['name'] ?>"> -->
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
                                    <input type="text" id="name" name="name" required value="<?= $data['product']['name'] ?>" oninput="checkLength(this)">
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

                                    <!-- Danh mục -->
                                <label for="cate">Danh mục</label>
                                <select name="cateId" id="cate">
                                    <?php
                                    foreach ($data['categoryList'] as $key => $value) { ?>
                                        <?php
                                        if ($value['id'] == $data['product']['cateId']) { ?>
                                            <option selected value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                        <?php  } else { ?>
                                            <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                        <?php }
                                        ?>
                                    <?php }
                                    ?>
                                </select>
                                <label for="image">Hình ảnh 1</label>
                                <p>
                                    <img style="height: 300px;" src="<?= URL_ROOT . '/public/images/' . $data['product']['image'] ?>" alt="">
                                </p>
                                <label for="image">Hình ảnh 2</label>
                                <p>
                                    <img style="height: 300px;" src="<?= URL_ROOT . '/public/images/' . $data['product']['image2'] ?>" alt="">
                                </p>
                                <label for="image">Hình ảnh 3</label>
                                <p>
                                    <img style="height: 300px;" src="<?= URL_ROOT . '/public/images/' . $data['product']['image3'] ?>" alt="">
                                </p>
                                <label for="image">Chọn hình ảnh mới 1</label>
                                <input type="file" id="image" name="image">
                                <label for="image">Chọn hình ảnh mới 2</label>
                                <input type="file" id="image2" name="image2">
                                <label for="image">Chọn hình ảnh mới 3</label>
                                <input type="file" id="image3" name="image3">
                                <label for="originalPrice">Giá gốc</label>
                                <input type="number" id="originalPrice" name="originalPrice" required value="<?= $data['product']['originalPrice'] ?>">
                                <label for="promotionPrice">Giá khuyến mãi</label>
                                <input type="number" id="promotionPrice" name="promotionPrice" required onchange="check(this)" value="<?= $data['product']['promotionPrice'] ?>">
                                <!-- <label for="qty">Số lượng</label>
                                <input type="text" id="qty" name="qty" required oninput="javascript: if (this.value.length > 11) this.value = this.value.slice(0, 11);" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="\d{1,11}" title="Vui lòng nhập đúng định dạng là số" value="<?= $data['product']['qty'] ?>">

                                <label for="weight">Trọng lượng (g)</label>
                                <input type="text" id="weight" name="weight" required oninput="javascript: if (this.value.length > 11) this.value = this.value.slice(0, 11);" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="\d{1,11}" title="Vui lòng nhập đúng định dạng là số" value="<?= $data['product']['weight'] ?>"> -->
                                <style>
                                    .error-message {
                                        color: red;
                                        display: block;
                                        margin-top: 5px; /* Khoảng cách giữa input và thông báo */
                                    }
                                </style>

                                <label for="qty">Số lượng</label>
                                <input type="number" id="qty" name="qty" required oninput="validateNumberInput(this, 11)" value="<?= $data['product']['qty'] ?>">
                                <span id="qtyError" class="error-message"></span>

                                <label for="weight">Trọng lượng (g):</label>
                                <input type="number" id="weight" name="weight" required oninput="validateNumberInput(this, 11)" value="<?= $data['product']['weight'] ?>">
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
                                        errorSpan.textContent = "Yêu cầu nhập dữ liệu là số";
                                    }
                                }
                                </script>


                                <label for="des">Mô tả</label>
                                <textarea name="des" id="des" cols="30" rows="10"><?= $data['product']['des'] ?></textarea>
                                <input type="submit" value="Lưu">
                                <a href="<?= URL_ROOT . '/productManage' ?>" class="back">Trở về</a>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>

    </div>
    <script language='javascript' type='text/javascript'>
    function check(input) {
        input.setCustomValidity('');
      if (input.value > document.getElementById('originalPrice').value) {
        input.setCustomValidity('Giá khuyến mãi không được lớn hơn giá gốc!');
      } else {
        input.setCustomValidity('');
      }
    }
  </script>
</body>

</html>