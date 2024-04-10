<div class="content py-3"></div>
<div class="card card-outline rounded-0 card-primary shadow">
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <!-- Set the form action to send_email.php -->
            <form id="manage-vendor-form" action="./?page=vendors/send_email" method="POST">
                <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="vendor_email" class="control-label">Vendor E-mail</label>
                        <input type="email" id="vendor_email" autofocus name="email" class="form-control form-control-sm form-control-border" value="<?= isset($vendor_email) ? $vendor_email : "" ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-primary">Send E-mail</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- <script>
$(function(){
    $('#manage-vendor-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        var vendorEmail = $('#vendor_email').val(); // Get the value of the vendor email input
        
        // Use fetch to send a POST request to send_email.php
        fetch('./?page=vendors/send_email.php', { // Use a relative path from the current URL
            method: 'POST',
            body: JSON.stringify({ email: vendorEmail }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            // console.log(response); // Log the entire response
            return response.json();
        })
        .then(data => {
            console.log(data); // Print the response inside the console
            if (data.status === 'success') {
                alert('Email sent successfully');
            } else {
                alert('Failed to send email');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while posting email to next page');
        });
    });
});
</script> -->
    