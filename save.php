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


$db =  getConnection();

if($db) {

  if (isset($_GET['lieferant'])) {
    $colMap = array(
      0 => 'name',
      1 => 'mailDomain',
      2 => 'maintenanceRecipient'
    );
  } elseif  (isset($_GET['kunden'])) {
    $colMap = array(
      0 => 'derenCID',
      1 => 'kundenCID',
      2 => 'name'
    );
  } elseif  (isset($_GET['firmen'])) {
    $colMap = array(
      0 => 'name',
      1 => 'derenCID'
    );
  }

  if (isset($_POST['changes']) && $_POST['changes']) {
    foreach ($_POST['changes'] as $change) {
      $rowId  = $change[0] + 1;
      $colId  = $change[1];
      $newVal = $change[3];

      if (!isset($colMap[$colId])) {
        echo "\n spadam";
        continue;
      }

      if (isset($_GET['lieferant'])) {
        $select = $db->prepare('SELECT id FROM lieferantCID WHERE id=? LIMIT 1');
      } elseif  (isset($_GET['kunden'])) {
        $select = $db->prepare('SELECT id FROM kundenCID WHERE id=? LIMIT 1');
      } elseif  (isset($_GET['firmen'])) {
        $select = $db->prepare('SELECT id FROM companies WHERE id=? LIMIT 1');
      }

      $select->execute(array(
        $rowId
      ));

      if ($row = $select->fetch()) {
        if (isset($_GET['lieferant'])) {
          $query = $db->prepare('UPDATE lieferantCID SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');
        } elseif  (isset($_GET['kunden'])) {
          $query = $db->prepare('UPDATE kundenCID SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');
        } elseif  (isset($_GET['firmen'])) {
          $query = $db->prepare('UPDATE companies SET `' . $colMap[$colId] . '` = :newVal WHERE id = :id');
        }
      } else {
        if (isset($_GET['lieferant'])) {
          $query = $db->prepare('INSERT INTO lieferantCID (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
        } elseif  (isset($_GET['kunden'])) {
          $query = $db->prepare('INSERT INTO kundenCID (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
        } elseif  (isset($_GET['firmen'])) {
          $query = $db->prepare('INSERT INTO companies (id, `' . $colMap[$colId] . '`) VALUES(:id, :newVal)');
        }
      }

      $query->bindValue(':id', $rowId, PDO::PARAM_INT);
      $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
      $query->execute();
    }
  } elseif (isset($_POST['data']) && $_POST['data']) {
    if (isset($_GET['lieferant'])) {
      $select = $db->prepare('DELETE FROM lieferantCID');
    } elseif  (isset($_GET['kunden'])) {
      $select = $db->prepare('DELETE FROM kundenCID');
    } elseif  (isset($_GET['firmen'])) {
      $select = $db->prepare('DELETE FROM companies');
    }

    $select->execute();

    for ($r = 0, $rlen = count($_POST['data']); $r < $rlen; $r++) {
      $rowId = $r + 1;
      for ($c = 0, $clen = count($_POST['data'][$r]); $c < $clen; $c++) {
        if (!isset($colMap[$c])) {
          continue;
        }

        $newVal = $_POST['data'][$r][$c];
        if (isset($_GET['lieferant'])) {
          $select = $db->prepare('SELECT id FROM lieferantCID WHERE id=? LIMIT 1');
        } elseif  (isset($_GET['kunden'])) {
          $select = $db->prepare('SELECT id FROM kundenCID WHERE id=? LIMIT 1');
        } elseif  (isset($_GET['firmen'])) {
          $select = $db->prepare('SELECT id FROM companies WHERE id=? LIMIT 1');
        }

        $select->execute(array(
          $rowId
        ));

        if ($row = $select->fetch()) {
          if (isset($_GET['lieferant'])) {
            $query = $db->prepare('UPDATE lieferantCID SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');
          } elseif  (isset($_GET['kunden'])) {
            $query = $db->prepare('UPDATE kundenCID SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');
          } elseif  (isset($_GET['firmen'])) {
            $query = $db->prepare('UPDATE companies SET `' . $colMap[$c] . '` = :newVal WHERE id = :id');
          }
        } else {
          if (isset($_GET['lieferant'])) {
            $query = $db->prepare('INSERT INTO lieferantCID (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');
          } elseif  (isset($_GET['kunden'])) {
            $query = $db->prepare('INSERT INTO kundenCID (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');
          } elseif  (isset($_GET['firmen'])) {
            $query = $db->prepare('INSERT INTO companies (id, `' . $colMap[$c] . '`) VALUES(:id, :newVal)');
          }
        }
        $query->bindValue(':id', $rowId, PDO::PARAM_INT);
        $query->bindValue(':newVal', $newVal, PDO::PARAM_STR);
        $query->execute();
      }
    }
  }
  $dberror = $db->error;
  $dbconnecterror = $db->connect_error;

  $out = array(
    'result' => 'ok',
    'state' => $db->sqlstate,
    'error' => $dberror,
    'connect_error' => $dbconnecterror
  );
  echo json_encode($out);

  closeConnection($db);
} else {
  $myeCode = $db->errorCode();
  echo json_encode($myeCode);
};
?>
