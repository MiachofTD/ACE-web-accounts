<?php

return [
    'animated_background' => filter_var( env( 'LAYOUT_ANIMATED_BACKGROUND', true ), FILTER_VALIDATE_BOOLEAN ),
];
