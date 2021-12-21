<?php
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('presence_check.db');
      }
   }
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF
      CREATE TABLE PresenceCheck
      (ID INTEGER PRIMARY KEY AUTOINCREMENT,
      Name           TEXT     NOT NULL,
      Result         INT      NOT NULL,
      Created        DATETIME NOT NULL);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Table created successfully\n";
   }

   $json_str = file_get_contents("config.json");
   $config = json_decode($json_str);

   foreach($config->endpoints as &$endpoint){
     $output = '';
     $result = 1;

     exec('ping -c 2 ' . $endpoint->ip, $output, $result);

     $sql ="
      INSERT INTO PresenceCheck (Name, Result, Created)
      VALUES ('" . $endpoint->name . "', '" . ($result_one == 0 ? 'true' : 'false') ."', DATETIME('now'));";

     $ret = $db->exec($sql);
     if(!$ret) {
       echo $db->lastErrorMsg();
     } else {
       echo "Records created successfully\n";
     }
   }

   $db->close();
?>

