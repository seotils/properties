<?php
/*
 * Property class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Properties;

use Seotils\Traits\DeferredExceptions;
use Seotils\Traits\HasParent;

use Seotils\Properties\Intefaces\IProperties;
use Seotils\Properties\Intefaces\IUnifiedProperty;

use Seotils\Properties\Types;

/**
 * Exception class
 */
class PropertyException extends \Exception {}

/**
 * Universal property class with incupsulated type
 */
class Property implements IUnifiedProperty {

  use HasParent;

  /**
   * A property configuration
   *
   * @var array
   */
  protected $config;

  /**
   * Name of a property
   *
   * @var string
   */
  protected $name;

  /**
   * Use strict mode
   *
   * @var boolean
   */
  protected $strict = true;

  /**
   * Incupsulated typed property
   *
   * @var \Seotils\Properties\Intefaces\IProperty
   */
  protected $typedProperty;

  /**
   * Constructor
   *
   * @param string $name Property name
   * @param mixed $parentClass Property owner
   * @param array $params Property definition array
   */
  public function __construct( $name, $parentClass, $params = []) {
    if( empty( $name ) || ! is_string( $name )) {
      $this->exception("Property name must be a string and not empty.");
    } else {
      $this->name = $name;
      $this->setParent( $parentClass );
      if( ! empty( $params )){
        $this->applyConfig( $params );
      }
    }
  }

  /**
   * Adjusts property according to a configuration array.
   *
   * @param array $params Property configuration
   *
   * @return boolean
   */
  public function applyConfig( $params ) {
    $result = true;
    if( empty( $params ) || ! is_array( $params)) {
      $this->exception("Invalid property configuration.");
      $result = false;
    } else {
      $this->config = $params;
      if( ! isset( $this->config ['propertyType'])) {
        $this->config ['propertyType'] = IProperties::PROPERTY_TYPE_ANY;
      }
      switch( $this->config ['propertyType'] ) {

        case IProperties::PROPERTY_TYPE_ANY:
            $this->typedProperty = new Types\AnyProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_ARRAY:
            $this->typedProperty = new Types\ArrayProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_BOOLEAN:
            $this->typedProperty = new Types\BooleanProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_CALLBACK:
            $this->typedProperty = new Types\CallbackProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_CLASS:
            $this->typedProperty = new Types\ClassProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_CUSTOM:
            $this->typedProperty = new Types\CustomProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_DOUBLE:
            $this->typedProperty = new Types\DoubleProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_INTEGER:
            $this->typedProperty = new Types\IntegerProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_RESOURCE:
            $this->typedProperty = new Types\ResourceProperty( $this );
            break;
        case IProperties::PROPERTY_TYPE_STRING:
            $this->typedProperty = new Types\StringProperty( $this );
            break;
        default:
          $this->exception("Undefined property type `{$this->config ['valueType']}`.");
          $result = false;
      }
    }
    return $result;
  }

  /**
   * Returns property configuration array.
   *
   * @return array
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * Property factory.
   *
   * @param string $name Name of property
   * @param array $params Property configuration
   * @return Seotils\Properties\Intefaces\IProperty
   */
  public static function factory( $name, $parentClass, $params = []) {
    return new Property( $name, $parentClass, $params );
  }

  /**
   * Get the property value.
   * @param mixed $arguments [optional]
   * @return mixed
   */
  public function get() {
    $result = null;
    if( $this->typedProperty ) {
      $result = call_user_func_array( [ $this->typedProperty, 'get'], func_get_args());
    } else {
      $this->exception("Typed property does not assigned.");
    }
    return $result;
  }

  /**
   * Set the property value
   * @param boolean $strictMode Strict mode On/Off
   * @param mixed $value New property value
   * @param mixed $arguments [optional] Extra params
   * @return mixed
   */
  public function set( $strictMode, $value, $arguments = null) {
    $result = null;
    if( func_num_args() < 2 ){
      $this->exception('Invalid setter call.');
    } else {
      $arguments = func_get_args();
      $strictMode = array_shift( $arguments );
      if( ! is_bool( $strictMode )) {
        $this->exeption('Invalid strict mode value.');
      } else {
        if( $this->typedProperty ) {
          $this->typedProperty->strictMode( $strictMode );
          $result = call_user_func_array( [ $this->typedProperty, 'set'], $arguments);
        } else {
          $this->exception('Typed property does not assigned.');
        }
      }
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

  public function useExceptions( $useExceptions = 'undefined') {
    $result = parent::useExceptions( $useExceptions );
    if( $this->typedProperty ) {
      $this->typedProperty->useExceptions( $result );
    }
    return $result;
  }
}
