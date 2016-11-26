<?php
if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
} elseif (verifyFile($_FILES["file"])[0]) {
    writeFile($_FILES["file"]);
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file"]["tmp_name"];
    
    echo "Stored in: " . "data/" . $_FILES["file"]["name"];
} else {
    echo "Error: ".verifyFile($_FILES["file"])[1];
}

function verifyFile($file) {
    $db = DB::get();
    $n = $db->query("SELECT * FROM `file` WHERE `name`='".$file["name"]."'");
    $r = $n->fetch();
    if ($r) {
        return [false,'file is exist'];
    }
    return [true,''];
}

function writeFile($file) {
    $uid = uniqid('file_');
    $db = DB::get();
    $sql = "INSERT INTO `file` (`name`, `type`, `dir`, `uid`, `size`, `md5`, `creater`, `update_time`, `down`)
VALUES (?, ?, ?, ?, ?, '', NULL, now(), '0');";
    $sth = $db->prepare($sql);
    $sth->execute([$file["name"],$file["type"],'/',$uid,$file["size"]]);
    move_uploaded_file($_FILES["file"]["tmp_name"],"data/" . $uid);
    
}

class DB {
    private static $db;
    public function get() {
        if (is_null(self::$db)) {
            global $env;
            self::$db = new PDO('mysql:host=localhost:3306;dbname=test','root','');
        }
        return self::$db;
    }
}