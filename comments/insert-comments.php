<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

  //inserting comments
if(isset($_POST['inserting_comments'])){
    if(empty($_POST['comment'])){
       echo "<script>alert('comment is  empty')</script>";
    }else{
       
        $comment=$_POST['comment'];
        $show_id=$_POST['show_id'];
        $user_id=$_SESSION['user_id'];
        $user_name=$_SESSION['username'];
        $page_url = $_POST['page_url'];

        $insert= $conn->prepare("INSERT INTO comments (comment,show_id,user_id,user_name) 
            VALUES ( :comment, :show_id, :user_id, :user_name)");

        $insert->execute([
            ":comment" => $comment,
            ":show_id" => $show_id,
            ":user_id" => $user_id,
            ":user_name" => $user_name
   
        ]);
         // Insert the comment into the database using $comment, $show_id, and $page_url
// ...

// Redirect the user back to the same page
        $redirect_url = APPURL . "/anime-details.php?id=" . $show_id;
        if (isset($_POST['page_url'])) {
            $redirect_url = $_POST['page_url'];
        }
        echo "<script>window.location.href='" . $redirect_url . "'</script>";
        
            
    }


}


?>

