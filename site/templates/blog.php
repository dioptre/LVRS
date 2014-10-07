<?php snippet('header') ?>
<?php snippet('menublog') ?>

<?php $articles = $page->children()->visible()->flip()->paginate(10) ?>


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
                                        <li class="post-author"> by <a href="#">
                                            <?php echo $site->users()->find(html($article->author()))->firstname() ?>
                                            <?php echo $site->users()->find(html($article->author()))->lastname() ?>
                                        </a></li>
                                        <li class="post-comments-link">
                                            <a href="<?php echo $article->url() ?>#comment-area"><i class="fa fa-comments"></i><a href="<?php echo $article->url() ?>#disqus_thread">0</a></a>
                                        </li>
                                    </ul><!--//meta-list-->
                                </div><!--meta-->
                            </div><!--//content-->
                        </div><!--//post-inner-->
                    </article><!--//post-->

                    <?php endforeach ?>

                </div><!--//blog-list-->
            </div><!--//row-->

            <!-- Setup Pagination -->
            <?php if($articles->pagination()->hasPages()): ?>
                <div class="pagination-container text-center">
                    <ul class="pagination">
                        <?php if($articles->pagination()->hasNextPage()): ?>
                            <li><a href="<?php echo $articles->pagination()->nextPageURL() ?>">Older posts &raquo;</a></li>
                        <?php endif ?>

                        <?php if($articles->pagination()->hasPrevPage()): ?>
                            <li><a href="<?php echo $articles->pagination()->prevPageURL() ?>">&laquo; Newer posts</a></li>
                        <?php endif ?>
                    </ul><!--//pagination-->
                </div><!--//pagination-container-->
            <?php endif ?>
        </div><!--//blog-->
    </div><!--//wrapper-->





</div>
<script type="text/javascript">
/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
var disqus_shortname = 'verveb'; // required: replace example with your forum shortname

/* * * DON'T EDIT BELOW THIS LINE * * */
(function () {
var s = document.createElement('script'); s.async = true;
s.type = 'text/javascript';
s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
(document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
}());
</script>


<?php snippet('footer') ?>