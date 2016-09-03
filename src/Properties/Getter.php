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

  public function applySequence(){
    $sequence = $this->parentClass()->getSequence();
    foreach( $sequence as $prop){

    }
  }

}