<?php

namespace Ace\Models;

use Illuminate\Support\Facades\Hash;
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
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'accountId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accountName', 'passwordHash', 'passwordSalt', 'accesslevel',
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
        'passwordHash', 'passwordSalt',
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

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getAttribute( 'passwordHash' );
    }

    /**
     * Update the model in the database.
     *
     * @param  array $parameters
     * @param  array $options
     *
     * @return bool|int
     */
    public function update( array $parameters = [], array $options = [] )
    {
        $attributes = array_except( $parameters, [ 'passwordHash' ] );

        $password = array_get( $parameters, 'passwordHash', '' );
        if ( !empty( $password ) ) {
            $attributes[ 'passwordHash' ] = Hash::make( $password, [ 'salt' => $this->getAttribute( 'passwordSalt' ) ] );
        }

        return parent::update( $attributes, $options );
    }
}
