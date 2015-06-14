<?php

class shortcode_title
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_title($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => 'h3',
                'heading_color' => '',
            ), $atts));

            if (strlen($heading_color) > 0) {
                $custom_color = "color:#" . $heading_color . ";";
            }

            return "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:' . $heading_alignment . ';' : '') . "' class='headInModule'>" . $content . "</" . $heading_size . "></div>";
        }

        add_shortcode($shortcodeName, 'shortcode_title');
    }
}

$shortcodeName = "title";
$shortcode_title = new shortcode_title();
$shortcode_title->register_shortcode($shortcodeName);

?>