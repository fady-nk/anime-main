<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php

if(isset($_GET['id']) AND isset($_GET['ep'])) {

    $id = $_GET['id'];
    $ep = $_GET['ep'];


    $episodes=$conn->query("SELECT * FROM episodes WHERE show_id='$id' ");
    $episodes->execute();
    $allEpisodes=$episodes->fetchAll(PDO::FETCH_OBJ);

    //grabbing episode
    $episode=$conn->query("SELECT * FROM episodes WHERE show_id='$id' AND name='$ep' ");
    $episode->execute();
    $singleEpisode=$episode->fetch(PDO::FETCH_OBJ);

    //show data
    
    $show=$conn->query("SELECT * FROM shows WHERE id='$id'  ");
    $show->execute();
    $singleShow=$show->fetch(PDO::FETCH_OBJ);



    $comments=$conn->query("SELECT * FROM comments WHERE show_id='$id'");
    $comments->execute();

    $allComments = $comments->fetchAll(PDO::FETCH_OBJ);

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

}

else{
    echo"<script>location.href='".APPURL."/404.php'</script>";
 }

?>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                    <a href="<?php echo APPURL; ?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL; ?>/categories.php?name=<?php echo $singleShow->genre; ?>">Categories</a>
                        <span>Ep<?php echo $singleShow->title; ?></span>
                        <span>Ep<?php echo $singleEpisode->name; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="anime__video__player">
                        <video id="player" playsinline controls data-poster="<?php echo VIDEOSURL; ?>/<?php echo $singleEpisode->thumbnail; ?>">
                            <source src="<?php echo VIDEOSURL; ?>/<?php echo $singleEpisode->video; ?>" type="video/mp4"/>
                            <!-- Captions are optional -->
                           <!--<track kind="captions" label="English captions" src="#" srclang="en" default />
-->                    </video>
                    </div>
                    <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>List Name</h5>
                        </div>
                        <?php foreach($allEpisodes as $episode): ?>
                        <a href="<?php echo APPURL;?>/anime-watching.php?id=<?php echo $episode->show_id; ?>&ep=<?php echo $episode->name; ?>" >Ep <?php echo $episode->name; ?> </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>comments</h5>
                        </div>
                        L<?php foreach($allComments as $comment): ?>
                        <div class="anime__review__item">
                            <!--<div class="anime__review__item__pic">
                                <img src="img/anime/review-1.jpg" alt="">
                            </div> -->
                            <div class="anime__review__item__text">
                                <h6><?php echo $comment->user_name; ?> <span><?php echo $comment->created_at; ?></span></h6>
                                <p><?php echo $comment->comment; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        <form method="POST" action="<?php echo APPURL;?>/comments/insert-comments.php">
                                <textarea name="comment"placeholder="Your Comment"></textarea>
                                <input type="hidden" name="show_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="page_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                <button name="inserting_comments" type="submit"><i class="fa fa-location-arrow"></i> comment</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

    <!-- Footer Section Begin -->
<?php require "includes/footer.php"; ?>