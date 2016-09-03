<?php
/*
 * Properties validator
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
class ValidatorException extends \Exception {};

/**
 * Validate the class properties
 */
class Validator extends GetterSetterValidator{

  public function applySequence(){
    $sequence = $this->parentClass()->getSequence();
    foreach( $sequence as $prop){

    }
  }

}