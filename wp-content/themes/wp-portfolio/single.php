<?php get_header(); ?>

<body>
<?php get_sidebar(); ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Blog</h1>
                        <hr class="small">
                        <span class="subheading">成長日記的なね</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="post-preview">
                            <a href="<?php the_permalink(); ?>">
                                <h2 class="post-title">
                                    <?php the_title(); ?>
                                </h2>
                            </a>
                            <p class="post-meta">Posted by <a href="#">Start Bootstrap</a> on September 24, 2014</p>
                        </div>
                            <article>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-10">
                                            <?php the_content('Read on...'); ?>
                                        </div>
                                    </div>
                                </div>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
                <hr>
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="#">Older Posts &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>
<?php get_footer(); ?>