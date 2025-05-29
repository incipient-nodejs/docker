<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="PersonalDataRequest",
 *     required=true,
 *     description="Personal data payload",
 *     @OA\JsonContent(
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             nullable=true,
 *             example="John"
 *         ),
 *         @OA\Property(
 *             property="full_name",
 *             type="string",
 *             nullable=true,
 *             example="John Doe"
 *         ),
 *         @OA\Property(
 *             property="nif_bi",
 *             type="string",
 *             nullable=true,
 *             example="003456789LA012"
 *         ),
 *         @OA\Property(
 *             property="phone",
 *             type="string",
 *             nullable=true,
 *             example="+244923456789"
 *         ),
 *         @OA\Property(
 *             property="image",
 *             type="string",
 *             nullable=true,
 *             example="https://example.com/profile.jpg"
 *         ),
 *         @OA\Property(
 *             property="user_id",
 *             type="integer",
 *             example=1,
 *             description="ID of the associated user (required)"
 *         )
 *     )
 * )
 */
class PersonalDataRequest extends FormRequest
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
            'full_name' => 'nullable|string',
            'nif_bi' => 'nullable|string',
            'phone' => 'nullable|string',
            'image' => 'nullable|string',
            'user_id' => 'required',
        ];
    }
}
