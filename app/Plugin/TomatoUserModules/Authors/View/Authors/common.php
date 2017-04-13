<?PHP
$crudShema =
[
    [
        'fieldName' => 'name',
        'label'     => 'Name',
        'options'   => []
    ],
    [
        'fieldName' => 'email_address',
        'options'   => [
            'type' => 'email'
        ]
    ],
    [
        'fieldName' => 'description',
        'options'   => [
            'type'    => "textarea",
            "class"   => 'ckeditor',
            'between' => '<div class="col-md-8">'
        ]
    ]
];

$this->set('crudShema'  , $crudShema);
$this->set('modelName'  , 'Author');
$this->set('formOptions', array('novalidate'=>true));
