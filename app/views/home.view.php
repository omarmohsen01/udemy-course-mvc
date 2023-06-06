<?php $this->view('includes/header',$data) ?>
<?php $this->view('includes/nav',$data) ?>

    <?php if(!empty($rows)):?>
    <!-- ======= Hero Slider Section ======= -->
    <section id="hero-slider" class="hero-slider">
      <div class="container-md" data-aos="fade-in">
        <div class="row">
          <div class="col-12">
            <div class="swiper sliderFeaturedPosts">
              <div class="swiper-wrapper">
                <?php foreach($trending as $row):?>
                <div class="swiper-slide">
                  <a href="single-post.html" class="img-bg d-flex align-items-end" style="background-image: url('<?php if(empty($row->course_image)){echo ROOT.'/uploads/images/online.jpg';}else{echo get_image($row->course_image);}?>');">
                    <div class="img-bg-inner">
                      <h2><?=$row->title?></h2>
                      <p><?=$row->description?></p>
                    </div>
                  </a>
                </div>
                <?php endforeach;?>
              </div>
              <div class="custom-swiper-button-next">
                <span class="bi-chevron-right"></span>
              </div>
              <div class="custom-swiper-button-prev">
                <span class="bi-chevron-left"></span>
              </div>

              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Hero Slider Section -->
    <?php endif;?>
    
    <?php if(!empty($rows)):?>
    <!-- ======= Post Grid Section ======= -->
    <section id="posts" class="posts">
      <div class="container" data-aos="fade-up">
      <div class="section-header d-flex justify-content-between align-items-center mb-5">
          <h2>Latest</h2>
          <div><a href="category.html" class="more">See All Latest</a></div>
        </div>
        <div class="row g-5">
          <div class="col-lg-4">
            <div class="post-entry-1 lg">
              <a href="single-post.html"><img src="<?=get_image($firstrow->course_image)?>" alt="" class="img-fluid"></a>
              <div class="post-meta"><span class="date"><?= $firstrow->category?></span> <span class="mx-1">&bullet;</span> <span><?= date("jS M, Y",strtotime($firstrow->date))?></span></div>
              <h2><a href="single-post.html"><?= $firstrow->title?></a></h2>
              <p class="mb-4 d-block"><?= $firstrow->description?></p>

              <?php if(!empty($firstrow->user_id)):?>
              <div class="d-flex align-items-center author">
                <div class="photo"><img src="" alt="" class="img-fluid"></div>
                <div class="name">
                  <h3 class="m-0 p-0"><?=$firstrow->firstname?></h3>
                </div>
              </div>
              <?php endif;?>
            </div>

          </div>

          <div class="col-lg-8">
            <div class="row g-5">
              <div class="col-lg-4 border-start custom-border">
                <?php foreach($rows1 as $row):?>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="<?= get_image($row->course_image)?>" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date"><?= ($row->category)??'unknown'?></span> <span class="mx-1">&bullet;</span> <span><?= date("jS M, Y",strtotime($row->date))?></span></div>
                  <h2><a href="single-post.html"><?= ($row->title)?></a></h2>
                </div>
                <hr>
                <?php endforeach;?>
              </div>
              
              <div class="col-lg-4 border-start custom-border">
                <?php foreach($rows2 as $row):?>
                <div class="post-entry-1">
                  <a href="single-post.html"><img src="<?= get_image($row->course_image)?>" alt="" class="img-fluid"></a>
                  <div class="post-meta"><span class="date"><?= ($row->category)??'unknown'?></span> <span class="mx-1">&bullet;</span> <span><?= date("jS M, Y",strtotime($row->date))?></span></div>
                  <h2><a href="single-post.html"><?= ($row->title)?></a></h2>
                </div>
                <hr>
                <?php endforeach;?>
              </div>
              <!-- Trending Section -->
              <div class="col-lg-4">

                <div class="trending">
                  <h3>Trending</h3>
                  <ul class="trending-post">
                    <?php if(!empty($trending)) :$num=0;
                          foreach($trending as $row):$num++;?>
                    <li>
                      <a href="single-post.html">
                        <span class="number"><?=$num?></span>
                        <h3><?=$row->title?></h3>
                        <span class="author"><?=$row->firstname??'unknown'?></span>
                      </a>
                    </li>
                    <?php endforeach; endif;?>
                  </ul>
                </div>
              </div> <!-- End Trending Section -->
            </div>
          </div>
        </div> <!-- End .row -->
      </div>
    </section> <!-- End Post Grid Section -->
    <?php endif;?>

   

<?php $this->view('includes/footer',$data) ?>

