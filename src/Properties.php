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
use Seotils\Properties\Intefaces\IGetterSetterValidator;
use Seotils\Properties\Intefaces\IProperties;
use Seotils\Properties\Intefaces\IProperty;
use Seotils\Properties\Property;
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
class Properties implements IProperties {

  use HasParent;

  /**
   * Properties getter instance
   *
   * @var Seotils\Intefaces\IGetterSetterValidator
   */
  protected $instGetter;

  /**
   * Properties setter instance
   *
   * @var Seotils\Intefaces\IGetterSetterValidator
   */
  protected $instSetter;

  /**
   * Properties validator instance
   *
   * @var Seotils\Intefaces\IGetterSetterValidator
   */
  protected $instValidator;

  /**
   * Properties configuration
   *
   * @var array Array with a properties configuration
   */
  protected $propConfig;

  /**
   * Current sequence
   *
   * @var array;
   */
  protected $propSequence;

  /**
   * Properties values
   *
   * @var array Array of Seotils\Intefaces\IntefaceProperty classes
   */
  protected $propValues;


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
  public function __construct( $parentClass, $config = [] ) {
    $this->parentClass( $parentClass );
    $this->instGetter = new Getter( $this );
    $this->instSetter = new Setter( $this );
    $this->instValidator = new Validator( $this );
    if( ! empty( $config ) && is_array( $config ))
    {
      $this->applyConfig( $config );
    }
  }

  public function applyConfig( $config ) {
    if(  ! is_array( $config )
      || ! isset( $config ['properties'])
      || ! is_array( $config ['properties'])
    ) {
      $this->exception( 'Invalid configuration.' );
    } else {
      $this->propConfig = $config;
      $this->propValues = [];
      foreach( $this->propConfig ['properties'] as $propertyName => $propertyParams ) {
        $this->propValues [ $propertyName ] =
            Property::factory( $propertyName, $this, $propertyParams);
        $this->propConfig ['properties'] [$propertyName] =
            $this->propValues [$propertyName] ->getConfig();
      }
    }
  }

  /**
   * Returns a properties in the current sequence
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
   * @return \Seotils\Intefaces\IProperty
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
   * Sets a properties in the current sequence
   *
   * @param boolean $strict Use strict mode
   * @return void
   */
  public function set( $strict = true ) {
    $this->instSetter->strictMode( $strict )->applySequence();
    $this->releaseSequence();
  }

  /**
   * Set property object by name
   *
   * @param string $name Property name
   * @param \Seotils\Intefaces\IProperty $property Property object
   * @param boolean $strict Use strict mode
   *
   * @return \Seotils\Properties\Properties
   */
  public function setProperty( $name, $property, $strict = true ) {
    $this->useExceptions( $strict );
    $this->propValues [$name] = $property;
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
   * @param Seotils\Intefaces\IGetterSetterValidator $getter
   * @return void
   */
  public function setGetter( IGetterSetterValidator $getter ) {
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
   * @param Seotils\Intefaces\IGetterSetterValidator $setter
   * @return void
   */
  public function setSetter( IGetterSetterValidator $setter ) {
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
   * @param Seotils\Intefaces\IGetterSetterValidator $validator
   * @return void
   */
  public function setValidator( IGetterSetterValidator $validator ) {
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
