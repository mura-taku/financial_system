<?
function custom_theme_set_up(){
    //ヘッド内にフィードリンクを出力
    add_theme_support('automatic-feed-links');
    //タイトルタグを動的に出力
    add_theme_support('title-tag');
 
}
add_action('after_setup_theme','custom_theme_set_up');


//ログイン後のリダイレクト
function my_login_redirect( $redirect_to, $user_id ) {
	return home_url('profile');
}
add_filter( 'wpmem_login_redirect', 'my_login_redirect', 10, 2 );


//購読者がログイン時に管理バーを表示しない 
function my_function_admin_bar($content) {
    return ( current_user_can('subscriber') ) ? false : $content;
   }
   add_filter( 'show_admin_bar' , 'my_function_admin_bar');


   
   register_sidebar(array(
    'name'=>'ヘッダー',
    'before_widget' => '<div id="header-widget">',
    'after_widget' => '</div>',
    ));

    add_filter( 'wpmem_sb_login_args', 'my_sidebar_args' );
function my_sidebar_args( $args ) {
    $args = array(
		// ログインフォームのメッセージを変更
        'status_msg' => '<p>ふっかつの じゅもんを いれて ください</p>',
		
		// ログインボタンと「パスワードをお忘れですか？」のリンクを囲むdivを削除
		'buttons_before'  => '',
		'buttons_after'   => '',
		
		// 「パスワードをお忘れですか？」のリンクをfieldsetの外に出すため閉じタグを削除
		'fieldset_after'  => '',
    );
    return $args;
}


   // 「パスワードをお忘れですか」のリンクを変更
   
   add_filter( 'wpmem_sb_forgot_link_str', 'my_forgot_link_str' );
   function my_forgot_link_str( $str ) {
       global $user_login, $wpmem;
       return ' </fieldset><a href="' . add_query_arg( 'a', 'pwdreset', $wpmem->user_pages['profile'] ) . '" id="forgot_link">パスワードを わすれた おろかものは こちら　≫</a>';
   }