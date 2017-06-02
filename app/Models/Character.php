<?php

namespace Ace\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_character';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'character';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $stringProperties = [];

    /**
     * @var array
     */
    protected $intProperties = [];

    /**
     * Character constructor.
     *
     * @param array $attributes
     */
    public function __construct( array $attributes = [] )
    {
        parent::__construct( $attributes );
    }

    /**
     * @param string $table
     *
     * @return mixed
     */
    public function getProperties( $table = 'string' )
    {
        if ( !empty( $this->{$table . 'Properties'} ) ) {
            return $this->{$table . 'Properties'};
        }

        $properties = DB::connection( $this->connection )->table( 'character_properties_' . $table )->where( 'guid', $this->getAttribute( 'guid' ) )->get();
        foreach ( $properties as $property ) {
            $this->{$table . 'Properties'}[ $property->propertyId ] = $property->propertyValue;
        }

        return $this->{$table . 'Properties'};
    }

    /**
     * @param string $name
     *
     * @return string|Carbon
     */
    public function property( $name )
    {
        $prop = config( 'character.' . $name, [] );

        if ( empty( $prop ) ) {
            return '';
        }

        $property = $this->getProperty( $prop[ 'id' ], $prop[ 'table' ] );

        if ( strpos( $name, 'date' ) !== false ) {
            return Carbon::parse( $property );
        }
        else if ( array_has( $prop, 'options' ) ) {
            return array_get( $prop[ 'options' ], $property, '' );
        }

        return $property;
    }

    /**
     * @param        $id
     * @param string $table
     *
     * @return mixed
     */
    public function getProperty( $id, $table = 'string' )
    {
        $this->getProperties( $table );

        return array_get( $this->{$table . 'Properties'}, $id, '' );
    }
}
