<?php snippet('header') ?>
<?php snippet('menu') ?>
<?php snippet('blogcover') ?>

<?php $articles = $page->children()->visible()->flip()->paginate(3) ?>


<script type="text/javascript">
    $('body').attr("id","blog");
</script>


<div id="posts">
    <div class="container">
        <div class="row">
            <div class="col-md-9">

                <!-- Loop for all the articles -->
                <?php foreach($articles as $article): ?>
                    <?php $author = $pages->find('authors/' . $article->author()) ?>
                    <div class="post">
                        <a href="<?php echo $article->url() ?>" class="pic" title="<?php echo $article->title() ?>">
                            <img src="<?php echo thumb($article->images()->find('headimage.jpg'), array('width' => 626, 'height' => 310, 'crop' => true), false) ?>" class="img-responsive" alt="blogpost" />
                        </a>

                        <div class="title">
                             <a href="<?php echo $article->url() ?>" title="<?php echo $article->title() ?>">
                                <?php echo $article->title() ?>
                            </a>
                        </div>
                        <div class="author">
                            <img src="<?php echo $author->images()->first()->url() ?>" class="avatar hidden-sm" alt="author" />
                            By <?php echo $author->title() ?>,
                            <?php
                                $somedate = strtotime($article->releasedate());
                                echo date("F",mktime(0,0,0,date('m', $somedate),1,2011)) . ' ';
                                echo date('n', $somedate) . ', ';
                                echo date('Y', $somedate);
                            ?>
                        </div>
                        <p class="intro">
                            <?php echo excerpt($article->text(), 300) ?>
                        </p>
                        <a href="<?php echo $article->url() ?>" class="continue-reading">Continue reading this post</a>
                    </div>

                <?php endforeach ?>


                <!-- Setup Pagination -->
                <?php if($articles->pagination()->hasPages()): ?>
                    <div class="pages">
                        <ul class="pagination">
                            <?php if($articles->pagination()->hasNextPage()): ?>
                                <li><a href="<?php echo $articles->pagination()->nextPageURL() ?>">Older posts &raquo; </a></li>
                            <?php endif ?>

                            <?php if($articles->pagination()->hasPrevPage()): ?>
                                <li><a href="<?php echo $articles->pagination()->prevPageURL() ?>">&laquo; Newer posts</a></li>
                            <?php endif ?>
                        </ul>
                    </div>
                <?php endif ?>

            </div>
            <div class="col-md-3 sidebar">
                <?php echo html($page->text()) ?>
            </div>
        </div>
    </div>
</div>

<?php snippet('footer') ?>