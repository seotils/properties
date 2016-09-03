<?php
/*
 * GetterSetterValidator base class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Intefaces\IntefaceGetterSetterValidator;
use Seotils\Properties\Properties as PropertiesClass;
use Seotils\Traits\HasParent;

/**
 * Abstract base class for a getter/setter/validator classes
 */
abstract class GetterSetterValidator implements IntefaceGetterSetterValidator {

  use HasParent {
    HasParent::parentClass as private overridedSetParentClass;
  }

  /**
   * Use strict mode
   *
   * @var boolean
   */
  protected $strict = true;

  /**
   * Constructor
   *
   * @param PropertiesClass $parenClass
   */
  public function __construct( PropertiesClass $parenClass = null) {
    if( $parenClass ){
      $this->parentClass( $parenClass );
    }
  }

  /**
   * Overrides Seotils\Traits\HasParent::parentClass() as typed
   *
   * @param PropertiesClass $parenClass
   */
  public function parentClass( PropertiesClass $parenClass) {
    $this->overridedSetParentClass( $parenClass );
  }

  /**
   * Set/Unset the strict mode
   *
   * @param boolean $strict
   * @return \Seotils\Properties\GetterSetterValidator
   */
  public function strictMode( $strict )
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
    return $this->strictMode;
  }

  /**
   * Process the current properties sequence
   */
  abstract public function applySequence();

}