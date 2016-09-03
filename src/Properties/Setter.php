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

  public function applySequence(){
    $sequence = $this->parentClass()->getSequence();
    foreach( $sequence as $prop){

    }
  }

}