<?PHP
$isAdmin = !empty($this->request->params['admin']);
if($isAdmin==false): ?>
<body class="page-404">
<?php echo $this->element('body_start'); ?>

<!-- WRAPPER START -->
<div id="wrapper">
    <!-- HEADER START -->
        <?PHP echo $this->element('header_container'); ?>
    <!-- HEADER END -->


    <!-- CONTENT START -->
    <div id="content" class="site-content">
        <div class="container-fluid">
            <?PHP if (Configure::read('debug') > 0): ?>
                <h2><?php echo __d('cake_dev', 'Database Error'); ?></h2>
                <p class="error">
                    <strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
                    <?php echo $message; ?>
                </p>
                <?php if (!empty($error->queryString)) : ?>
                    <p class="notice">
                        <strong><?php echo __d('cake_dev', 'SQL Query'); ?>: </strong>
                        <?php echo h($error->queryString); ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($error->params)) : ?>
                    <strong><?php echo __d('cake_dev', 'SQL Query Params'); ?>: </strong>
                    <?php echo Debugger::dump($error->params); ?>
                <?php endif; ?>
                <p class="notice">
                    <strong><?php echo __d('cake_dev', 'Notice'); ?>: </strong>
                    <?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'pdo_error.ctp'); ?>
                </p>
                <?php echo $this->element('exception_stack_trace'); ?>
            <?PHP else: ?>
            <h2 class="heading-default">Error 404</h2>
            <div class="container-404 bordered-box clearfix">
                <div class="image-container">
                    <img src="http://images-mysky.com.ph.s3.amazonaws.com/theme/images/404-image.png" alt="Error 404">
                </div>
                <div class="text-container">
                    <h1 class="fw-700">Oops! We can’t seem to find the page you’re looking for.</h1>
                    <p>The page may have been moved or deleted. Or you may have mistyped the URL. </p>
                    <p>Please retype the link or refresh the page. If that doesn’t work, please contact us and we’ll fix the problem for you. Thank you!</p>
                    <?PHP if(isset($this->request->location)): ?>
                        <a href="<?PHP echo Router::url('/'.$this->request->location); ?>" class="btn btn-red btn-load-more">Go Back to Homepage <i class="spr-sky icon-arrow-right"></i></a>
                    <?PHP else: ?>
                        <a href="<?PHP echo Router::url('/'); ?>" class="btn btn-red btn-load-more">Go Back to Homepage <i class="spr-sky icon-arrow-right"></i></a>
                    <?PHP endif; ?>
                </div>
            </div>
            <?PHP endif; ?>
        </div>

        <?PHP echo $this->element('footer'); ?>

    </div>
    <!-- CONTENT END -->

</div>
<?PHP else: ?>
    <?PHP if (Configure::read('debug') > 0): ?>
        <h2><?php echo __d('cake_dev', 'Database Error'); ?></h2>
        <p class="error">
            <strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
            <?php echo $message; ?>
        </p>
        <?php if (!empty($error->queryString)) : ?>
            <p class="notice">
                <strong><?php echo __d('cake_dev', 'SQL Query'); ?>: </strong>
                <?php echo h($error->queryString); ?>
            </p>
        <?php endif; ?>
        <?php if (!empty($error->params)) : ?>
            <strong><?php echo __d('cake_dev', 'SQL Query Params'); ?>: </strong>
            <?php echo Debugger::dump($error->params); ?>
        <?php endif; ?>
        <p class="notice">
            <strong><?php echo __d('cake_dev', 'Notice'); ?>: </strong>
            <?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'pdo_error.ctp'); ?>
        </p>
        <?php echo $this->element('exception_stack_trace'); ?>
    <?PHP endif; ?>
<?PHP endif; ?>