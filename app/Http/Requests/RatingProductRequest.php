<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="RatingProductRequest",
 *     required=true,
 *     description="Product rating payload",
 *     @OA\JsonContent(
 *         required={"user_id", "product_id", "value"},
 *         @OA\Property(
 *             property="user_id",
 *             type="integer",
 *             example=1,
 *             description="ID of the user"
 *         ),
 *         @OA\Property(
 *             property="product_id",
 *             type="integer",
 *             example=5,
 *             description="ID of the product"
 *         ),
 *         @OA\Property(
 *             property="value",
 *             type="number",
 *             format="float",
 *             example=4.5,
 *             description="Rating value"
 *         )
 *     )
 * )
 */
class RatingProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'product_id' => 'required',
            'value' => 'required',
        ];
    }
}
