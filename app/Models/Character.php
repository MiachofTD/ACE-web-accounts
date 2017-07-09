<?php

namespace Ace\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
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
    protected $table = 'vw_ace_character';

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

        $prefix = $table . 'Property';
        if ( $table == 'string' ) {
            $prefix = 'strProperty';
        }
        elseif ( $table == 'bigint' ) {
            $prefix = 'bigIntProperty';
        }
        elseif ( $table == 'double' ) {
            $prefix = 'dblProperty';
        }
        elseif ( $table == 'skill' || $table == 'spell' ) {
            $prefix = $table;
        }

        $properties = DB::connection( $this->connection )->table( 'ace_object_properties_' . $table )->where( 'aceObjectId', $this->getAttribute( 'guid' ) )->get();
        foreach ( $properties as $property ) {
            $this->{$table . 'Properties'}[ $property->{$prefix . 'Id' } ] = $property->propertyValue;
        }

        return $this->{$table . 'Properties'};
    }

    /**
     * @param string $name
     *
     * @return string|Carbon|\DateInterval
     */
    public function property( $name )
    {
        $prop = config( 'character.' . $name, [] );

        if ( empty( $prop ) ) {
            return '';
        }

        $property = $this->getProperty( $prop[ 'id' ], $prop[ 'table' ] );

        //Because apparently Carbon can't parse a timestamp without help
        if ( $name == 'birthdate' ) {
            return Carbon::createFromFormat( 'U', $property )->timezone( 'America/Chicago' );
        }
        else if ( $name == 'age' ) {
            $birthdate = $this->property( 'birthdate' );
            $age = $birthdate->copy()->addseconds( $property );

            return $birthdate->diff( $age );
        }
        else if ( strpos( $name, 'date' ) !== false ) {
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
