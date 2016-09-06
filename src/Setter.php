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
   * Sets properties from current sequence
   */
  public function applySequence() {
    $properties = $this->parentClass();
    /* @var $properties \Seotils\Properties\Properties */
    $sequence = $properties->getSequence();
    foreach( $sequence as $prop){
      if( 1 == count( $prop ['arguments'] )){
        $properties->setProperty( $prop ['name'], $prop ['arguments'] [0]);
      }
    }
  }

}