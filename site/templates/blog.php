<?php snippet('header') ?>
<?php snippet('menublog') ?>

<?php $articles = $page->children()->visible()->flip()->paginate(3) ?>


<script type="text/javascript">
    $('body').attr("id","blog");
</script>



        <section class="featured-blog-posts section">

            <div class="flexslider blog-slider">
                <ul class="slides">
                    <li class="slide slide-1">
                        <div class="flex-caption container">
                            <h3 class="title"><a href="#">Welcome to the Verve Blog</a></h3>
                            <div class="meta">Tips and tricks on dating</div>
                            <!-- <div class="meta">16th Oct, 2014</div> -->
                            <!-- <a class="more-link" href="blog-single.html">Read more &rarr;</a> -->
                        </div><!--//flex-caption-->
                    </li>
                </ul><!--//slides-->
            </div><!--//flexslider-->

        </section><!--//featured-blog-posts-->

        <!-- ******BLOG LIST****** -->
        <div class="blog container">
            <div class="row">
                <div id="blog-mansonry" class="blog-list">

                    <?php foreach($articles as $article): ?>
                    <?php $author = $pages->find('authors/' . $article->author()) ?>

                    <article class="post col-md-4 col-sm-6 col-xs-12">
                        <div class="post-inner">
                            <figure class="post-thumb">
                                <a href="<?php echo $article->url() ?>"><img class="img-responsive" src="<?php echo thumb($article->images()->find('headimage.jpg'), array('width' => 626, 'height' => 310, 'crop' => true), false) ?>" alt="" /></a>
                            </figure><!--//post-thumb-->
                            <div class="content">
                                <h3 class="post-title"><a href="<?php echo $article->url() ?>">
                                    <?php echo $article->title() ?>
                                </a></h3>
                                <div class="post-entry">
                                    <p><?php echo excerpt($article->text(), 300) ?></p>
                                    <a class="read-more" href="<?php echo $article->url() ?>">Read more <i class="fa fa-long-arrow-right"></i></a>
                                </div>
                                <div class="meta">
                                    <ul class="meta-list list-inline">
                                        <li class="post-time post_date date updated">
                                             <?php
                                                $somedate = strtotime($article->releasedate());
                                                echo date("F",mktime(0,0,0,date('m', $somedate),1,2011)) . ' ';
                                                echo date('n', $somedate) . ', ';
                                                echo date('Y', $somedate);
                                            ?>
                                        </li>
                                        <li class="post-author"> by <a href="#">James Lee</a></li>
                                        <li class="post-comments-link">
                                            <a href="blog-single.html#comment-area"><i class="fa fa-comments"></i>8</a>
                                        </li>
                                    </ul><!--//meta-list-->
                                </div><!--meta-->
                            </div><!--//content-->
                        </div><!--//post-inner-->
                    </article><!--//post-->

                    <?php endforeach ?>

                </div><!--//blog-list-->
            </div><!--//row-->
            <div class="pagination-container text-center">
                <ul class="pagination">
                    <li class="disabled"><a href="#">&laquo;</a></li>
                    <li class="active"><a href="#">1<span class="sr-only">(current)</span></a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul><!--//pagination-->
            </div><!--//pagination-container-->
        </div><!--//blog-->
    </div><!--//wrapper-->





</div>

<?php snippet('footer') ?>