<!-- Modernizr (Browser feature detection library) & Respond.js (Enable responsive CSS code on browsers that don't support them) -->

<?PHP echo $this->Html->script('TomatoCms.vendor/modernizr-2.6.2-respond-1.1.0.min'); ?>

<?php echo $this->Html->script('TomatoCms.ckeditor/ckeditor', array('inline' => false));?>
<?php echo $this->Html->script('TomatoCms.ckeditor/config', array('inline' => false));?>

<!-- Bootstrap.js -->
<?PHP echo $this->Html->script('TomatoCms.vendor/bootstrap.min'); ?>

<!-- Jquery plugins and custom javascript code -->
<?PHP echo $this->Html->script('TomatoCms.plugins'); ?>
<?PHP echo $this->Html->script('TomatoCms.main'); ?>
<?PHP echo $this->Html->script('TomatoCms.jquery.slugify'); ?>

<!-- Javascript code only for this page -->

<!-- CakePHP SCRIPT,CSS WriteBuffer -->
<?php
echo $this->TomatoLayout->js();
echo $this->fetch('script');
?>
<!-- End CakePHP CSS WriteBuffer -->

<?php
echo $this->fetch('scriptBottom');
echo $this->Js->writeBuffer();
?>
</body>
</html>