<?php
/*
 * GetterSetterValidator base class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Properties\Intefaces\IGetterSetterValidator;
use Seotils\Properties\Intefaces\IProperties;
use Seotils\Traits\HasParent;

/**
 * Abstract base class for a getter/setter/validator classes
 */
abstract class GetterSetterValidator implements IGetterSetterValidator {

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
   * @param \Seotils\Properties\Intefaces\IProperties $parenClass
   */
  public function __construct( IProperties $parenClass = null) {
    if( $parenClass ){
      $this->parentClass( $parenClass );
    }
  }

  /**
   * Overrides Seotils\Traits\HasParent::parentClass() as typed
   *
   * @param \Seotils\Properties\Intefaces\IProperties $parenClass
   */
  public function parentClass( IProperties $parenClass = null ) {
    $result = null;
    if( $parenClass ) {
      $result = $this->overridedSetParentClass( $parenClass );
    } else {
      $result = $this->overridedSetParentClass();
    }
    return $result;
  }

  /**
   * Set/Unset the strict mode
   *
   * @param boolean $strict
   * @return \Seotils\Properties\Intefaces\IGetterSetterValidator
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
   * Process the property by name
   */
  abstract public function apply();

  /**
   * Process the current properties sequence
   */
  abstract public function applySequence();

}