<?php
/*
 * IUnifiedProperty inteface
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties\Intefaces;

/**
 * Inteface for a property classes
 */
interface IUnifiedProperty extends IProperty {

  /**
   * Adjusts property according to a configuration array.
   * @param array $params Property configuration
   */
  public function applyConfig( $params );

  /**
   * Property factory
   *
   * @param string $name Name of property
   * @param array $params Property configuration
   * @return Seotils\Properties\Intefaces\IProperty
   */
  public static function factory( $name, $parentClass, $params );

  /**
   * Set/Unset the strict mode. It must return an instance of the class.
   */
  public function strictMode( $strict );

  /**
   * Returns status of the "strict mode"
   */
  public function isStrictMode();

}
