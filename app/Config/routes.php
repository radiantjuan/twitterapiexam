<?php
CakePlugin::routes();

Router::mapResources('twitter');
Router::parseExtensions();

Router::connect(
    "/edit-post/:postid/:slug",
    [
        'controller' => 'Home',
        'action'     => 'edit_post'
    ],
    [
        'postid'       => '[0-9]+',
        'slug'     => '[a-zA-Z0-9-_]+',
    ]
);

Router::connect(
    "/post/:postid/:slug",
    [
        'controller' => 'Home',
        'action'     => 'get_post'
    ],
    [
        'postid'       => '[0-9]+',
        'slug'     => '[a-zA-Z0-9-_]+',
    ]
);

Router::connect(
    "/search",
    [
        'controller' => 'Home',
        'action'     => 'search_post',
    ]
);

Router::connect(
    "/404", array(
        'controller' => 'app',
        'action'     => 'error_page'
    )
);

Router::connect(
    "/internal-server-error", array(
        'controller' => 'app',
        'action'     => 'error_page'
    )
);

Router::connect(
    "/", array(
        'controller' => 'home',
        'action'     => 'index'
    )
);

Router::connect(
    "/search/:action/*", array(
        'controller' => 'search'
    )
);

Router::connect(
    "/account/activate/success/*", array(
        'controller' => 'account',
        'action' => 'activate_success'
    )
);

Router::connect(
    "/account/activate/failed/*", array(
        'controller' => 'account',
        'action' => 'activate_failed'
    )
);

// Become A Host
Router::connect(
    "/become-a-host", array(
        'controller' => 'become_a_host',
        'action'     => 'index'
    )
);

Router::connect(
    "/become-a-host/homeowner", array(
        'controller' => 'become_a_host',
        'action'     => 'homeowner'
    )
);
Router::connect(
    "/become-a-host/homeowner/thank-you", array(
        'controller' => 'become_a_host',
        'action'     => 'owner_thankyou'
    )
);

Router::connect(
    "/become-a-host/food-and-drinks", array(
        'controller' => 'become_a_host',
        'action'     => 'food_and_drinks'
    )
);
Router::connect(
    "/become-a-host/food-and-drinks/thank-you", array(
        'controller' => 'become_a_host',
        'action'     => 'food_and_drinks_thankyou'
    )
);

Router::connect(
    "/become-a-host/hotel-resort", array(
        'controller' => 'become_a_host',
        'action'     => 'hotel_resort'
    )
);
Router::connect(
    "/become-a-host/hotel-resort/thank-you", array(
        'controller' => 'become_a_host',
        'action'     => 'hotel_resort_thankyou'
    )
);

Router::connect(
    "/become-a-host/organize-event", array(
        'controller' => 'become_a_host',
        'action'     => 'organize_event'
    )
);
Router::connect(
    "/become-a-host/organize-event/thank-you", array(
        'controller' => 'become_a_host',
        'action'     => 'organize_event_thankyou'
    )
);

Router::connect(
    "/become-a-host/local-guide", array(
        'controller' => 'become_a_host',
        'action'     => 'local_guide'
    )
);
Router::connect(
    "/become-a-host/local-guide/thank-you", array(
        'controller' => 'become_a_host',
        'action'     => 'local_guide_thankyou'
    )
);

/* Attractions */
Router::connect(
    "/attraction/:attraction_id/:slug",
    [
        'controller' => 'attractions',
        'action'     => 'index'
    ],
    [
        'attraction_id' => '[0-9]+'
    ]
);

/* Hotels */
Router::connect(
    "/hotel/:hotel_id/:slug",
    [
        'controller' => 'hotels',
        'action'     => 'index'
    ],
    [
        'hotel_id' => '[0-9]+'
    ]
);

/* Tour and Actiities */
Router::connect(
    "/tours-and-activities/:tour_id/:slug",
    [
        'controller' => 'tours',
        'action'     => 'index'
    ],
    [
        'tour_id' => '[0-9]+'
    ]
);

/* Place */
Router::connect(
    "/place/province/:province_id/:province_name/:short_description",
    [
        'controller' => 'place',
        'action'     => 'index'
    ],
    [
        'province_id'       => '[0-9]+',
        'province_name'     => '[a-zA-Z0-9-_]+',
        'short_description' => '[a-zA-Z0-9-_]+',
    ]
);
// w/out short description
Router::connect(
    "/place/province/:province_id/:province_name",
    [
        'controller' => 'place',
        'action'     => 'index'
    ],
    [
        'province_id'       => '[0-9]+',
        'province_name'     => '[a-zA-Z0-9-_]+'
    ]
);

Router::connect(
    "/place/city-municipality/:province_id/:province_name/:city_municipality_id/:city_municipality_name/:short_description",
    [
        'controller' => 'place_city_municipality',
        'action'     => 'index'
    ],
    [
        'province_id'             => '[0-9]+',
        'province_name'           => '[a-zA-Z0-9-_]+',
        'city_municipality_id'    => '[0-9]+',
        'city_municipality_name'  => '[a-zA-Z0-9-_]+',
        'short_description'       => '[a-zA-Z0-9-_]+',
    ]
);
// w/out short description
Router::connect(
    "/place/city-municipality/:province_id/:province_name/:city_municipality_id/:city_municipality_name",
    [
        'controller' => 'place_city_municipality',
        'action'     => 'index'
    ],
    [
        'province_id'             => '[0-9]+',
        'province_name'           => '[a-zA-Z0-9-_]+',
        'city_municipality_id'    => '[0-9]+',
        'city_municipality_name'  => '[a-zA-Z0-9-_]+'
    ]
);

// Book Hotel
Router::connect(
    "/hotel/book/*",
    [
        'controller' => 'hotels',
        'action'     => 'book'
    ]
);

/**
* Load the CakePHP default routes. Only remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';
