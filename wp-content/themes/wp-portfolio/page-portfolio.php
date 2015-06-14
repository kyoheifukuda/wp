<?php
/*
Template Name:portfolio
*/
?>

<?php get_header(); ?>

<body>
<?php get_sidebar(); ?>
    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/portfolio-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Portfolio</h1>
                        <hr class="small">
                        <span class="subheading">個人的に作ってきたものたち</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Post Content -->
        <div id="container" class="js-masonry" style="margin: 0 auto;">
                <div class="item">
                    <h2 class="portfolio-head">HOW TO MAKE AEAROPRESS METHOD</h2>
                    <p>2014年度のエアロプレス世界大会(WAC)で日本人初のチャンピオンに輝いた佐々木修一バリスタ(Paul Bassett 新宿店 所属)から、<br>
                    大会で使用したチャンピオンレシピを紹介する動画のBGMを作らせていただきました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/gc2.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">KOTOBA SELECT</h2>
                    <p>ライブの写真の撮影レタッチを担当しています。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/kotoba.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">FEET OFF THE FLOOR</h2>
                    <p>クラブイベントのスペシャルページとしてinstagramとTwitterで#FOF1223と付けたハッシュタグをこちらのページで表示させるページを作りました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/kotoba2.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">Sheep#6~</h2>
                    <p>毎月渋谷で開催されるディスコイベントの写真の撮影レタッチを担当しています。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/sheep.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">Good Coffee PUBLIC CUPPING</h2>
                    <p>Good Coffeeのプロモーションムービーの楽曲を提供させて頂きました。作曲、各楽器の演奏を行いました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/gc1.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">Set Lip</h2>
                    <p>飲食店のメニューを作りました、写真の撮影を行い加工しデザインの提案、印刷を行いました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/setlip.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">Modern Ballet Bell</h2>
                    <p>2014/01にHTMLサイトを作りその後、写真の撮影を行いCMSサイトへ更新しました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/bell.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">三門広敬</h2>
                    <p>シンガーソングライター三門広敬さんのフライヤーを作らせて頂きました。</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/mikadosan.png" class="img-responsive">
                </div>
                <div class="item">
                    <h2 class="portfolio-head">前のポートフォリオ</h2>
                    <p>はじめに作ったポートフォリオです</p>
                    <img src="<?php echo get_template_directory_uri(); ?>/img/portfolio/kyouheiold.png" class="img-responsive">
                </div>
        </div>
    <hr>
<?php get_footer(); ?>
