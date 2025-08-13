<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class CheckStock implements Rule
{
    /**
     * The quantity being requested for the product.
     *
     * @var int
     */
    protected $quantity;

    /**
     * Create a new rule instance.
     * We pass the requested quantity to the constructor.
     */
    public function __construct($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    /**
     * Determine if the validation rule passes.
     *
     * The `passes` method receives the attribute name ('cart.*.product_id')
     * and its value (the actual product_id from the cart).
     *
     * @param  string  $attribute
     * @param  mixed  $value  (This will be the product_id)
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Find the product by its UUID
        $product = Product::find($value);

        // If the product doesn't exist, this rule passes because the
        // 'exists:products,prdt_id' rule will catch it.
        if (!$product) {
            return true;
        }

        // The rule passes if the product's stock is sufficient.
        return $product->stock_quantity >= $this->quantity;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is not enough stock for one of the items in your cart.';
    }
}