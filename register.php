<?php
if (isset($_POST['email']) && isset($_POST['password'])) {
} else {
    echo "<form action='' method='post'><h2>register here</h2><label>email</label><input name='email' type='text'></br><label>password</label><input name='password' type='password'></br></form>";
}