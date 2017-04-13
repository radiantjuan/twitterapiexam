<?php echo $this->Session->flash('auth'); ?>

<!-- Login Form -->
<?PHP echo $this->FormEmpty->create('User', array(
    "class" => "form-horizontal"
)); ?>
<h5 class="page-header-sub">Change Password</h5>
<div class="form-group <?PHP if(isset($errors) && isset($errors['password'])) echo "has-error"; ?>">
    <div class="input-group col-xs-12">
        <?php echo $this->FormEmpty->input('password', array('placeholder'=>'New Password', 'class'=>'form-control')); ?>
        <span class="input-group-addon"><i class="icon-key icon-fixed-width"></i></span>
    </div>
    <?PHP if(isset($errors['password'])): ?>
    <?PHP foreach($errors['password'] as $error): ?>
        <span for="val_password" class="help-block"><?PHP echo $error; ?></span>
    <?PHP endforeach; ?>
    <?PHP endif; ?>
</div>

<div class="form-group <?PHP if(isset($errors) && isset($errors['confirm_password'])) echo "has-error"; ?>">
    <div class="input-group col-xs-12">
        <?php echo $this->FormEmpty->input('confirm_password', array('type'=>'password', 'placeholder'=>'Confirm Password', 'class'=>'form-control')); ?>
        <span class="input-group-addon"><i class="icon-key icon-fixed-width"></i></span>
    </div>
    <?PHP if(isset($errors['confirm_password'])): ?>
    <?PHP foreach((array)$errors['confirm_password'] as $error): ?>
        <span for="val_confirm_password" class="help-block"><?PHP echo $error; ?></span>
    <?PHP endforeach; ?>
    <?PHP endif; ?>
</div>
<br/>
<div class="clearfix">
    <div class="btn-group btn-group-sm pull-right">
        <button type="button" id="login-button-submit" class="btn btn-success"><i class="icon-arrow-right"></i> Change Password</button>
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
        $("#login-button-submit").unbind('click').click(function(){
            $("#UserAdminResetPasswordForm").submit();
        });
    });
</script>