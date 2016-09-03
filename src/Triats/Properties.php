<?php
/**
 * Properties trait
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html GPL-3.0
 * @author deMagog <seotils@gmail.com>
 *
 */

namespace Seotils\Traits;

use Seotils\Properties\Properties as PropertiesClass;

/**
 * Incapsulate properties into the class
 */
trait Properties {

  /**
   * Properties
   *
   * @var Seotils\Properties\Properties
   */
  protected $propertiesClass;

  /**
   * Returns the properties class
   *
   * @param boolean $continueSequence Continue current properties sequence
   * @return Seotils\Properties\Properties
   */
  public function properties(){
    if( ! $this->propertiesClass){
      $this->propertiesClass = new PropertiesClass( $this );
    }
    return $this->propertiesClass;
  }

  /**
   * Sets and returns a custom properties class
   *
   * @param PropertiesClass $properties
   * @return Seotils\Properties\Properties
   */
  public function setProperties( PropertiesClass $properties ){
    if( $properties ){
      $this->propertiesClass = $properties;
      $this->propertiesClass->parentClass( $this );
    }
    return $this->properties();
  }

}