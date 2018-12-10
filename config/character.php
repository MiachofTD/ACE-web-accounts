<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/1/17
 * Time: 8:33 PM
 */

return [
    'tables' => [
        'object' => [ 'name' => 'biota' ],
        'animation' => [ 'name' => 'biota_properties_anim_part' ],
        'palette' => [ 'name' => 'biota_properties_palette' ],
        'body_part' => [ 'name' => 'biota_properties_body_part' ],
        'properties_attribute' => [
            'name' => 'biota_properties_attribute',
        ],
        'properties_attribute2nd' => [
            'name' => 'biota_properties_attribute_2nd',
        ],
        'properties_bigint' => [
            'name' => 'biota_properties_int64',
        ],
        'properties_bool' => [
            'name' => 'biota_properties_bool',
        ],
        'properties_did' => [
            'name' => 'biota_properties_d_i_d',
        ],
        'properties_double' => [
            'name' => 'biota_properties_double',
        ],
        'properties_iid' => [
            'name' => 'biota_properties_i_i_d',
        ],
        'properties_int' => [
            'name' => 'biota_properties_int',
        ],
        'properties_skill' => [
            'name' => 'biota_properties_skill',
        ],
        'properties_spell' => [
            'name' => 'biota_properties_spell_book',
        ],
        'properties_string' => [
            'name' => 'biota_properties_string',
            'id' => 'type'
        ],
        'texture_map' => [ 'name' => 'biota_texture_map' ],
        'position' => [ 'name' => 'biota_properties_position' ],
        'weenie_class' => [ 'name' => 'ace_weenie_class' ],
    ],
    'properties' => [
        'name' => [
            'table' => 'string',
            'id' => 1,
        ],
        'title' => [
            'table' => 'string',
            'id' => 3,
        ],
        'account-id' => [
            'table' => 'iid',
            'id' => 9001,
        ],
        'delete-date' => [
            'table' => 'bigint',
            'id' => 9001,
        ],
        'is-deleted' => [
            'table' => 'bool',
            'id' => 9001,
        ],
        'total-xp' => [
            'table' => 'int',
            'id' => 21,
        ],
        'total-skill-credits' => [
            'table' => 'int',
            'id' => 23,
        ],
        'spendable-skill-credits' => [
            'table' => 'int',
            'id' => 24,
        ],
        'level' => [
            'table' => 'int',
            'id' => 25,
        ],
        'allegiance-rank' => [
            'table' => 'int',
            'id' => 30,
        ],
        'deaths' => [
            'table' => 'int',
            'id' => 43,
        ],
        'birthdate' => [
            'table' => 'int',
            'id' => 98,
        ],
        'gender' => [
            'table' => 'int',
            'id' => 113,
            'options' => [
                1 => 'Male',
                2 => 'Female',
            ],
        ],
        'age' => [
            'table' => 'int',
            'id' => 125,
        ],
        'vitae' => [
            'table' => 'int',
            'id' => 129,
        ],
        'pk-status' => [
            'table' => 'int',
            'id' => 134,
        ],
        'race' => [
            'table' => 'int',
            'id' => 188,
            'options' => [
                1 => 'Aluvian',
                2 => 'Gharu\'ndim',
                3 => 'Sho',
                4 => 'Viamontian',
                5 => 'Umbraen',
                6 => 'Gear Knight',
                7 => 'Aun Tumerok',
                8 => 'Lugian',
                9 => 'Empyrean',
                10 => 'Penumbraen',
                11 => 'Undead',
                12 => 'Olthoi Soldier',
                13 => 'Olthoi Spitter',
            ],
        ],
        'house-purchase-date' => [
            'table' => 'int',
            'id' => 199,
        ],
        'pk-kills' => [
            'table' => 'int',
            'id' => 208,
        ],
        'pkl-kills' => [
            'table' => 'int',
            'id' => 209,
        ],
    ]
];
