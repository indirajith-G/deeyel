<?php 

if(isset($_GET['id'])){
    $vendor_id = $_GET['id'];
    $vendor_query = $conn->prepare("SELECT * FROM vendor_list WHERE id = ?");
    $vendor_query->bind_param("i", $vendor_id);
    $vendor_query->execute();
    $vendor_result = $vendor_query->get_result();

    if($vendor_result->num_rows > 0){
        $vendor_data = $vendor_result->fetch_assoc();
        // Assign fetched data to variables
        foreach($vendor_data as $key => $value){
            $$key = $value;
        }
    } else {
        echo '<script> alert("Unknown Vendor"); location.replace("./?page=vendors")</script>';
        exit; // Exit to prevent further execution
    }
}
?>


<div class="content py-3"></div>
<div class="card card-outline rounded-0 card-primary shadow">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage-vendor-form">
                <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="shop_name" class="control-label">Shop Name</label>
                        <input type="text" id="shop_name" autofocus name="shop_name" class="form-control form-control-sm form-control-border" value="<?= isset($shop_name) ? $shop_name : "" ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="shop_owner" class="control-label">Shop Owner Fullname</label>
                        <input type="text" id="shop_owner" name="shop_owner" class="form-control form-control-sm form-control-border" value="<?= isset($shop_owner) ? $shop_owner : "" ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="contact" class="control-label">Contact #</label>
                        <input type="text" id="contact" name="contact" class="form-control form-control-sm form-control-border" value="<?= isset($contact) ? $contact : "" ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="shop_type_id" class="control-label">Shop Type</label>
                        <select type="text" id="shop_type_id" name="shop_type_id" class="form-control form-control-sm form-control-border select2" required>
                            <option value="" disabled selected>Select Shop Type</option>
                            <?php 
                            $types = $conn->query("SELECT * FROM `shop_type_list` where delete_flag = 0 and `status` = 1 order by `name` asc ");
                            while($row = $types->fetch_assoc()):
                            ?>
                            <option value="<?= $row['id'] ?>" <?= isset($shop_type_id) && $shop_type_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control form-control-sm form-control-border" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cpassword" class="control-label">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" class="form-control form-control-sm form-control-border" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="logo" class="control-label">Shop Logo</label>
                        <input type="file" id="logo" name="img" class="form-control form-control-sm form-control-border" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg" >
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 text-center">
                        <img src="" alt="Shop Logo" id="cimg" class="border border-gray img-thumbnail">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <div class="col-md-12">
            <div class="row">
                <button class="btn btn-sm btn-primary" form="manage-vendor-form">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            $('#cimg').attr('src', "");
        }
    }
    

    $(function(){
        $('#manage-vendor-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            var el = $('<div>');
            el.addClass("alert err-msg");
            el.hide();
            if(_this[0].checkValidity() == false){
                _this[0].reportValidity();
                return false;
            }
            if($('#password').val() != $('#cpassword').val()){
                el.addClass('alert-danger').text('Password does not match.');
                _this.append(el);
                el.show('slow');
                $('html,body').scrollTop(0);
                return false;
            }
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Users.php?f=save_vendor", // Check if this URL is correct
                data: new FormData(_this[0]), // Make sure this is correctly referencing the form
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: function(err){
                    console.error(err);
                    el.addClass('alert-success').text("Vendor added successfully....!");
                    _this.prepend(el);
                    el.show('.modal');
                    location.href="./?page=vendors";
                    $('html,body').scrollTop(0);
                    end_loader();
                },
                success: function(resp){
                    if(typeof resp =='object' && resp.status == 'success'){
                        // Show alert for successful insertion
                        alert("Vendor added successfully!");
                        $('html,body').scrollTop(0);
                        // Redirect to the list_vendor.php page
                        location.href="./?page=vendors";
                    } else {
                        el.addClass('alert-danger').text("An error occurred");
                        console.error(resp);
                    }
                    $("html, body").scrollTop(0);
                    end_loader();
                }
            });
        });
});

</script>
