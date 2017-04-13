<?PHP
Configure::write('TomatoAclLabel.WebConfig.WebConfig', 'Web Config');
Configure::write('TomatoAcl.WebConfig.WebConfig.index', array(
    'admin_index'
));
Configure::write('TomatoAcl.WebConfig.WebConfig.add', array(
    'admin_add'
));
Configure::write('TomatoAcl.WebConfig.WebConfig.edit', array(
    'admin_edit'
));
Configure::write('TomatoAcl.WebConfig.WebConfig.delete', array(
    'admin_delete'
));
Configure::write('TomatoAcl.WebConfig.WebConfig.activate', array(
    'admin_activate'
));
Configure::write('TomatoAcl.WebConfig.WebConfig.deactivate', array(
    'admin_deactivate'
));