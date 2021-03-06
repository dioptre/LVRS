<?php snippet('header') ?>
<?php snippet('menu') ?>


<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5431e7230869c14e" async></script>

<script type="text/javascript">
    $('body').attr("id","blog-page blog-page-single");
</script>

<?php $author = $pages->find('authors/' . $page->author()) ?>

    <!-- ******BLOG****** -->
    <div class="blog-entry-wrapper">
        <!--
        <div class="blog-headline-bg">
        </div><!--//blog-headline-bg-->
        <div class="blog-entry">
            <article class="post">
                <header class="blog-entry-heading" style="background-image: url('<?php echo $page->images()->find('headimage.jpg')->url() ?>');">
                    <div class="container text-center">
                        <h2 class="title"><?php echo html($page->title()) ?></h2>
                        <div class="meta">
                            <ul class="meta-list list-inline">
                                <li class="post-time">
                                    <?php
                                        $somedate = strtotime($page->releasedate());
                                        echo date("F",mktime(0,0,0,date('m', $somedate),1,2011)) . ' ';
                                        echo date('n', $somedate) . ', ';
                                        echo date('Y', $somedate);
                                    ?>
                                </li>
                                <li class="post-author"> by
                                    <a href="#">
                                        <?php
                                            $authorName = $page->author()->html();
                                           if($authorName){
                                               if($author = $site->users()->find($authorName)){
                                                    echo $author->firstname() . ' ' . $author->lastname();
                                               }

                                            }
                                        ?>
                                    </a>
                                </li>
                            </ul><!--//meta-list-->
                        </div><!--meta-->
                    </div><!--//container-->
                    <nav class="post-nav post-nav-top">
                        <?php if($page->hasPrevVisible()): ?>
                            <span class="nav-previous">
                                <a href="<?php echo $page->prev()->url() ?>" rel="prev">
                                    <i class="fa fa-long-arrow-left"></i>
                                    Previous post
                                    </a>
                            </span>
                        <?php endif ?>
                        <?php if($page->hasNextVisible()): ?>
                            <span class="nav-next">
                                <a href="<?php echo $page->next()->url() ?>" rel="next">
                                    Next post
                                    <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </span>
                        <?php endif ?>
                    </nav><!--//post-nav-->
                </header><!--//blog-entry-heading-->

                <div class="container">
                    <div class="row">
                        <div class="blog-entry-content col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                           <?php echo kirbytext($page->text()) ?>
                        </div><!--//blog-entry-content-->

                        <!--//Soical media buttons: https://github.com/kni-labs/rrssb (More examples) -->
                        <div class="share-container col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                            <span class="label">share this:</span>

                            <!-- Buttons start here. Copy this ul to your document. -->
                            <ul class="rrssb-buttons clearfix">
                                <li class="facebook">
                                    <!-- Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
                                    https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $page->url() ?>" class="popup">
                                        <span class="icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                <path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
                                                    c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
                                                    c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
                                            </svg>
                                        </span>
                                        <span class="text">facebook</span>
                                    </a>
                                </li>

                                <li class="twitter">
                                    <!-- Replace href with your Meta and URL information  -->
                                    <a href="http://twitter.com/home?status=<?php echo $page->url() ?>" class="popup">
                                        <span class="icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                            <path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
                                                c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
                                                C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
                                                C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
                                                c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
                                                C26.275,7.229,25.39,8.196,24.253,8.756z"/>
                                            </svg>
                                       </span>
                                        <span class="text">twitter</span>
                                    </a>
                                </li>
                                <li class="linkedin">
                                    <!-- Replace href with your meta and URL information -->
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $page->url() ?>&amp;title=<?php echo urlencode($page->title()) ?>" class="popup">
                                        <span class="icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                <path d="M25.424,15.887v8.447h-4.896v-7.882c0-1.979-0.709-3.331-2.48-3.331c-1.354,0-2.158,0.911-2.514,1.803
                                                    c-0.129,0.315-0.162,0.753-0.162,1.194v8.216h-4.899c0,0,0.066-13.349,0-14.731h4.899v2.088c-0.01,0.016-0.023,0.032-0.033,0.048
                                                    h0.033V11.69c0.65-1.002,1.812-2.435,4.414-2.435C23.008,9.254,25.424,11.361,25.424,15.887z M5.348,2.501
                                                    c-1.676,0-2.772,1.092-2.772,2.539c0,1.421,1.066,2.538,2.717,2.546h0.032c1.709,0,2.771-1.132,2.771-2.546
                                                    C8.054,3.593,7.019,2.501,5.343,2.501H5.348z M2.867,24.334h4.897V9.603H2.867V24.334z"/>
                                            </svg>
                                        </span>
                                        <span class="text">linkedin</span>
                                    </a>
                                </li>

                                <li class="googleplus">
                                    <!-- Replace href with your meta and URL information.  -->
                                    <a href="https://plus.google.com/share?url=<?php echo $page->url() ?>" class="popup">
                                        <span class="icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path d="M14.703,15.854l-1.219-0.948c-0.372-0.308-0.88-0.715-0.88-1.459c0-0.748,0.508-1.223,0.95-1.663
                                                            c1.42-1.119,2.839-2.309,2.839-4.817c0-2.58-1.621-3.937-2.399-4.581h2.097l2.202-1.383h-6.67c-1.83,0-4.467,0.433-6.398,2.027
                                                            C3.768,4.287,3.059,6.018,3.059,7.576c0,2.634,2.022,5.328,5.604,5.328c0.339,0,0.71-0.033,1.083-0.068
                                                            c-0.167,0.408-0.336,0.748-0.336,1.324c0,1.04,0.551,1.685,1.011,2.297c-1.524,0.104-4.37,0.273-6.467,1.562
                                                            c-1.998,1.188-2.605,2.916-2.605,4.137c0,2.512,2.358,4.84,7.289,4.84c5.822,0,8.904-3.223,8.904-6.41
                                                            c0.008-2.327-1.359-3.489-2.829-4.731H14.703z M10.269,11.951c-2.912,0-4.231-3.765-4.231-6.037c0-0.884,0.168-1.797,0.744-2.511
                                                            c0.543-0.679,1.489-1.12,2.372-1.12c2.807,0,4.256,3.798,4.256,6.242c0,0.612-0.067,1.694-0.845,2.478
                                                            c-0.537,0.55-1.438,0.948-2.295,0.951V11.951z M10.302,25.609c-3.621,0-5.957-1.732-5.957-4.142c0-2.408,2.165-3.223,2.911-3.492
                                                            c1.421-0.479,3.25-0.545,3.555-0.545c0.338,0,0.52,0,0.766,0.034c2.574,1.838,3.706,2.757,3.706,4.479
                                                            c-0.002,2.073-1.736,3.665-4.982,3.649L10.302,25.609z"/>
                                                        <polygon points="23.254,11.89 23.254,8.521 21.569,8.521 21.569,11.89 18.202,11.89 18.202,13.604 21.569,13.604 21.569,17.004
                                                            23.254,17.004 23.254,13.604 26.653,13.604 26.653,11.89      "/>
                                                    </g>
                                                </g>
                                            </svg>
                                        </span>
                                        <span class="text">google+</span>
                                    </a>
                                </li>

                                <li class="reddit">
                                    <a href="http://www.reddit.com/submit?url=<?php echo $page->url() ?>">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><g><path d="M11.794 15.316c0-1.029-0.835-1.895-1.866-1.895c-1.03 0-1.893 0.865-1.893 1.895s0.863 1.9 1.9 1.9 C10.958 17.2 11.8 16.3 11.8 15.316z"/><path d="M18.1 13.422c-1.029 0-1.895 0.864-1.895 1.895c0 1 0.9 1.9 1.9 1.865c1.031 0 1.869-0.836 1.869-1.865 C19.969 14.3 19.1 13.4 18.1 13.422z"/><path d="M17.527 19.791c-0.678 0.678-1.826 1.006-3.514 1.006c-0.004 0-0.009 0-0.014 0c-0.004 0-0.01 0-0.015 0 c-1.686 0-2.834-0.328-3.51-1.005c-0.264-0.265-0.693-0.265-0.958 0c-0.264 0.265-0.264 0.7 0 1 c0.943 0.9 2.4 1.4 4.5 1.402c0.005 0 0 0 0 0c0.005 0 0 0 0 0c2.066 0 3.527-0.459 4.47-1.402 c0.265-0.264 0.265-0.693 0.002-0.958C18.221 19.5 17.8 19.5 17.5 19.791z"/><path d="M27.707 13.267c0-1.785-1.453-3.237-3.236-3.237c-0.793 0-1.518 0.287-2.082 0.761c-2.039-1.295-4.646-2.069-7.438-2.219 l1.483-4.691l4.062 0.956c0.071 1.4 1.3 2.6 2.7 2.555c1.488 0 2.695-1.208 2.695-2.695C25.881 3.2 24.7 2 23.2 2 c-1.059 0-1.979 0.616-2.42 1.508l-4.633-1.091c-0.344-0.081-0.693 0.118-0.803 0.455l-1.793 5.7 C10.548 8.6 7.7 9.4 5.6 10.75C5.006 10.3 4.3 10 3.5 10.029c-1.785 0-3.237 1.452-3.237 3.2 c0 1.1 0.6 2.1 1.4 2.69c-0.04 0.272-0.061 0.551-0.061 0.831c0 2.3 1.3 4.4 3.7 5.9 c2.299 1.5 5.3 2.3 8.6 2.325c3.228 0 6.271-0.825 8.571-2.325c2.387-1.56 3.7-3.66 3.7-5.917 c0-0.26-0.016-0.514-0.051-0.768C27.088 15.5 27.7 14.4 27.7 13.267z M23.186 3.355c0.74 0 1.3 0.6 1.3 1.3 c0 0.738-0.6 1.34-1.34 1.34s-1.342-0.602-1.342-1.34C21.844 4 22.4 3.4 23.2 3.355z M1.648 13.3 c0-1.038 0.844-1.882 1.882-1.882c0.31 0 0.6 0.1 0.9 0.209c-1.049 0.868-1.813 1.861-2.26 2.9 C1.832 14.2 1.6 13.8 1.6 13.267z M21.773 21.57c-2.082 1.357-4.863 2.105-7.831 2.105c-2.967 0-5.747-0.748-7.828-2.105 c-1.991-1.301-3.088-3-3.088-4.782c0-1.784 1.097-3.484 3.088-4.784c2.081-1.358 4.861-2.106 7.828-2.106 c2.967 0 5.7 0.7 7.8 2.106c1.99 1.3 3.1 3 3.1 4.784C24.859 18.6 23.8 20.3 21.8 21.57z M25.787 14.6 c-0.432-1.084-1.191-2.095-2.244-2.977c0.273-0.156 0.59-0.245 0.928-0.245c1.035 0 1.9 0.8 1.9 1.9 C26.354 13.8 26.1 14.3 25.8 14.605z"/></g></svg>
                                        </span>
                                        <span class="text">reddit</span>
                                    </a>
                                </li>

                        <!--         <li class="github">
                                    <a href="https://github.com/kni-labs/rrssb">
                                        <span class="icon">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
                                            <path d="M13.971,1.571c-7.031,0-12.734,5.702-12.734,12.74c0,5.621,3.636,10.392,8.717,12.083c0.637,0.129,0.869-0.277,0.869-0.615
                                                c0-0.301-0.012-1.102-0.018-2.164c-3.542,0.77-4.29-1.707-4.29-1.707c-0.579-1.473-1.414-1.863-1.414-1.863
                                                c-1.155-0.791,0.088-0.775,0.088-0.775c1.277,0.104,1.96,1.316,1.96,1.312c1.136,1.936,2.991,1.393,3.713,1.059
                                                c0.116-0.822,0.445-1.383,0.81-1.703c-2.829-0.32-5.802-1.414-5.802-6.293c0-1.391,0.496-2.527,1.312-3.418
                                                C7.05,9.905,6.612,8.61,7.305,6.856c0,0,1.069-0.342,3.508,1.306c1.016-0.282,2.105-0.424,3.188-0.429
                                                c1.081,0,2.166,0.155,3.197,0.438c2.431-1.648,3.498-1.306,3.498-1.306c0.695,1.754,0.258,3.043,0.129,3.371
                                                c0.816,0.902,1.315,2.037,1.315,3.43c0,4.892-2.978,5.968-5.814,6.285c0.458,0.387,0.876,1.16,0.876,2.357
                                                c0,1.703-0.016,3.076-0.016,3.482c0,0.334,0.232,0.748,0.877,0.611c5.056-1.688,8.701-6.457,8.701-12.082
                                                C26.708,7.262,21.012,1.563,13.971,1.571L13.971,1.571z"/>
                                            </svg>
                                        </span>
                                        <span class="text">github</span>
                                    </a>
                                </li> -->
                            </ul>
                            <!-- Buttons end here -->
                        </div><!--//share-container-->



                        <nav class="post-nav col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                                <span class="nav-previous"><a href="#" rel="prev"><i class="fa fa-long-arrow-left"></i>Previous</a></span>
                                <span class="nav-next"><a href="#" rel="next">Next<i class="fa fa-long-arrow-right"></i></a></span>
                        </nav><!--//post-nav-->


                        <div id="comment-area" class="comment-area  col-md-8 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-1 col-xs-offset-0">
                                <!--//DISQUS script starts-->
                                <div id="disqus_thread"></div>
                                <script type="text/javascript">
                                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                                    var disqus_shortname = 'verveb'; // required: replace example with your forum shortname

                                    /* * * DON'T EDIT BELOW THIS LINE * * */
                                    (function() {
                                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                                <!--//DISQUS script ends-->

                        </div><!--//comment-area-->
                    </div><!--//row-->
                </div><!--//container-->
            </article><!--//post-->
        </div><!--//blog-entry-->
    </div><!--//blog-entry-wrapper-->
</div><!--//wrapper-->


<?php snippet('footer') ?>