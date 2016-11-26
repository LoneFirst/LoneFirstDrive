<?php
$filetype = [
    'file' => 'application/octet-stream',
];
if(isset($_REQUEST['name']) && isset($_REQUEST['dir'])) {
echo '0';
header('content-type:'.$filetype[getFileType($name,$dir)]);
header('Content-Disposition: attachment;filename="'.$_REQUEST['name'].'"');
readfile('data/'.read($name,$dir));
}else{
//echo"<form action='' method='post'><p>download</p><input name='name' type='text'><button type='submit'>GET</button></form>";
echo"<form action='pushfile.php' method='post' enctype='multipart/form-data'><h2>upload</h2><input name='file' type='file'><button type='submit'>PUSH</button></form>";
ls('/');
}

$env= [
    'db' => [
        'host' => 'localhost:3306',
        'user' => 'root',
        'pass' => '',
        'db' => 'test',
        ], // database info (type : mysql-only)
    'app' => 7642309104013123, // a ramdom number
    ];


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
// list files in the direatory
function ls($dir) {
    echo "dir:".$dir;
    $db = DB::get();
    $n = $db->query("SELECT `name` FROM `file` WHERE `dir`='".$dir."'");
    echo "<table border='0'><tr><th>file name</th></tr>";
    while ($row = $n->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        $name = $row[0];
        echo "<tr><td><a href='?name=".$name."&dir=".$dir."' target='_blank'>".$name."</a></td></tr>";
    }
    echo "</table>";
}

// read the data of file
function read($name,$dir) {
    $db = DB::get();
    $n = $db->query("SELECT `uid` FROM `file` WHERE `name`='".$name."' AND `dir`='".$dir."'");
    $row = $n->fetch();
    return $row;
}

// get the type of file
function getFileType($name,$dir) {
    $db = DB::get();
    $n = $db->query("SELECT `type` FROM `file` WHERE `name`='".$name."' AND `dir`='".$dir."'");
    $row = $n->fetch();
    return $row;
}