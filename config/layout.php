<?php

return [
    'background' => [
        'animated' => filter_var( env( 'LAYOUT_ANIMATED_BACKGROUND', true ), FILTER_VALIDATE_BOOLEAN ),
    ],
    'server_list' => env( 'SERVER_LIST_FILE', '#' )
];
