<?php get_header(); ?>
<body>

<?php if(have_posts()){
    the_post();
    the_content();
} ?>
<?php if( is_user_logged_in() ) : ?>
<p><a href="<?php echo esc_url(home_url('profile')); ?>">ユーザーページへ</a></p>
<?php endif; ?>

<?php get_footer(); ?>

