# WooCommerce Price Display Modifier by Product Category

This code snippet allows you to customize the price display of WooCommerce products based on their categories or subcategories. It is particularly useful for situations where you want to display additional pricing information (e.g., unit prices) for specific products.

## Features

- Modify WooCommerce product price display based on product categories.
- Support for parent-child category relationships using the `>` syntax.
- Dynamically fetches and evaluates product categories and their hierarchy.
- Designed to integrate seamlessly into your WordPress theme or custom plugin.

## Installation

1. **Add the Code**:
   - Copy the provided PHP snippet and paste it into your WordPress theme's `functions.php` file or a custom plugin.

2. **Define Target Categories**:
   - Locate the `\$target_categories` array in the code. Add your categories in the following formats:
     - **Parent Category Only**: `fabric`
     - **Parent and Child Category**: `notions>webbing/strapping`

   Example:
   ```php
   $target_categories = array('fabric', 'notions>webbing/strapping');
   ```

3. **Save Changes**:
   - Save the file and refresh your WooCommerce site to see the modified price display.

## Usage Instructions

### Specifying Categories
- **Parent Category Only**:
  - If you want the price display modification to apply to all products within a parent category, specify only the parent category name.
  - Example: `fabric`

- **Parent and Child Category**:
  - If you want the modification to apply to products within a specific child category, specify the parent and child category names separated by `>`.
  - Example: `notions>webbing/strapping`

### How the Code Works
1. The code retrieves the categories assigned to each product.
2. It checks whether the product belongs to any of the specified categories in the `\$target_categories` array.
3. If a match is found, the price display is modified to include additional information, such as a unit price per meter.

### Example Modifications
- For a product in the `notions>webbing/strapping` category, the price display will be updated to include text such as:
  - `\$10 PER 1/2 METER`
  - `<small>($20 PER METER)</small>`

### Customization
- **Changing the Price Display Format**:
  - Locate the following lines in the code:
    ```php
    $price .= ' PER 1/2 METER';
    $price .= '<br><small>($' . $full_meter_price . ' PER METER)</small>';
    ```
  - Modify these lines to change the appended text.

- **Adding More Categories**:
  - Update the `\$target_categories` array to include additional categories or subcategories.

## Troubleshooting

1. **Changes Not Reflected**:
   - Clear your WordPress and WooCommerce caches.
   - Ensure that the category names and hierarchy match your WooCommerce setup.

2. **Code Errors**:
   - Ensure the code is pasted correctly in your `functions.php` file or custom plugin.
   - Use an IDE or text editor to check for syntax issues.

3. **Debugging**:
   - If modifications don’t appear as expected, re-enable the debug logs in the code by adding `var_dump` or `echo` statements where needed.

## Compatibility

- **WooCommerce**: Tested with version 5.0 and above.
- **WordPress**: Compatible with WordPress 5.8 and above.

## Disclaimer
Make sure to test this code in a staging environment before deploying it to a live site. This ensures compatibility with your specific WordPress setup and WooCommerce version.

