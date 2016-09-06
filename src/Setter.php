<?php
/*
 * Properties setter
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Properties\GetterSetterValidator;

/**
 * Exception class
 */
class SetterException extends \Exception {};

/**
 * Sets the class properties
 */
class Setter extends GetterSetterValidator {

  /**
   * Sets properties for current sequence
   *
   * @return void
   */
  public function applySequence() {
    sprintf($format);
    $properties = $this->parentClass();
    /* @var $properties \Seotils\Properties\Properties */
    $sequence = $properties->getSequence();
    foreach( $sequence as $prop){
      /* @var $property \Seotils\Properties\Intefaces\IProperty */
      $property = $properties->getProperty( $prop ['name'] );
      if( ! $property ) {
        $this->exeption("Property `{$prop ['name']}` does not exists.");
      } else {
        call_user_func_array( [ $property, 'set'], $prop ['arguments']);
      }
    }
  }

  /**
   * Set property by name
   *
   * @param string $name Property name
   * @param mixed  $arguments [optional] Extra parameters
   * @return mixed
   */
  public function apply() {
    $result = null;
    if( func_num_args() < 2 ){
      $this->exception('Invalid setter call.');
    } else {
      $arguments = func_get_args();
      $name = array_shift( $arguments );
      if( ! is_string( $name ) || empty( $name )) {
        $this->exeption("Invalid property name.");
      } else {
        /* @var $properties \Seotils\Properties\Properties */
        $properties = $this->parentClass();
        /* @var $property \Seotils\Properties\Intefaces\IProperty */
        $property = $properties->getProperty( $name );
        if( ! $property ) {
          $this->exeption("Property `{$name}` does not exists.");
        } else {
          $result = call_user_func_array( [ $property, 'set'], $arguments );
        }
      }
    }
    return $result;
  }

}