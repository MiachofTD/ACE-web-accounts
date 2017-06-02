<?php

namespace Ace\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'email', 'password', 'salt', 'accesslevel',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'salt',
    ];

    /**
     * @var int|string
     */
    protected $accessLevel;

    /**
     * @var array
     */
    protected $accessLevels = [
        0 => [
            'name' => 'Player',
            'prefix' => '',
        ],
        1 => [
            'name' => 'Advocate',
            'prefix' => '',
        ],
        2 => [
            'name' => 'Sentinel',
            'prefix' => 'Sentinel',
        ],
        3 => [
            'name' => 'Envoy',
            'prefix' => 'Envoy',
        ],
        4 => [
            'name' => 'Developer',
            'prefix' => '',
        ],
        5 => [
            'name' => 'Admin',
            'prefix' => 'Admin',
        ],
    ];

    /**
     * User constructor.
     *
     * @param array $attributes
     */
    public function __construct( array $attributes = [] )
    {
        parent::__construct( $attributes );

        $this->accessLevel = array_get( $this->accessLevels, $this->accessLevel, 'Player' );
    }
}
