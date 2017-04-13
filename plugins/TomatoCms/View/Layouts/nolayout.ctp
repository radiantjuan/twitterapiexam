<?PHP echo $this->element('TomatoCms.nolayout_header'); ?>

<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>

<?PHP echo $this->element('TomatoCms.default_footer'); ?>