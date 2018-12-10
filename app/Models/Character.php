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
    protected $table = 'character';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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

        $tableName = config( 'character.tables.properties_' . $table . '.name', 'biota_properties_' . $table );
        $field = config( 'character.tables.properties_' . $table . '.id', 'type' );

        $properties = DB::connection( $this->connection )
            ->table( $tableName )
            ->where( 'object_id', $this->getAttribute( 'id' ) )
            ->get();
        foreach ( $properties as $property ) {
            array_set( $this->{$table . 'Properties'}, $property->{$field}, $property->value );
            if ( $table == 'bool' ) {
                array_set( $this->{$table . 'Properties'}, $property->{$field}, filter_var( $property->value, FILTER_VALIDATE_BOOLEAN ) );
            }
        }

        return $this->{$table . 'Properties'};
    }

    /**
     * @param string $name
     * @param string $default
     *
     * @return string|Carbon|\DateInterval
     */
    public function property( $name, $default = '' )
    {
        $prop = config( 'character.properties.' . $name, [] );

        if ( empty( $prop ) ) {
            return $default;
        }

        try {
            $property = $this->getProperty( $prop[ 'id' ], $prop[ 'table' ] );
            if ( empty( $property ) ) {
                $property = $default;
            }

            //Because apparently Carbon can't parse a timestamp without help
            if ( ( $name == 'birthdate' || $name == 'delete-date' ) ) {
                if ( $property == 0 ) {
                    return $default;
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
                return array_get( $prop[ 'options' ], $property, $default );
            }

            return $property;
        }
        catch ( Exception $e ) {
            logger( $e->getMessage(), [ 'error' ] );

            return $default;
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
        $table = config( 'character.tables.properties_' . array_get( $prop, 'table' ) );
        $field = array_get( $table, 'id', 'type' );

        return DB::connection( $this->connection )
            ->table( array_get( $table, 'name', '' ) )
            ->where( 'object_id', $this->getAttribute( 'id' ) )
            ->where( $field, array_get( $prop, 'id' ) )
            ->update( [ 'value' => $value ] );
    }
}
