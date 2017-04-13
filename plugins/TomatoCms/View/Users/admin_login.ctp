<!-- Login Form -->
<?PHP echo $this->FormEmpty->create('User', array(
    "class" => "form-horizontal"
)); ?>
    <div class="form-group">
        <div class="input-group col-xs-12">
            <?php echo $this->FormEmpty->input('email', array('placeholder'=>'Email..', 'class'=>'form-control')); ?>
            <span class="input-group-addon"><i class="icon-envelope-alt icon-fixed-width"></i></span>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group col-xs-12">
            <?php echo $this->FormEmpty->input('password', array('placeholder'=>'Password..', 'class'=>'form-control')); ?>
            <span class="input-group-addon"><i class="icon-asterisk icon-fixed-width"></i></span>
        </div>
    </div>
    <div class="clearfix">
        <div class="btn-group btn-group-sm pull-right">
            <button type="button" id="login-button-pass" class="btn btn-warning" data-toggle="tooltip" title="Forgot pass?"><i class="icon-lock"></i></button>
            <button type="submit" class="btn btn-success"><i class="icon-arrow-right"></i> Login</button>
        </div>

<!--        <div class="input-switch pull-left" data-toggle="tooltip" title="Remember me" data-on="success" data-off="danger" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>">-->
<!--            --><?PHP //echo $this->FormEmpty->checkbox('remember_me'); ?>
<!--        </div>-->
    </div>
<?PHP echo $this->Form->end(); ?>
<!-- END Login Form -->
<script type="application/javascript">
    $(document).ready(function(){
        $("#login-button-pass").unbind('click').click(function(){
            location.href='<?PHP echo Router::url('/admin/forgot-password'); ?>';
        });
    });
</script>