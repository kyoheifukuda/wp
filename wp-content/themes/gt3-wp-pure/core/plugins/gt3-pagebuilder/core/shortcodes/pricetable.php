<?php

class pricetable
{

    public function register_shortcode($shortcodeName)
    {
        function shortcode_pricetable($atts, $content = null)
        {

            $compile = '';

            extract(shortcode_atts(array(
                'heading_alignment' => 'left',
                'heading_size' => $GLOBALS["pbconfig"]['default_heading_in_module'],
                'heading_color' => '',
                'heading_text' => '',
                'price_items_number' => '1',
            ), $atts));

            #heading
            if (strlen($heading_color) > 0) {
                $custom_color = "color:#{$heading_color};";
            }
            if (strlen($heading_text) > 0) {
                $compile .= "<div class='bg_title'><" . $heading_size . " style='" . (isset($custom_color) ? $custom_color : '') . ((strlen($heading_alignment) > 0 && $heading_alignment !== 'left') ? 'text-align:'.$heading_alignment.';' : '') . "' class='headInModule'>{$heading_text}</" . $heading_size . "></div>";
            }

            $compile .= '<div class="module_price_table price_table_wrapper clearfix">' . do_shortcode($content) . '</div>';

            return $compile;

        }

        add_shortcode($shortcodeName, 'shortcode_pricetable');
    }
}

#Shortcode name
$shortcodeName = "pricetable";
$shortcode_pricetable = new pricetable();
$shortcode_pricetable->register_shortcode($shortcodeName);

#for pricetable_item
class pricetable_item
{
    public function register_shortcode($name)
    {
        function shortcode_pricetable_item($atts, $content = null)
        {
            extract(shortcode_atts(array(
                'block_link' => '',
                'get_it_now_caption' => '',
                'most_popular' => '',
                'price_features' => "",
                'block_price' => "",
                'block_name' => "",
                'block_period' => "",
                'width' => "",
            ), $atts));

            $price_features = explode("||-||", $price_features);

            $compile = '';

            $compile .= '
                <div class="price_item '.($most_popular == "yes" ? 'most_popular' : '').'" style="width:' . $width . '%;">
                    <div class="price_item_wrapper">
						<div class="price_item_title"><h5>' . $block_name . '</h5></div>
						<div class="price_item_body">
							<div class="item_cost_wrapper">
								<div class="price_item_cost">
									<span class="currprice">' . $block_price . '</span>
									<span class="currperiod">' . $block_period . '</span>
								</div>
								<div class="price_ico_default"></div>
							</div><!-- .item_cost_wrapper -->';

            if (isset($price_features) && is_array($price_features)) {
                foreach ($price_features as $value) {
                    $compile .= '<div class="price_item_text">'.$value.'</div>';
                }
            }

$compile .= '<div class="price_item_btn">'.do_shortcode('[custom_button style="btn_normal btn_type3" icon="" target="_self" href="'.$block_link.'"]'.$get_it_now_caption.'[/custom_button]').'</div>
						</div>
                    </div>
                </div>
            ';

            return $compile;

        }
        add_shortcode($name, 'shortcode_pricetable_item');
    }
}

$pricetable_item = new pricetable_item();
$pricetable_item->register_shortcode("pricetable_item");

?>