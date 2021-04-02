<?php 

/* ADD FONTS OPEN SANS TINYMCE */

add_filter( 'tiny_mce_before_init', 'tcbcom_mce_google_fonts_array' );
function tcbcom_mce_google_fonts_array( $initArray ) {
    // Google Web Fonts
    $theme_advanced_fonts = 'Open Sans=Open Sans;';
    //Default fonts for TinyMCE
    $theme_advanced_fonts .= 'Andale Mono=Andale Mono, Times;';
    $theme_advanced_fonts .= 'Arial=Arial, Helvetica, sans-serif;';
    
    $theme_advanced_fonts .= 'Arial Black=Arial Black, Avant Garde;';
    $theme_advanced_fonts .= 'Book Antiqua=Book Antiqua, Palatino;';
    $theme_advanced_fonts .= 'Comic Sans MS=Comic Sans MS, sans-serif;';
    $theme_advanced_fonts .= 'Courier New=Courier New, Courier;';
    
    $theme_advanced_fonts .= 'Georgia=Georgia, Palatino;';
    $theme_advanced_fonts .= 'Helvetica=Helvetica;';
    $theme_advanced_fonts .= 'Impact=Impact, Chicago;';
    $theme_advanced_fonts .= 'Symbol=Symbol;';
    $theme_advanced_fonts .= 'Tahoma=Tahoma, Arial, Helvetica, sans-serif;';
    $theme_advanced_fonts .= 'Terminal=Terminal, Monaco;';
    $theme_advanced_fonts .= 'Times New Roman=Times New Roman, Times;';
    $theme_advanced_fonts .= 'Trebuchet MS=Trebuchet MS, Geneva;';
    $theme_advanced_fonts .= 'Verdana=Verdana, Geneva;';
    $initArray['font_formats'] = $theme_advanced_fonts;
    return $initArray;
}

add_action( 'admin_init', 'tcbcom_mce_google_fonts_styles' );
function tcbcom_mce_google_fonts_styles() {
   $font = 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic)';
   add_editor_style( str_replace( ',', '%2C', $font ) );
}

add_action('admin_head-post.php', function() {
    ?>
    <style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans);
    </style>
    <?php
});

function tcbcom_set_default_fonts_editor_styles() {
    add_editor_style( 'css/tinymce_custom_editor.css' );
}
add_action( 'after_setup_theme', 'tcbcom_set_default_fonts_editor_styles' );

/* END ADD FONTS OPEN SANS TINYMCE */