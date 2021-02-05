<?php
 
 $db_host = 'localhost';
 $db_name = 'sausage_legend';
 $db_user = 'root';
 $db_pass = 'root';
  
 // データベースへ接続する
 $link = mysqli_connect( $db_host, $db_user, $db_pass, $db_name );
 if ( $link !== false ) {
  
     $msg     = '';
     $err_msg = '';
  
     if ( isset( $_POST['send'] ) === true ) {
  
         $name    = $_POST['name']   ;
         $message = $_POST['message'];

  
         if ( $name !== '' && $message !== '' ) {
  
             $query = " INSERT INTO comment ( "
                    . "    name, "
                    . "    message, "
                    . " ) VALUES ( "
                    . "'" . mysqli_real_escape_string( $link, $name ) ."', "
                    . "'" . mysqli_real_escape_string( $link, $message ) ."' "
                    ." ) ";
  
             $res   = mysqli_query( $link, $query );
             
             if ( $res !== false ) {
                 $msg = '書き込みに成功しました';
             }else{
                 $err_msg = '書き込みに失敗しました';
             }
         }else{
             $err_msg = '名前とコメントを記入してください';
         }
     }
  
     $query  = "SELECT  name, message, pageid FROM comment WHERE pageid = 1";
     $res    = mysqli_query( $link,$query );
     $data = array();
     while( $row = mysqli_fetch_assoc( $res ) ) {
         array_push( $data, $row);
     }
     arsort( $data );
  
 } else {
     echo "データベースの接続に失敗しました";
 }
  
 // データベースへの接続を閉じる
 mysqli_close( $link );
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>testbord</title>
    <link rel="stylesheet" href="style3-2.css">
</head>
<body>
<h3>Comment</h2>
  <?php
    if ( $msg     !== '' ) echo '<p>' . $msg . '</p>';
    if ( $err_msg !== '' ) echo '<p style="color:#f00;">' . $err_msg . '</p>';
    foreach( $data as $key => $val ){
        echo "<h4 style='border-top: 1px solid skyblue'>$val[name]</h4>" . "<p>$val[message]</p>" ;
    }
  ?>
  <form action="board.php" method="post">
      <h3>Message</h2>
      <div class ="namedecide">
        <label for="name">名前</label>
        <input type="text" name="name" value="">
      </div>
      <div class ="commentdecide">
        <label for="message">コメント</label>
        <textarea type="text" id="message" name="message"></textarea>
      </div>
      <input type="submit" name="send" class="send">
  </form>
</body>
</html>