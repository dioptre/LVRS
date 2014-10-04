<?php snippet('header') ?>
<?php snippet('menu') ?>
<?php snippet('blogcover') ?>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53b79ccb2c56663e"></script>

<script type="text/javascript">
    $('body').attr("id","blogpost");
</script>

<?php $author = $pages->find('authors/' . $page->author()) ?>

<div id="blogpost-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-pic">
                    <img src="<?php echo $page->images()->find('headimage.jpg')->url() ?>" class="img-responsive" alt="blogpost" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 post">
                <div class="title">
                    <?php echo $page->title() ?>
                </div>
                <div class="author">
                    <img src="<?php echo $author->images()->first()->url() ?>" class="avatar hidden-sm" alt="author" />
                    By <?php echo $author->title() ?>,
                    <?php
                        $somedate = strtotime($page->releasedate());
                        echo date("F",mktime(0,0,0,date('m', $somedate),1,2011)) . ' ';
                        echo date('n', $somedate) . ', ';
                        echo date('Y', $somedate);
                    ?>
                </div>
                <div class="sharing"><!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <div class="addthis_native_toolbox"></div>
                </div>
                <div class="content">
                    <?php echo kirbytext($page->text()) ?>
                </div>
                <div class="other-posts">
                    <?php if($page->hasPrevVisible()): ?>
                        <a href="<?php echo $page->prev()->url() ?>" class="prev">
                            <?php echo $page->prev()->title() ?>
                        </a>
                    <?php endif ?>

                    <?php if($page->hasNextVisible()): ?>
                        <a href="<?php echo $page->next()->url() ?>" class="next pull-right">
                            <?php echo $page->next()->title() ?>
                        </a>
                    <?php endif ?>
                </div>

                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_recommended_horizontal"></div>

                <!-- Disqus comments -->
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = 'flowproblog'; // required: replace example with your forum shortname

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

            </div>
        </div>
    </div>
</div>



<?php snippet('footer') ?>