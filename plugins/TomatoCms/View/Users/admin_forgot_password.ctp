<?php echo $this->Session->flash('auth'); ?>

<!-- Login Form -->
<?PHP echo $this->FormEmpty->create('User', array(
    "class" => "form-horizontal"
)); ?>
<h5 class="page-header-sub">We will send password reset instructions to the email address associated with your account.</h5>
    <div class="form-group">
        <div class="input-group col-xs-12">
            <?php echo $this->FormEmpty->input('email', array('placeholder'=>'Enter your Email', 'class'=>'form-control')); ?>
            <span class="input-group-addon"><i class="icon-envelope-alt icon-fixed-width"></i></span>
        </div>
    </div>
    <br/>
    <div class="clearfix">
        <div class="btn-group btn-group-sm pull-right">
            <button type="button" id="login-button-pass-submit" class="btn btn-success"><i class="icon-arrow-right"></i> Send Password Reset Instructions</button>
            <button type="button" id="login-button-login" class="btn btn-warning" data-toggle="tooltip" title="" data-original-title="Login"><i class="icon-off"></i></button>
        </div>
    </div>
<?PHP echo $this->FormEmpty->end(null); ?>
<!-- END Login Form -->
<script type="application/javascript">
    $(document).ready(function(){
        $("#login-button-login").unbind('click').click(function(){
            location.href='<?PHP echo Router::url('/admin/tomato/users/login'); ?>';
        });
        $("#login-button-pass-submit").unbind('click').click(function(){
            $("#UserAdminForgotPasswordForm").submit();
        });
    });
</script>