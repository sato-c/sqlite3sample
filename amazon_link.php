<?php
    # PDO sqlite3 ドライバを使ってsqliteにアクセスする
    # https://www.php.net/manual/ja/pdo.prepare.php

    $pdo = new PDO ( 'sqlite:/var/www/html/amazon_link.sq3');

    $sql = 'SELECT * FROM "itemlist" WHERE item_view = 1';
    $stored = $pdo->prepare( $sql );
    $stored->execute([]);
    $result = $stored->fetchAll();

    $s = random_int( 1, sizeof($result) - 1 );

    printf ( '<a href="https://www.amazon.co.jp/dp/%s/?tag=%s">%s</a>', $result[$s]['item_dp'], $tag, $result[$s]['item_description']);
?>
