<?php
/*
 * Properties class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Intefaces\IntefaceGetterSetterValidator;
use Seotils\Traits\HasParent;
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
    return $this->instGetter->strictMode( $strict )->applySequence();
  }

  /**
   * Set the properties
   *
   * @param boolean $strict Use strict mode
   * @return type
   */
  public function set( $strict = true ) {
    return $this->instSetter->strictMode( $strict )->applySequence();
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
