<?PHP echo $this->element('TomatoCms.default_header'); ?>


<!-- Login Container -->
<div id="login-container">
    <div id="login-logo">
    	<i class="icon icon-user" style="font-size:72px"></i>
        <?PHP
        	// echo $this->Html->image('TomatoCms.template/uadmin_logo.png', array('alt' => 'Logo'));
        ?>
        <br/><br/>
    </div>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
</div>
<!-- END Login Container -->

<?PHP echo $this->element('TomatoCms.default_footer'); ?>
