<?php
/*
 * IntefaceGetterSetterValidator inteface
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Intefaces;

/**
 * Inteface for a getter/setter/validator classes
 */
interface IntefaceGetterSetterValidator {

  /**
   * Set/Unset the strict mode. It must return an instance of the class.
   */
  public function strictMode( $strict );

  /**
   * Returns status of the "strict mode"
   */
  public function isStrictMode();

  /**
   * Process the current properties sequence
   */
  public function applySequence();

}
