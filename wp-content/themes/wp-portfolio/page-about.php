<?php
/*
Template Name:about
*/
?>
<?php get_header(); ?>

<body>
<?php get_sidebar(); ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/about-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>About Me</h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <h2 class="section-heading">福田 京平</h2>
                <p>2013年の8月に制作会社にインターンしたことがきっかけで制作に興味を持ち</p>
                <p>2014年から独学で勉強、制作会社でのアルバイトを始め、DTPや写真、HTMLなどを覚える</p>
                <p>2015年からweb,iosアプリケーションを開発しているスタートアップでインターンを始める。</p>
                <p>今はUX/UIデザインとクライアントサイドの開発に興味があります。</p>
            </div>
        </div>
    </div>

    <hr>
<?php get_footer(); ?>
