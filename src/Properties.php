<?php
/*
 * Properties class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Traits\HasParent;
use Seotils\Properties\Intefaces\IntefaceGetterSetterValidator;
use Seotils\Properties\Getter;
use Seotils\Properties\Setter;
use Seotils\Properties\Validator;

/**
 * Exception class
 */
class PropertiesException extends \Exception {};

/**
 * Allows you set, get and validate properties of a parent class.
 *
 */
class Properties {

  use HasParent;

  // Types of properties

  /**
   * Regular property type
   *
   * @var int
   */
  const PROPERTY_TYPE_REGULAR  = 1;

  /**
   * Array property type
   *
   * @var int
   */
  const PROPERTY_TYPE_ARRAY    = 2;

  /**
   * Class property type
   *
   * @var int
   */
  const PROPERTY_TYPE_CALLBACK = 3;

  /**
   * Class property type
   *
   * @var int
   */
  const PROPERTY_TYPE_CLASS    = 4;

  /**
   * Resource property type
   *
   * @var int
   */
  const PROPERTY_TYPE_RESOURCE = 4;

  // Types of values

  /**
   * Boolean value type
   *
   * @var int
   */
  const VALUE_TYPE_BOOLEAN  = 1;

  /**
   * Integer value type
   *
   * @var int
   */
  const VALUE_TYPE_INTEGER  = 2;

  /**
   * Double value type
   *
   * @var int
   */
  const VALUE_TYPE_DOUBLE   = 3;

  /**
   * String value type
   *
   * @var int
   */
  const VALUE_TYPE_STRING   = 4;

  /**
   * Array value type
   *
   * @var int
   */
  const VALUE_TYPE_ARRAY    = 5;

  /**
   * Resource value type
   *
   * @var int
   */
  const VALUE_TYPE_RESOURCE = 6;

  /**
   * Callback value type
   *
   * @var int
   */
  const VALUE_TYPE_CALLBACK = 7;

  /**
   * Class value type
   *
   * @var int
   */
  const VALUE_TYPE_CLASS    = 8;


  /**
   * Properties getter instance
   *
   * @var Seotils\Intefaces\IntefaceGetterSetterValidator
   */
  protected $instGetter;

  /**
   * Properties setter instance
   *
   * @var Seotils\Intefaces\IntefaceGetterSetterValidator
   */
  protected $instSetter;

  /**
   * Properties validator instance
   *
   * @var Seotils\Intefaces\IntefaceGetterSetterValidator
   */
  protected $instValidator;

  /**
   * Properties values
   *
   * @var array
   */
  protected $propValues;

  /**
   * Current sequence
   *
   * @var array;
   */
  protected $propSequence;

  /**
   * Use strict mode
   *
   * @var boolean
   */
  protected $strict = true;

  /**
   * "Magic" method
   *
   * @param type $name
   * @param type $arguments
   * @return \Seotils\Properties\Properties
   */
  public function __call( $name, $arguments) {
    $this->addToSequence( $name, $arguments );
    return $this;
  }

  /**
   * Constructor
   *
   * @param type $parentClass Parent class
   */
  public function __construct( $parentClass ) {
    $this->parentClass( $parentClass );
    $this->instGetter = new Getter( $this );
    $this->instSetter = new Setter( $this );
    $this->instValidator = new Validator( $this );
  }

  /**
   * Returns the properties
   *
   * @param boolean $strict Use strict mode
   * @return type
   */
  public function get( $strict = true ) {
    $result = $this->instGetter->strictMode( $strict )->applySequence();
    $this->releaseSequence();
    return $result;
  }

  /**
   * Get property by name
   *
   * @param string $name Property name
   * @param boolean $strict Use strict mode
   *
   * @return \Seotils\Properties\Properties
   */
  public function getProperty( $name, $strict = true ) {
    $result = null;
    if( isset( $this->propValues [$name] )) {
      $result = $this->propValues [$name];
    } else {
      $this->exception("Property `{$name}` does not exists.");
    }
    return $result;
  }

  /**
   * Set the properties
   *
   * @param boolean $strict Use strict mode
   * @return void
   */
  public function set( $strict = true ) {
    $this->instSetter->strictMode( $strict )->applySequence();
    $this->releaseSequence();
  }

  /**
   * Set property by name
   *
   * @param string $name Property name
   * @param mixed $value Property value
   * @param boolean $strict Use strict mode
   *
   * @return \Seotils\Properties\Properties
   */
  public function setProperty( $name, $value, $strict = true ) {
    $this->useExceptions( $strict );
    $this->propValues [$name] = $value;
    return $this;
  }

  /**
   * Set/Unset the strict mode
   *
   * @param boolean $strict
   * @return \Seotils\Properties\GetterSetterValidator
   */
  public function strictMode( $strict = true )
  {
    $this->strict = (bool) $strict;
    return $this;
  }

  /**
   * Class in a strict mode
   *
   * @return boolean
   */
  public function isStrictMode()
  {
    return $this->strict;
  }


  /**
   * Validate the properties
   *
   * @param boolean $strict Use strict mode
   * @return boolean
   */
  public function validate( $strict = true ) {
    return $this->instValidator->strictMode( $strict )->applySequence();
  }

  /**
   * Sets a custom getter
   *
   * @param Seotils\Intefaces\IntefaceGetterSetterValidator $getter
   * @return void
   */
  public function setGetter( IntefaceGetterSetterValidator $getter ) {
    if( $getter ){
      $this->instGetter = $getter;
      $this->instGetter->parentClass( $this );
    } else {
      $this->exception('Invalid instance of a getter class.');
    }
  }

  /**
   * Sets a custom setter
   *
   * @param Seotils\Intefaces\IntefaceGetterSetterValidator $setter
   * @return void
   */
  public function setSetter( IntefaceGetterSetterValidator $setter ) {
    if( $setter ){
      $this->instSetter = $setter;
      $this->instSetter->parentClass( $this );
    } else {
      $this->exception('Invalid instance of a setter class.');
    }
  }

  /**
   * Sets a custom validator
   *
   * @param Seotils\Intefaces\IntefaceGetterSetterValidator $validator
   * @return void
   */
  public function setValidator( IntefaceGetterSetterValidator $validator ) {
    if( $validator ){
      $this->instValidator = $validator;
      $this->instValidator->parentClass( $this );
    } else {
      $this->exception('Invalid instance of a validator class.');
    }
  }

  /**
   * Add an item to a current sequence
   *
   * @param string $name Property name
   * @param array $arguments Property arguments
   * @return void
   */
  protected function addToSequence( $name, $arguments ){
    $this->propSequence [] = [
      'name' => $name,
      'arguments' => $arguments,
    ];
  }

  /**
   * Returns a current sequence
   *
   * @return array Array in a [ 'name' => property name, 'arguments' => property arguments] format
   */
  public function getSequence(){
    return $this->propSequence;
  }

  /**
   * Release a current sequence
   *
   * @return \Seotils\Properties\Properties
   */
  public function releaseSequence(){
    $this->propSequence = [];
    return $this;
  }

}
