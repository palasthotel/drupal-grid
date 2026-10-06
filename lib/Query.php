<?php

namespace Palasthotel\Grid\Drupal;

use Drupal\Core\Database\Database;
use Palasthotel\Grid\AbstractQuery;

/**
 * Runs the grid library's queries on Drupal's database connection, so they use
 * its charset (utf8mb4), host, port, socket and SSL settings.
 */
class Query extends AbstractQuery {

  /**
   * @return string
   */
  public function prefix() {
    return Database::getConnection()->getPrefix();
  }

  /**
   * The library speaks mysqli: results with fetch_assoc() and fetch_object(),
   * FALSE for a failed query, TRUE for one without a result set.
   *
   * @param string $sql
   *
   * @return QueryResult|bool
   */
  public function execute( $sql ) {
    try {
      $statement = $this->pdo()->query($sql);
    }
    catch (\PDOException $e) {
      \Drupal::logger('grid')->error('Grid query failed: @message', ['@message' => $e->getMessage()]);
      return FALSE;
    }
    if ($statement === FALSE) {
      return FALSE;
    }
    return $statement->columnCount() > 0 ? new QueryResult($statement) : TRUE;
  }

  /**
   * @param string $str
   *
   * @return string
   */
  public function real_escape_string( $str ) {
    // PDO quotes like mysqli_real_escape_string and adds the quotes
    return substr($this->pdo()->quote((string) $str), 1, -1);
  }

  private function pdo(): \PDO {
    return Database::getConnection()->getClientConnection();
  }

}
