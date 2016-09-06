<?php
/*
 * BaseType class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties\Types;

use Seotils\Traits\HasParent;
use Seotils\Properties\Intefaces\IProperty;

/**
 * Base class for a typed-property classes
 */
abstract class BaseType implements IProperty {

  use HasParent;

  public function __construct( $parentClass ) {
    $this->parentClass( $parentClass );
  }

  /**
   * Property value
   *
   * @var mixed
   */
  protected $value;

  /**
   * Get the property value.
   * @param mixed $arguments [optional]
   * @return mixed
   */
  public function get() {
    return $this->value;
  }

  /**
   * Set the property value.
   *
   * @return void
   */
  public function set( $value ){
    $this->value = $value;
  }

}
