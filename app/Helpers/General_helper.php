<?php

if (!function_exists('format_currency')) {
    /**
     * Formats a numeric value as currency with euro symbol.
     * 
     * This function takes a numeric value and formats it as currency with two decimal places
     * and the euro symbol. For example, it formats "10.5" as "10,50€".
     * 
     * @param float $value The numeric value to format as currency.
     * 
     * @return string The formatted currency string.
     */
    function format_currency($value)
    {
        return number_format($value, 2, ',') . '€';
    }
}

if (!function_exists('define_order_number_from_last_order_number')) {
    /**
     * Defines the order number or series from the order number.
     * 
     * This function calculates the order number or series based on the given order number. If the order number is less than 100,
     * the function returns the order number itself. If the order number is 100 or greater, the function returns the result of 
     * taking the order number modulo 100, effectively extracting the last two digits of the order number.
     * 
     * @param int $order_number The number representing the order.
     * 
     * @return int The order number or series derived from the given order number.
     */
    function define_order_number_from_last_order_number($order_number)
    {
        if ($order_number < 100) {
            return $order_number;
        } else {
            return $order_number % 100;
        }
    }
}

if (!function_exists('lead_zeros')) {
    /**
     * Adds leading zeros to a numeric value to match a specified length.
     * 
     * This function pads the provided numeric value with leading zeros to match the specified length. 
     * If the length of the numeric value is already equal to or greater than the specified length, 
     * the function returns the original value without any modifications.
     * 
     * @param int|string $value The numeric value to pad with leading zeros.
     * @param int $length The desired length of the resulting padded value.
     * 
     * @return string The value padded with leading zeros.
     */
    function lead_zeros($value, $length)
    {
        return str_pad($value, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('order_color')) {
    /**
     * Determines the color associated with an order based on its order number.
     * 
     * This function calculates the color for a given order number by using the modulo operation. 
     * The order number modulo 10 is used to select a color from the `ORDER_COLORS` array.
     * 
     * @param int $order_number The number of the order.
     * 
     * @return string The color associated with the given order number.
     */
    function order_color($order_number)
    {
        return ORDER_COLORS[$order_number % 10];
    }
}
