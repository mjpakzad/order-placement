<?php

namespace Modules\Order\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'shipping_method' => 'required|in:post,tipax,chapar',
        ];
    }
}
