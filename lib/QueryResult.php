<?php

namespace Palasthotel\Grid\Drupal;

/**
 * A query result with the part of mysqli_result the grid library uses.
 */
class QueryResult {

  public function __construct(private \PDOStatement $statement) {
  }

  /**
   * @return array|null the next row, NULL when there is none
   */
  public function fetch_assoc() {
    $row = $this->statement->fetch(\PDO::FETCH_ASSOC);
    return $row === FALSE ? NULL : $row;
  }

  /**
   * @return object|null the next row, NULL when there is none
   */
  public function fetch_object() {
    $row = $this->statement->fetch(\PDO::FETCH_OBJ);
    return $row === FALSE ? NULL : $row;
  }

}
