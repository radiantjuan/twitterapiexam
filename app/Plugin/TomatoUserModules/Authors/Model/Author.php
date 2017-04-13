<?PHP
App::uses('AuthorsAppModel', 'Authors.Model');
App::uses('CrudOnEditBeforeCallbackTraits', 'TomatoCms.Traits');

class Author extends AuthorsAppModel
{

    use CrudOnEditBeforeCallbackTraits;

    public $actsAs = [
        'TomatoCms.Trackable' => [
            'priority' => 1,
            'fields' => [
                'created_by' => 'created_by_id',
                'updated_by' => 'updated_by_id'
            ]
        ]
    ];

    public $validate = [
        'name' => [
            "notBlank"  => [
                "rule"     => "notBlank",
                "message"  => "This field is required"
            ]
        ],
        'email_address' => [
            "notBlank"  => [
                "rule"     => "notBlank",
                "message"  => "This field is required"
            ],
            "email"  => [
                "rule"     => "email",
                "message"  => "Invalid email address"
            ]
        ],
        'description' => [
            "notBlank"  => [
                "rule"     => "notBlank",
                "message"  => "This field is required"
            ]
        ]
    ];

}
