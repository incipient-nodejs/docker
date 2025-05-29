<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ProductRequest",
 *     required=true,
 *     description="Dados do produto",
 *     @OA\JsonContent(
 *         required={"name", "price"},
 *         @OA\Property(property="name", type="string", example="Cadeira Gamer"),
 *         @OA\Property(property="image", type="string", example="cadeira.jpg"),
 *         @OA\Property(property="video", type="string", example="video.mp4"),
 *         @OA\Property(property="description", type="string", example="Uma cadeira confortável e ergonômica."),
 *         @OA\Property(property="price", type="number", format="float", example=499.99),
 *         @OA\Property(property="promotion", type="boolean", example=true),
 *         @OA\Property(property="delivery", type="boolean", example=false),
 *         @OA\Property(property="user_id", type="integer", example=1),
 *         @OA\Property(property="category_id", type="integer", example=5)
 *     )
 * )
 */
class ProductRequest extends FormRequest
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
            'name' => 'required|string',
            'image' => 'nullable',
            'video' => 'nullable',
            'description' => 'nullable|string',
            'price' => 'required',
            'promotion' => 'nullable|boolean',
            'delivery' => 'nullable|boolean',
            'user_id' => 'nullable',
            'category_id' => 'nullable',
        ];
    }
}
