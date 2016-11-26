<?php
/*
 * lonefirst-dirve demo version
 * author : WangJie
 * lastest updating : 2016-06-27
 * develop note : 我是在带着情绪写着丑陋的代码
 */

// enviroment variables
$env= [
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'test',
        ], // database info (type : mysql-only)
    'app' => 7642309104013123, // a ramdom number
    ];

// class
class system {
    // can control the whole program file
    public function selfCheck() {
        global $env;
        // it is no need to use if it is not the first run
        try {
            // check the database connect status
            $dbh = new PDO('mysql:host='.$env['db']['host'].';dbname='.$env['db']['db'],$env['db']['user'],$env['db']['pass']);
            // check the table structure
            /*$tableS = $dbh->exec("select name from syscolumns where id=object_id('user')");
            if ($tableS == 0) {
                throw new Exception('table structure error,please create or change the table.');
            }*/
            $dbh = null;
        } catch (PDOException $e) {
            echo "self check fail : " . $e->getMessage() . "<br/>";
        }
    }
}
class DB {
    private static $db;
    public function get() {
        if (is_null(self::$db)) {
            global $env;
            self::$db = new PDO('mysql:host='.$env['db']['host'].';dbname='.$env['db']['db'],$env['db']['user'],$env['db']['pass']);
        }
        return self::$db;
    }
    public function dis() {
        self::$db = null;
        return 1;
    }
}
class user {
    public $id;
    final function __construct($pin) {
        $db = DB::get();
        $n = $db->query('SELECT '.$pin.' FROM user');
        if($n == null) {
            return 0;
        } else {
            self::$id = $n['id'];
            return 1;
        }
    }
    public function auth($cookie) {
    }
}

class file {
    public $dir ="/";
    public $name:
    public $type;
    public function ls($dir[,bool $detail]) {
        $db = DB::get();
        $n = $db->query("SELECT ".($detail == true)?"*":"name";." FROM file ".(isset($dir))?"WHERE dir='".$dir."'":;);
        $r = $n->fetchAll();
        return $r;
    }
    // error ,not oo !!!!!
    public function fetchFile($file) {
        $db = DB::get();
        $n = $db->query("SELECT uid FROM file WHERE dir='".self::$dir."' AND ' name='".self::$name."'");
        $r = $n->fetchColumn();
        if (!$r) {return false;}
        return $r;
    }
    public function load($file) {
        $r = self::fetchFile() {
        }
        header('content-type:'.self::$type);
        header('Content-Disposition: attachment; filename="'.self::$name.'"');
        readfile($r);
    }
    public function rm($file[,bool $complete]) {
        if($complete) {
            $d
        }
    }
}
// web data
echo "<script>console.log('If u can do me a favor to design a front for this program please contact me with qq 924897716 and thx 2 u first!');</script>";
$htmlIndex = <<<html
<!DOCTYPE html>
<html>
<head>
<title>Lonefirst Drive</title>
<meta charset='utf-8'>
<meta author='Wang Jie'>
</head>
<body>
<h1>Welcome to Lonefirst drive program!</h1>
<p>I am sure you must be thinking that 'it is an ugly website has no front and i have not seen before!'and some idiots even think is an error page.However ,the author just do not know how to design a front.</p>
<form action="index.php" method="post">
    <p>log in here!</p>
    <input name="requestType" type="hidden" value="login">
    <label>enter your PIN</label>
    <input name="PIN" type="password">
</form>
<form action="index.php" method="post">
    <p>register here!</p>
    <input name="requestType" type="hidden" value="reg">
    <label>pin</label>
    <input name="PIN" type="password"><br>
    <label>invite code</label>
    <input name="inviteCode" type="text">
</form><hr>
<p>lonefirst-dirve by WangJie</p>
</body>
</html>
html;

// self check
system::selfCheck();

// verify the request
if (isset($_REQUEST['requestType'])) {
    switch ($_REQUEST['requestType']) {
        case 'login':
            goto loginCode;
        case 'reg':
            goto regCode;
        default:
            // it is a common request
            throw new exception('error request type');
    }
} else {
    goto defaultCode;
}


loginCode:
echo ($_POST['PIN'] == null)?$htmlIndex:"your PIN is ".$_POST['PIN'];
$pin = $_POST['PIN'];
$lastlogin = time();
$user = new user($_POST['PIN']);
$ip = $_SERVER('REMOTE_ADDR');
// Create a cookie include information of timescrop,salt and guest ip.Every request need to verify this data to sure the request is come from the true user after that.We use SHA256 in order to avoid that hacker get any information for hash.
$US = hash('sha256',$PIN.$timeS.$env['app'].$ip);
setcookie("US", $US, time()+3600);
$user->insert('all');
return;

regCode:
return;

defaultCode:
if (!isset($_COOKIE['$US'])) {
    echo $htmlIndex;
}
return;


?>