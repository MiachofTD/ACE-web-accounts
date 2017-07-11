<?php

namespace Ace\Models;

use Exception;
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
    protected $bigintProperties = [];

    /**
     * @var array
     */
    protected $boolProperties = [];

    /**
     * @var array
     */
    protected $intProperties = [];

    /**
     * @var array
     */
    protected $stringProperties = [];

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

        $field = config( 'character.tables.properties_' . $table . '.id', '' );

        if ( empty( $field ) ) {
            $field = $table . 'Id';
        }

        $properties = DB::connection( $this->connection )
            ->table( 'ace_object_properties_' . $table )
            ->where( 'aceObjectId', $this->getAttribute( 'guid' ) )
            ->get();
        foreach ( $properties as $property ) {
            array_set( $this->{$table . 'Properties'}, $property->{$field}, $property->propertyValue );
            if ( $table == 'bool' ) {
                array_set( $this->{$table . 'Properties'}, $property->{$field}, filter_var( $property->propertyValue, FILTER_VALIDATE_BOOLEAN ) );
            }
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
        $prop = config( 'character.properties.' . $name, [] );

        if ( empty( $prop ) ) {
            return '';
        }

        try {
            $property = $this->getProperty( $prop[ 'id' ], $prop[ 'table' ] );

            //Because apparently Carbon can't parse a timestamp without help
            if ( ( $name == 'birthdate' || $name == 'delete-date' ) ) {
                if ( $property == 0 ) {
                    return '';
                }

                return Carbon::createFromTimestamp( $property );
            }
            else if ( $name == 'age' ) {
                $birthdate = $this->property( 'birthdate' );

                if ( $birthdate instanceof Carbon ) {
                    $age = $birthdate->copy()->addseconds( $property );

                    return $birthdate->diff( $age );
                }

                return 0;
            }
            else if ( strpos( $name, 'date' ) !== false ) {
                return Carbon::parse( $property );
            }
            else if ( array_has( $prop, 'options' ) ) {
                return array_get( $prop[ 'options' ], $property, '' );
            }

            return $property;
        }
        catch ( Exception $e ) {
            return '';
        }
    }

    /**
     * @param        $id
     * @param string $table
     *
     * @return mixed
     */
    public function getProperty( $id, $table = 'string' )
    {
        //Make sure the properties array actually exists before trying to do anything to it
        if ( !isset( $this->{$table . 'Properties'} ) ) {
            $this->{$table . 'Properties'} = [];
        }

        $this->getProperties( $table );

        return array_get( $this->{$table . 'Properties'}, $id, '' );
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return bool
     */
    public function updateProperty( $name, $value )
    {
        $prop = config( 'character.properties.' . $name, [] );

        if ( !array_has( $prop, 'table' ) ) {
            return false;
        }

        $field = config( 'character.tables.properties_' . array_get( $prop, 'table' ) . '.id', '' );

        return DB::connection( $this->connection )
            ->table( 'ace_object_properties_' . array_get( $prop, 'table' ) )
            ->where( 'aceObjectId', $this->getAttribute( 'guid' ) )
            ->where( $field, array_get( $prop, 'id' ) )
            ->update( [ 'propertyValue' => $value ] );
    }
}
