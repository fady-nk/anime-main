<?php 
try {
//host 
 $HOST="localhost";

//db name
 $DBNAME="anime";

//user
 $USER="root";

//password
 $PASS='';

$conn = new PDO("mysql:host=".$HOST.";dbname=".$DBNAME, $USER, $PASS);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//triger error exception
/*if($conn==true){
    echo "connected";
}else{
    echo "not connected";
}
*/

}
 catch (PDOException $e) {
    echo $e->getMessage();
 }



 
?>