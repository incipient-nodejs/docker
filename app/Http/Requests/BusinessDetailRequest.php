<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="BusinessDetailRequest",
 *     required=true,
 *     description="Payload para criação ou atualização de um Business Detail",
 *     @OA\JsonContent(
 *         required={"user_id"},
 *         @OA\Property(property="name", type="string", example="Loja XPTO"),
 *         @OA\Property(property="phone_preference", type="string", example="mobile"),
 *         @OA\Property(property="phone", type="string", example="+244923000000"),
 *         @OA\Property(property="whatsapp", type="string", example="+244923000000"),
 *         @OA\Property(property="email", type="string", example="empresa@email.com"),
 *         @OA\Property(property="website_url", type="string", example="https://www.empresa.com"),
 *         @OA\Property(property="is_sell_product", type="boolean", example=true),
 *         @OA\Property(property="user_id", type="string", example="123e4567-e89b-12d3-a456-426614174000")
 *     )
 * )
 */
class BusinessDetailRequest extends FormRequest
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
            'name' => 'nullable|string',
            'phone_preference' => 'nullable|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'email' => 'nullable|string',
            'website_url' => 'nullable|string',
            'is_sell_product' => 'nullable|boolean',
            'user_id' => 'required|string',
        ];
    }
}
