<?php
require_once 'config.php';

if (\->connect_error) {
    die(\"❌ Connection failed: \" . \->connect_error);
}
echo \"✅ Connected successfully to MySQL!<br>\";
echo \"Database: \" . DB_NAME . \"<br>\";

// Test if tables exist
\ = \->query(\"SHOW TABLES\");
if (\->num_rows > 0) {
    echo \"✅ Tables found:<br>\";
    while (\ = \->fetch_array()) {
        echo \"- \" . \[0] . \"<br>\";
    }
} else {
    echo \"❌ No tables found. Run schema.sql first!\";
}
?>
