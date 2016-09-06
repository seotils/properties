<?php
/*
 * IProperty inteface
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties\Intefaces;

use Seotils\Intefaces\IHasParent;

/**
 * Inteface for a property classes
 */
interface IProperty extends IHasParent {

  /**
   * Get the property value.
   * Use func_get_args() for access to a function arguments.
   */
  public function get();

  /**
   * Set the property value.
   * Use func_get_args() for access to a function arguments.
   */
  public function set();

}
