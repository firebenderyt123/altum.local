<?php

add_action( 'init', 'acf_sessions_block_admin' );
function acf_sessions_block_admin() {
   wp_register_script('acf-sessions-block-js',
      get_template_directory_uri() . '/blocks/acf-sessions-block/block.js',
      array( 'wp-blocks', 'wp-element' )
   );

   register_block_type('custom/acf-sessions-block', array(
         'editor_script' => 'acf-sessions-block-js',
         'render_callback' => 'get_acf_sessions'
      )
   );
}

function get_acf_sessions() {
   $sessions = get_field('sessions');

   if (!$sessions) return '';

   $out = '<div class="sessions-block">
      <h2 class="sessions-title">Sessions</h2>
      <div class="sessions-list">';
      foreach ($sessions as $session) {
         $out .= '<p><a href="' . get_permalink($session->ID) . '">' . get_the_title($session->ID) . '</a></p>';
      }
      
   $out .= '</div></div>';

   return $out;
}