<?php
$this->TomatoCrumbs->addCrumbs(
    'Roles',
    Router::url(
        array('action'=>'index')
    ),
    array()
)->addCrumbs(
    'Permissions',
    'javascript:void(0)',
    array(
        'class' => 'active'
    )
);
?>

<h3 class="page-header page-header-top"><i class="icon-key"></i> Permission</h3>

<?PHP echo $this->BootstrapForm->create(); ?>

<div class="form-box-content">

    <br/>
    <div class="form-group">
        <div class="col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Save">
            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>
    <br/>
    <ul id="tab" class="nav nav-tabs" data-toggle="tabs">
        <li><a href="#system-packages">System Packages</a></li>
        <li class="active"><a href="#user-module-packages">User Module Packages</a></li>
        <li><a href="#user-widget-packages">User Widget Packages</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane " id="system-packages">
            <?PHP foreach($tomatoCmsControllers as $controller => $actions): ?>
                <h4><?PHP echo $controller; ?></h4>
                <?PHP foreach(array_keys($actions) as $action): ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?PHP echo Inflector::humanize($action); ?></label>
                        <div class="col-md-">

                            <div class="input-switch pull-left switch-small" data-toggle="tooltip" title="<?PHP echo "TomatoCms.{$controller}.{$action}"; ?>" data-on="success" data-off="danger" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>">
                                <?PHP echo $this->BootstrapForm->checkbox("TomatoCms.{$controller}.{$action}"); ?>
                            </div>
                        </div>
                    </div>

                <?PHP endforeach; ?>
            <?PHP endforeach; ?>
        </div>
        <div class="tab-pane active" id="user-module-packages">
            <?PHP foreach($userModulesControllers as $plugin => $userModulesController): ?>
            <?PHP foreach($userModulesController as $controller => $actions): ?>
                <?PHP if( Configure::read("TomatoAclLabel.{$plugin}.{$controller}") ): ?>
                <h4><?PHP echo Configure::read("TomatoAclLabel.{$plugin}.{$controller}"); ?></h4>
                <?PHP else: ?>
                <h4><?PHP echo $controller; ?></h4>
                <?PHP endif; ?>
                <?PHP foreach(array_keys($actions) as $action): ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?PHP echo Inflector::humanize($action); ?></label>
                        <div class="col-md-5">

                            <div class="input-switch pull-left switch-small" data-toggle="tooltip" title="<?PHP echo "{$plugin}.{$controller}.{$action}"; ?>" data-on="success" data-off="danger" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>">
                                <?PHP echo $this->BootstrapForm->checkbox("{$plugin}.{$controller}.{$action}"); ?>
                            </div>
                        </div>
                    </div>

                <?PHP endforeach; ?>
            <?PHP endforeach; ?>
            <?PHP endforeach; ?>
        </div>
        <div class="tab-pane" id="user-widget-packages">
            <?PHP foreach($userWidgetsControllers as $plugin => $userWidgetsController): ?>
            <?PHP foreach($userWidgetsController as $controller => $actions): ?>
                <?PHP if( Configure::read("TomatoAclLabel.{$plugin}.{$controller}") ): ?>
                    <h4><?PHP echo Configure::read("TomatoAclLabel.{$plugin}.{$controller}"); ?></h4>
                <?PHP else: ?>
                    <h4><?PHP echo $controller; ?></h4>
                <?PHP endif; ?>
                <?PHP foreach(array_keys($actions) as $action): ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?PHP echo Inflector::humanize($action); ?></label>
                        <div class="col-md-5">

                            <div class="input-switch pull-left switch-small" data-toggle="tooltip" title="<?PHP echo "{$plugin}.{$controller}.{$action}"; ?>" data-on="success" data-off="danger" data-on-label="<i class='icon-ok icon-white'></i>" data-off-label="<i class='icon-remove'></i>">
                                <?PHP echo $this->BootstrapForm->checkbox("{$plugin}.{$controller}.{$action}"); ?>
                            </div>
                        </div>
                    </div>

                <?PHP endforeach; ?>
            <?PHP endforeach; ?>
            <?PHP endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-10">
            <input class="btn btn-success" id="btnSave" type="submit" value="Save">
            <button id="btnCancel" class="btn btn-danger" type="submit">Cancel / Back</button>
        </div>
    </div>

    <?PHP echo $this->BootstrapForm->end(null); ?>
</div>

<?PHP echo $this->BootstrapForm->end(null); ?>
<script type="application/javascript">
    $(document).ready(function(){
        $("#btnCancel").unbind('click').bind('click', function(){
            location.href='<?PHP echo Router::url(array("action"=>'index')); ?>';
            return false;
        });
    });
</script>