<?php
/**
 * Created by PhpStorm.
 * User: lisa
 * Date: 6/1/17
 * Time: 8:33 PM
 */

return [
    'tables' => [
        'object' => [
            'name' => 'ace_object',
            'array' => 'object',
        ],
        'properties_attribute' => [
            'name' => 'ace_object_properties_attribute',
            'array' => 'attribute',
            'id' => 'attributeId'
        ],
        'properties_attribute2nd' => [
            'name' => 'ace_object_properties_attribute2nd',
            'array' => 'attribute2nd',
            'id' => 'attribute2ndId'
        ],
        'properties_bigint' => [
            'name' => 'ace_object_properties_bigint',
            'id' => 'bigIntPropertyId'
        ],
        'properties_bool' => [
            'name' => 'ace_object_properties_bool',
            'id' => 'boolPropertyId'
        ],
        'properties_did' => [
            'name' => 'ace_object_properties_did',
            'id' => 'didPropertyId'
        ],
        'properties_double' => [
            'name' => 'ace_object_properties_double',
            'id' => 'dblPropertyId'
        ],
        'properties_iid' => [
            'name' => 'ace_object_properties_iid',
            'id' => 'iidPropertyId'
        ],
        'properties_int' => [
            'name' => 'ace_object_properties_int',
            'id' => 'intPropertyId'
        ],
        'properties_skill' => [
            'name' => 'ace_object_properties_skill',
            'array' => 'skills',
        ],
        'properties_spell' => [
            'name' => 'ace_object_properties_spell',
            'array' => 'spells',
        ],
        'properties_string' => [
            'name' => 'ace_object_properties_string',
            'id' => 'strPropertyId'
        ],
//        'texture_map' => [ 'name' => 'ace_object_texture_map_change' ],
        'position' => [ 'name' => 'ace_position' ],
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
