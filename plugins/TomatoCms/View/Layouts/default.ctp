<?PHP echo $this->element('TomatoCms.default_header'); ?>

    <div id="inner-container">
        <aside id="page-sidebar" class="collapse navbar-collapse navbar-main-collapse">
            <?PHP echo $this->TomatoNav->renderNav(); ?>
        </aside>

        <div id="page-content">
            <?PHP echo $this->TomatoCrumbs->getCrumbs(); ?>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->fetch('content'); ?>
        </div>

        <footer>
            <strong>&copy; 2016. <a href="http://www.abs-cbn.com" target="_blank">XPLORRA</a>. </strong>All Rights Reserved.</strong>
        </footer>
    </div>

<?PHP echo $this->element('TomatoCms.default_footer'); ?>