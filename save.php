<?php
/**
 * This is an example code that shows how you can save Handsontable data on server using PHP with PDO (SQLite).
 * This code is not intended to be maximally efficient nor safe. It is for demonstrational purposes only.
 * Changes and more examples in different languages are welcome.
 *
 * Copyright 2012, Marcin Warpechowski
 * Licensed under the MIT license.
 * http://github.com/handsontable/handsontable/
 */

require_once('functions.php');

try {
  //open the database
  $db =  getConnection();

  $colMap = array(
    0 => 'id',
    1 => 'name',
    2 => 'mailDomain',
    3 => 'maintenanceRecipient'
  );

  if (isset($_POST['changes']) && $_POST['changes']) {
    foreach ($_POST['changes'] as $change) {
      $rowId  = $change[0] + 1;
      $colId  = $change[1];
      $newVal = $change[3];

      if (!isset($colMap[$colId])) {
        echo "\n spadam";
        continue;
      }

      $select = $db->prepare('SELECT id FROM companies WHERE id=? LIMIT 1');
      $select->execute(array(
        $rowId
      ));

      if ($row = $select->fetch()) {
        $query = $db->prepare('UPDATE companies SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');
      } else {
        $query = $db->prepare('INSERT INTO companies (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
      }
      $query->bindValue(':id', $rowId, PDO::PARAM_INT);
      $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
      $query->execute();
    }
  } elseif (isset($_POST['data']) && $_POST['data']) {
    $select = $db->prepare('DELETE FROM companies');
    $select->execute();

    for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
      $rowId = $r + 1;
      for ($c = 0, $clen = count($_POST['data'][$r]); $c < $clen; $c++) {
        if (!isset($colMap[$c])) {
          continue;
        }

        $newVal = $_POST['data'][$r][$c];

        $select = $db->prepare('SELECT id FROM companies WHERE id=? LIMIT 1');
        $select->execute(array(
          $rowId
        ));

        if ($row = $select->fetch()) {
          $query = $db->prepare('UPDATE companies SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');
        } else {
          $query = $db->prepare('INSERT INTO companies (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');
        }
        $query->bindValue(':id', $rowId, PDO::PARAM_INT);
        $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
        $query->execute();
      }
    }
  }

  $out = array(
    'result' => 'ok',
    'output' => $query
  );
  echo json_encode($out);

  closeConnection($db);
}
catch (PDOException $e) {
  print 'Exception : ' . $e->getMessage();
}
?>
