<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

switch ($action) {
    case 'get':
        $stmtS = $db->prepare('SELECT COUNT(*) FROM Sections');
        $stmtC = $db->prepare('SELECT COUNT(*) FROM Categories');
        $stmtI = $db->prepare('SELECT COUNT(*) FROM Items');

        $sectionCount = $stmtS->execute()->fetchArray(SQLITE3_NUM)[0];
        $categoryCount = $stmtC->execute()->fetchArray(SQLITE3_NUM)[0];
        $itemCount = $stmtI->execute()->fetchArray(SQLITE3_NUM)[0];

        $data = array(
            'sectionCount' => $sectionCount,
            'categoryCount' => $categoryCount,
            'itemCount' => $itemCount
        );
        echo json_encode($data);
        break;
}
