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
                        <span class="subheading">お前誰だ的なね</span>
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
            <p>2013年の8月に制作会社にインターンしたことがきっかけで制作に興味を持つ。（なんもできない状態）</p>
            <p>2014年から独学で勉強を始め制作会社でのアルバイトを始める（html,cssかけるくらい）</p>
            <p>2015年からベンチャー企業でインターンを始める(wordpress少し使えるくらい)</p>
            <p>今はフロントエンドでの開発に興味があり、Jquery,Javascriptを勉強中です（いまここ）</p>
            <p>今は自分自身チームでの開発が初めてなのでRuby on Railsの最低限のことや、Githubでひぎぃってなってます。</p>
            <p>ウェブのことをやるまではバンドをしていました。頭はすこし弱いですが、物を作ることが大好きです！よろしくです。</p>
            </div>
        </div>
    </div>

    <hr>
<?php get_footer(); ?>
