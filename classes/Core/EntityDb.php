<?php
/**
 * Created by Gorlum 08.01.2018 14:46
 */

namespace Core;


use \DBAL\DbQuery;
use \DBAL\ActiveRecord;
use Common\Traits\TContainer;

/**
 * Class EntityDb
 *
 * Represents in-game entity which have representation in DB (aka one or more connected ActiveRecords)
 *
 * @package Core
 *
 * @method array asArray() Extracts values as array [$propertyName => $propertyValue] (from ActiveRecord)
 * @method bool update() Updates DB record(s) in DB (from ActiveRecord)
 */
class EntityDb extends Entity implements \Common\Interfaces\IContainer {
  use TContainer;

  /**
   * @var string $_activeClass
   */
  protected $_activeClass = ''; // \\DBAL\\ActiveRecord

  /**
   * @var ActiveRecord $_container
   */
  protected $_container;

  /**
   * @return ActiveRecord
   */
  public function _getContainer() {
    return $this->_container;
  }

  /**
   * EntityDb constructor.
   *
   * @param int $id
   */
  public function __construct($id = 0) {
    $this->dbLoadRecord($id);
  }

  /**
   * Set flag "for update"
   *
   * @param bool $forUpdate - DbQuery::DB_FOR_UPDATE | DbQuery::DB_SHARED
   */
  public function setForUpdate($forUpdate = DbQuery::DB_FOR_UPDATE) {
    $className = $this->_activeClass;
    $className::setForUpdate($forUpdate);

    return $this;
  }

  /**
   * @param int|float $id
   *
   * @return ActiveRecord
   */
  public function dbLoadRecord($id) {
    $className = $this->_activeClass;
    $this->_container = $className::findById($id);

    return $this->_container;
  }

  /**
   *
   */
  public function dbUpdate() {
    $this->_getContainer()->update();
  }

}
