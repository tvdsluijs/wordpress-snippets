<?php
/**
 * @project     snippets
 * @name        WooCommerce Better Schema.org
 * @description Better Schema.org than standard Woocommerce schema
 * @author      Theo van der Sluijs ( theo@vandersluijs.nl )
 * @copyright   2017 Theo van der Sluijs
 * @license     All rights reserved
 * @file        woocommerce-schema-org.php
 * @date        08/08/2017
 * @time        14:32
 */

/**
 * Verwijder de standaard WooCommerce 3 JSON/LD structured data format
 * Remove the default WooCommerce 3 JSON/LD structured data format
 * With a little help of @remicorson
 */
function remove_woo_structured_data() {
    remove_action( 'wp_footer', array( WC()->structured_data, 'output_structured_data' ), 10 ); // Frontend pages
    remove_action( 'woocommerce_email_order_details', array( WC()->structured_data, 'output_email_structured_data' ), 30 ); // Emails
}
add_action( 'init', 'remove_woo_structured_data' );


/**
 * Set right schema in head! With a little help from a friend Tyler Longren & Martin [OctoInkjet]
 **/
function schema_org_markup() {
    $schema = 'http://schema.org/';
    // Is Woocommerce product
    if ( function_exists(is_woocommerce) && is_woocommerce() ) {
        $type = 'Product';
    }
    echo "itemscope='itemscope' itemtype='{ $schema . $type}'";
}

add_action('wp_head','hook_wooschemaorg');

function hook_wooschemaorg()
{
    global $post;


    if (is_product()) {
        $product = new WC_Product( get_the_ID() );
        $product_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' );
        $currency = get_woocommerce_currency();
        $dimensions_unit = strtolower( get_option( 'woocommerce_dimension_unit' ) );
        $weight_unit = strtolower( get_option( 'woocommerce_weight_unit' ) );

        $product_brand = null;
        $brands = wp_get_post_terms($post->ID, 'product_brand', array("fields" => "all"));
        if ($brands !== null && is_array($brands)) {
            foreach ($brands as $brand) {
                $product_brand = $brand->name;
                break;
            }
        }

        $category = null;
        $cats = get_the_terms($post->ID, 'product_cat');
        if ($cats !== null && is_array($cats)) {
            foreach ($cats as $cat) {
                $category = $cat->name;
                break;
            }
        }

        $desc = null;
        if ($product->get_short_description() !== null && $product->get_short_description() !== '') {
            $desc = wp_strip_all_tags($product->get_short_description());
        } elseif ($product->get_description() !== null && $product->get_description() !== '') {
            $desc = wp_strip_all_tags($product->get_description());
        }

        $price = null;
        if ($product->is_on_sale()) {
            if ($product->get_sale_price() !== null) {
                $price = $product->get_sale_price();
            }else{
                $price = $product->get_sale_price();
            }
        }

        $avail = "http://schema.org/InStock";
        if($product->get_stock_status() !== null && $product->get_stock_status() !== ''){
            switch($product->get_stock_status()){
                case 'instock':
                    $avail = "http://schema.org/InStock";
                    break;
//                case '':
//                    $avail = "http://schema.org/Discontinued";
//                    break;
                case 'outofstock':
                    $avail = "http://schema.org/OutOfStock";
                    break;
//                case '':
//                    $avail = "http://schema.org/SoldOut";
//                    break;
                default:
                    $avail = "http://schema.org/InStock";
                    break;
            }
        }

        $avg_rating = null;
        $count_rating = null;
        if($product->get_average_rating() !== null && $product->get_average_rating() !== '' && $product->get_average_rating() > 0){
            $avg_rating = $product->get_average_rating();
            $count_rating = $product->get_rating_count();
        }

        $output = "";
        $output .= "<!-- This part is generated by a snippet you can find on http://vandersluijs.nl -->\n";
        $output .= "<script type=\"application/ld+json\">";

        $var['@context'] = 'http://schema.org/';
        $var['@type'] = 'Product';
        if ($product->get_name() !== null) {
            $var['name'] = $product->get_name();
        }
        if (isset($product_image) && $product_image !== null) {
            $var['image'] = $product_image;
        }

        if(isset($desc) && $desc !==''){
            $var['description'] = $desc;
        }

        if ($product->get_permalink() !== null) {
            $var['url'] = $product->get_permalink();
        }

        if(isset($product_brand) && $product_brand !=='') {
            $var['brand']['@type'] = 'Thing';
            $var['brand']['name'] = $product_brand;
        }

        $cart_url = $product->add_to_cart_url() . "?add-to-cart={$post->ID}";
        if(isset($price) && $price !== '') {
            $var['offers']['@type'] = 'Offer';
            $var['offers']['priceCurrency'] = $currency;
            $var['offers']['price'] = $price;
            $var['offers']['url'] = $cart_url;
            $var['offers']['availability'] = $avail;
        }

        if ($product->get_weight() !== null && $product->get_weight() !== '') {
            $var['weight']['@context'] = 'https://schema.org';
            $var['weight']['@type'] = 'QuantitativeValue';
            $var['weight']['value'] = $product->get_weight();
            $var['weight']['unitCode'] = $weight_unit;;
        }

        if ($product->get_width() !== null && $product->get_width() !== '') {
            $var['width']['@context'] = 'https://schema.org';
            $var['width']['@type'] = 'QuantitativeValue';
            $var['width']['value'] = $product->get_width();
            $var['width']['unitCode'] = $dimensions_unit;
        }

        if ($product->get_height() !== null && $product->get_height() !== '') {
            $var['height']['@context'] = 'https://schema.org';
            $var['height']['@type'] = 'QuantitativeValue';
            $var['height']['value'] = $product->get_height();
            $var['height']['unitCode'] = $dimensions_unit;
        }

        if ($product->get_length() !== null && $product->get_length() !== '') {
            $var['depth']['@context'] = 'https://schema.org';
            $var['depth']['@type'] = 'QuantitativeValue';
            $var['depth']['value'] = $product->get_length();
            $var['depth']['unitCode'] = $dimensions_unit;;
        }

        if ($product->get_sku() !== null && $product->get_sku() !== '') {
            $var['sku'] = $product->get_sku();
        }

        if(isset($category) && $category !== '') {
            $var['category'] = $category;
        }

        if(isset($avg_rating) && $avg_rating !== '') {
            $var['AggregateRating']['@context'] = 'https://schema.org';
            $var['AggregateRating']['@type'] = 'AggregateRating';
            $var['AggregateRating']['ratingvalue'] = $avg_rating;
            $var['AggregateRating']['ratingcount'] = $count_rating;
//            $var['AggregateRating']['worstrating'] = $avg_rating;
//            $var['AggregateRating']['bestrating'] = $avg_rating;
//            $var['AggregateRating']['reviewcount'] = $avg_rating;
        }

        $json = json_encode($var);

        $output .= $json;
        $output .= "</script>";
        echo $output;
    }
}

/**
 * https://wpsso.com/docs/plugins/wpsso-schema-json-ld/notes/markup-examples/markup-example-for-a-woocommerce-product/

<script type="application/ld+json">
{
"@context": "http://schema.org/",
"@type": "Product",
"name": "Yoast SEO for WordPress",
"image": "https://cdn-images.yoast.com/uploads/2010/10/Yoast_SEO_WP_plugin_FB.png",
"description": "Yoast SEO is the most complete WordPress SEO plugin. It handles the technical optimization of your site & assists with optimizing your content.",
"brand": {
"@type": "Thing",
"name": "Yoast"
},
"offers": {
"@type": "Offer",
"priceCurrency": "USD",
"price": "69.00"
}
}
</script>

AggregateRating
Review

Color
Item Condition
GTIN (including gtin8, gtin12, gtin13, gtin14) Global Trade Identification Numbers
Related Products
Upsell Products
Dimensions (height, width, length including mapping to universal unitCodes)
Weight (includes mapping to universal unitCodes)
Offer Variations (Each product variation is mapped to unique Offers)
ALL Custom Attribute Properties to additionalProperty
 *
 *
 * add_action(‘woocommerce_after_single_product_summary’, create_function( ‘$args’, ‘call_user_func(\’comments_template\’);’), 14);
 **/