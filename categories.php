<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 


if(isset($_GET['name'])){
    $name = $_GET['name'];

  
    $shows = $conn->query("SELECT shows.id AS id,shows.image AS image , shows.num_avalible AS num_avalible
    , shows.num_total AS num_total, shows.title AS title, 
    shows.genre AS genre ,shows.type AS type,
    COUNT(views.show_id) AS count_views FROM shows JOIN views ON shows.id=views.id 
    WHERE shows.genre='$name' GROUP BY(shows.id)  ORDER BY views.show_id ASC;");
      $shows->execute();
    $allshows=$shows->fetchAll(PDO::FETCH_OBJ);




    $forYouShows = $conn->query("SELECT shows.id AS id,shows.image AS image , shows.num_avalible AS num_avalible
     , shows.num_total AS num_total, shows.title AS title, 
     shows.genre AS genre ,shows.type AS type,
     COUNT(views.show_id) AS count_views FROM shows JOIN views ON shows.id=views.id 
     GROUP BY(shows.id)  ORDER BY views.show_id ASC;");
     $forYouShows->execute();
 
    $allforYouShows =  $forYouShows->fetchAll(PDO::FETCH_OBJ);
}

else{
    echo"<script>location.href='".APPURL."/404.php'</script>";
 }



 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
?>
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo APPURL; ?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL; ?>/categories.php?name=<?php echo $name; ?>">Categories</a>
                        <span><?php echo $name; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4><?php echo $name; ?></h4>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <?php if(count($allshows)>0): ?>
                            <?php foreach($allshows as $show): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo IMGURL; ?><?php echo $show->image; ?>">
                                        <div class="ep"><?php echo $show->num_avalible; ?> / <?php echo $show->num_total; ?></div>
                                        <div class="view"><i class="fa fa-eye"></i> <?php echo $show->count_views; ?></div>
                                    </div>
                                    <div class="product__item__text">
                                        <ul>
                                            <li><?php echo $show->genre; ?></li>
                                            <li><?php echo $show->type; ?></li>
                                        </ul>
                                        <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $show->id; ?>"><?php echo $show->title; ?></a></h5>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-white">no shows in this genre</p>
                            <?php endif; ?>
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                        </div>
                    <!-- </div>
                </div>         -->
    </div>
    <div class="product__sidebar__comment">
        <div class="section-title">
            <h5>FOR YOU</h5>
        </div>
        <?php foreach($allforYouShows as $allforYoushow): ?>
        <div class="product__sidebar__comment__item">
            <div class="product__sidebar__comment__item__pic">
                <img style="width:150px; height:200px;" src="<?php echo IMGURL; ?><?php echo $allforYoushow->image; ?>" alt="">
            </div>
            <div class="product__sidebar__comment__item__text">
                <ul>
                    <li><?php echo $allforYoushow->genre; ?></li>
                    <li><?php echo $allforYoushow->type; ?></li>
                </ul>
                <h5><a href="<?php echo APPURL;?>/anime-details.php?id=<?php echo $allforYoushow->id; ?>"><?php echo $allforYoushow->title; ?></a></h5>
                <span><i class="fa fa-eye"></i> <?php echo $allforYoushow->count_views; ?>Viewes</span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Product Section End -->

<!-- Footer Section Begin -->
<?php require "includes/footer.php"; ?>