<?php 
if(isset($_SESSION['registration_message'])) {
    echo '<p class="alert alert-success">'.$_SESSION['registration_message'].'</p>';
    unset($_SESSION['registration_message']);
    echo '<script>
        setTimeout(function() {
            $(".alert").slideUp(500);
        }, 2000);
    </script>';
}
if(isset($_SESSION['login']) && $_SESSION['login']){
    header("Location: index.php?page=dashboard");
    exit();
}

?>
<div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Enter your credentials
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" id="loginForm" novalidate>
                                <div class="form-group">
                                    <label for="emailid">Enter Email:</label>
                                    <input class="form-control" type="text" name="emailid" required autocomplete="off" value="<?php echo $email; ?>">
                                    <span class="error"><?php echo $emailErr; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input class="form-control" type="password" name="password" required autocomplete="off">
                                    <span class="error"><?php echo $passwordErr; ?></span>
                                </div>
                                <button type="submit" name="login" class="btn btn-info">LOGIN</button> | <a href="index.php?page=register">Not Registered Yet</a>
                                <div class="error"><?php echo isset($errorMsg) ? $errorMsg : ''; ?></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> 