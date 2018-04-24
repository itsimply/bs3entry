<?php
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bs3entry_widgets_init()  {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'bs3entry' ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', 'strapped' ),
    'before_widget' => '<section id="%1$s" class="panel panel-default widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<div class="panel-heading"><h3 class="panel-title widget-title">',
    'after_title'   => '</h3></div>',
  ) );
}
add_action( 'widgets_init', 'bs3entry_widgets_init' );