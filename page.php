<?php get_header(); ?>
<div class="ttl">
    <div class="img"><img src="<?php echo esc_url(get_theme_file_uri('images/logo.png')); ?>" alt="コークス"></div>
    請求書閲覧システム
</div>
<body>
<?php if(have_posts()){
    the_post();
    the_content();
} ?>
<?php if( is_user_logged_in() ) : ?>
<p><a href="<?php echo esc_url(home_url('profile')); ?>">ユーザーページへ</a></p>
<?php endif; ?>

<?php get_footer(); ?>
