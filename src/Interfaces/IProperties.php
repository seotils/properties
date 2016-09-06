<?php
/*
 * IProperties inteface
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties\Intefaces;

/**
 * Inteface for a property classes
 */
interface IProperties {

  /**
   * Property of any type
   *
   * @var int
   */
  const PROPERTY_TYPE_ANY      = 1;

  /**
   * Array property type
   *
   * @var int
   */
  const PROPERTY_TYPE_ARRAY    = 2;

  /**
   * Boolean value type
   *
   * @var int
   */
  const PROPERTY_TYPE_BOOLEAN  = 3;

  /**
   * Class property type
   *
   * @var int
   */
  const PROPERTY_TYPE_CALLBACK = 4;

  /**
   * Class property type
   *
   * @var int
   */
  const PROPERTY_TYPE_CLASS    = 5;

  /**
   * Custom property type
   *
   * @var int
   */
  const PROPERTY_TYPE_CUSTOM   = 6;

  /**
   * Double value type
   *
   * @var int
   */
  const PROPERTY_TYPE_DOUBLE   = 7;

  /**
   * Integer value type
   *
   * @var int
   */
  const PROPERTY_TYPE_INTEGER  = 8;

  /**
   * Resource property type
   *
   * @var int
   */
  const PROPERTY_TYPE_RESOURCE = 9;

  /**
   * String value type
   *
   * @var int
   */
  const PROPERTY_TYPE_STRING   = 10;


  /**
   * Maximum reserved numbers for a property-type constatnt
   *
   * @var int
   */
  const PROPERTY_TYPE_RESERVED = 1000;

}
