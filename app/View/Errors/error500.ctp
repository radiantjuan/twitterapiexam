<?PHP
$isAdmin = !empty($this->request->params['admin']);
if($isAdmin==false): ?>

    <div style="text-align: center; padding-top: 70px; padding-bottom: 70px;">
        <p>ERROR 500. An Internal Error Has Occurred.</p>
        <p>The page you are looking for does not exist or it may have been moved. Click <a href="/">here</a> to go back to the home page.</p>
    </div>

</div>
<?PHP else: ?>
    <h2><?php echo $message; ?></h2>
    <p class="error">
        <strong><?php echo __d('cake', 'Error'); ?>: </strong>
        <?php echo __d('cake', 'An Internal Error Has Occurred.'); ?>
    </p>
    <?PHP if (Configure::read('debug') > 0):
        echo $this->element('exception_stack_trace');
    endif; ?>
<?PHP endif; ?>