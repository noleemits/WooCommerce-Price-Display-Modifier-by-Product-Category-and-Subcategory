<?php 

add_filter('woocommerce_get_price_html', 'custom_fabric_price_display', 10, 2);
function custom_fabric_price_display($price, $product) {
    // Get all categories for the product
    $categories = wp_get_post_terms($product->get_id(), 'product_cat');

    // Define the target categories with parent-child format
    $target_categories = array('fabric', 'notions>webbing/strapping');

    // Parse the target categories correctly
    $parsed_target_categories = [];
    foreach ($target_categories as $entry) {
        $parts = explode('>', $entry); // Split parent>child
        if (count($parts) === 2) {
            $parsed_target_categories[] = [
                'parent' => strtolower($parts[0]), // Do not replace characters here
                'child' => strtolower($parts[1]),
            ];
        } else {
            $parsed_target_categories[] = [
                'parent' => strtolower($parts[0]),
                'child' => null,
            ];
        }
    }

    // Pre-fetch all categories with parent-child relationships
    $all_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
    ));
    $category_map = [];
    foreach ($all_categories as $cat) {
        $category_map[$cat->term_id] = [
            'name' => strtolower($cat->name),
            'parent' => $cat->parent,
        ];
    }

    // Helper function to check if a category matches parent>child rules
    $is_category_in_target = function ($category, $parsed_target_categories, $category_map) {
        foreach ($parsed_target_categories as $rule) {
            // If only parent is specified, match any category with this parent
            if ($rule['child'] === null) {
                if ($category_map[$category]['name'] === $rule['parent']) {
                    return true;
                }
            } else {
                // Match both parent and child
                $parent = $category_map[$category]['parent'];
                if (
                    $category_map[$category]['name'] === $rule['child'] &&
                    isset($category_map[$parent]) &&
                    $category_map[$parent]['name'] === $rule['parent']
                ) {
                    return true;
                }
            }
        }
        return false;
    };

    // Check if the product belongs to any of the target categories
    $is_target_category = false;
    foreach ($categories as $category) {
        if ($is_category_in_target($category->term_id, $parsed_target_categories, $category_map)) {
            $is_target_category = true;
            break;
        }
    }

    // If the product is in the target categories, modify the price display
    if ($is_target_category) {
        // Get the product price as a number
        $price_value = floatval($product->get_price());

        // Calculate the price for the full meter
        $full_meter_price = number_format($price_value * 2, 2);

        // Modify the price display
        $price .= ' PER 1/2 METER';
        $price .= '<br><small>($' . $full_meter_price . ' PER METER)</small>';
    }

    return $price;
}
