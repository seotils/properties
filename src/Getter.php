<?php
/*
 * Properties getter
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
class GetterException extends \Exception {};

/**
 * Gets the class properties
 */
class Getter extends GetterSetterValidator {

  /**
   * Gets properties from current sequence
   */
  public function applySequence() {
    $result = [];
    $strict = $this->isStrictMode();
    /* @var $properties \Seotils\Properties\Properties */
    $properties = $this->parentClass();
    $properties->useExceptions( $strict );
    $errors = $errorsAfter = $properties->exceptionsCount();
    $sequence = $properties->getSequence();
    foreach( $sequence as $prop){
      $result [ $prop ['name']] = $properties->getProperty( $prop ['name']);
      if( ! $strict && $errors < $errorsAfter = $properties->exceptionsCount()) {
        unset( $result [ $prop ['name']]);
        $errors = $errorsAfter;
      }
    }
    return $result;
  }

}