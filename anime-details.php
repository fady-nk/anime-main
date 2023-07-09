<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $show = $conn->query("SELECT shows.id AS id,shows.image AS image , shows.num_avalible AS num_avalible
    , shows.num_total AS num_total, shows.title AS title, 
    shows.genre AS genre ,shows.type AS type,shows.description AS description, shows.duration AS duration,shows.date_aired AS date_aired,
     shows.quality AS quality,shows.status AS status,shows.studios AS studios, COUNT(views.show_id) AS count_views FROM shows JOIN views ON shows.id=views.show_id 
    WHERE shows.id='$id' GROUP BY(shows.id)");
    $show -> execute();
    $singleshow = $show->fetch(PDO::FETCH_OBJ);
  



    $forYouShows = $conn->query("SELECT shows.id AS id,shows.image AS image , shows.num_avalible AS num_avalible
     , shows.num_total AS num_total, shows.title AS title, 
     shows.genre AS genre ,shows.type AS type,
     COUNT(views.show_id) AS count_views FROM shows JOIN views ON shows.id=views.id 
     GROUP BY(shows.id)  ORDER BY views.show_id ASC;");
     $forYouShows->execute();
 
    $allforYouShows =  $forYouShows->fetchAll(PDO::FETCH_OBJ);

    //comments

    $comments=$conn->query("SELECT * FROM comments WHERE show_id='$id'");
    $comments->execute();

    $allComments = $comments->fetchAll(PDO::FETCH_OBJ);



    //following

    if(isset($_POST['submit'])) {

        $show_id= $_POST['show_id'];
        $user_id= $_POST['user_id'];

        
        $follow = $conn->prepare("INSERT INTO followings (show_id, user_id) VALUES (:show_id, :user_id)");
        $follow->execute([
            "show_id" => $show_id,
            "user_id" => $user_id
        ]);
        echo"<script>alert('you are following this show')</script>";
            //header("location: ".APPURL."/anime-details.php?id=".$id."");
    }
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



  //checking if user followeed this show
  $checkfollowing = $conn->query("SELECT * FROM followings WHERE show_id='$id' AND user_id='$_SESSION[user_id]'");
  $checkfollowing->execute();
 

 //checking if user viewed this show
 $checkView= $conn->query("SELECT * FROM views WHERE show_id='$id' AND user_id='$_SESSION[user_id]'");
 $checkView->execute();
 if($checkView->rowCount()==0){
    $insertView = $conn->prepare("INSERT INTO views (show_id, user_id) VALUES (:show_id, :user_id)");
    $insertView->execute([
        "show_id" => $id,
        "user_id" => $_SESSION['user_id']
    ]);
 }
 
}else{
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
                        <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories.html">Categories</a>
                        <span>Romance</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="img/<?php echo $singleshow->image; ?>">
                            
                            <div class="view"><i class="fa fa-eye"></i> <?php echo $singleshow->count_views; ?></div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3> <?php echo $singleshow->title; ?></h3>
                            </div>
                           
                            <p> <?php echo $singleshow->description; ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span>  <?php echo $singleshow->type; ?></li>
                                            <li><span>Studios:</span>  <?php echo $singleshow->studios; ?></li>
                                            <li><span>Date aired:</span>  <?php echo $singleshow->date_aired; ?></li>
                                            <li><span>Status:</span>  <?php echo $singleshow->status; ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Genre:</span>  <?php echo $singleshow->genre; ?></li>

                                            <li><span>Duration:</span>  <?php echo $singleshow->duration; ?> min/ep</li>
                                            <li><span>Quality:</span>  <?php echo $singleshow->quality; ?></li>
                                            <li><span>Views:</span>  <?php echo $singleshow->count_views; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <form method="POST" action="anime-details.php?id=<?php echo $id; ?>">
                                <input type="hidden" name="show_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <?php if($checkfollowing->rowCount()>0): ?>
                                <button name="submit" type="submit" class="follow-btn" disabled><i class="fa fa-heart-o"></i> Followed</button>
                                <?php else: ?>
                                <button name="submit" type="submit" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</button>
                                <?php endif; ?>
                                <a href="anime-watching.php?id=<?php echo $id;?>&ep=1" class="watch-btn"><span>Watch Now</span> <i
                                    class="fa fa-angle-right"></i></a>
                                </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="anime__details__review">
                            <div class="section-title">
                                <h5>Reviews</h5>
                            </div>
                            <?php foreach($allComments as $comment): ?>
                            <div class="anime__review__item">
                               <!-- <div class="anime__review__item__pic">
                                    <img src="img/anime/review-1.jpg" alt="">
                                </div> -->

                                <div class="anime__review__item__text">
                                    <h6><?php echo $comment->user_name; ?> - <span><?php echo $comment->created_at; ?></span></h6>
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
                    <div class="col-lg-4 col-md-4">
                        <div class="anime__details__sidebar">
                            
                            <div class="section-title">
                                <h5>you might like...</h5>
                            </div>
                           <?php foreach($allforYouShows as $allforYouShow): ?>
                            <div class="product__sidebar__view__item set-bg" data-setbg="img/<?php echo $allforYouShow->image;?>">
                                <div class="ep"><?php echo $allforYouShow->num_avalible;?>/ <?php echo $allforYouShow->num_total;?></div>
                                <div class="view"><i class="fa fa-eye"></i> <?php echo $allforYouShow->count_views;?></div>
                                <h5><a href="<?php echo APPURL;?>/anime-details.php?id=<?php echo $allforYouShow->id;?>"><?php echo $allforYouShow->title;?></a></h5>
                            </div>
                            <?php endforeach; ?>
                            </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Anime Section End -->

        <!-- Footer Section Begin -->
        <?php require "includes/footer.php"; ?>