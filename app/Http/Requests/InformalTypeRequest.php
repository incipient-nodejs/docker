<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="InformalTypeRequest",
 *     required=true,
 *     description="Informal type data",
 *     @OA\JsonContent(
 *         required={"nif", "user_id"},
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             nullable=true,
 *             example="John Doe",
 *             description="Informal entity name (optional)"
 *         ),
 *         @OA\Property(
 *             property="nif",
 *             type="string",
 *             example="123456789",
 *             description="Tax Identification Number (required)"
 *         ),
 *         @OA\Property(
 *             property="docs",
 *             type="string",
 *             nullable=true,
 *             example="doc1.pdf, doc2.pdf",
 *             description="Documents related to the entity (optional)"
 *         ),
 *         @OA\Property(
 *             property="website",
 *             type="string",
 *             nullable=true,
 *             example="https://example.com",
 *             description="Website URL (optional)"
 *         ),
 *         @OA\Property(
 *             property="whatsapp",
 *             type="string",
 *             nullable=true,
 *             example="+244912345678",
 *             description="WhatsApp number (optional)"
 *         ),
 *         @OA\Property(
 *             property="phone",
 *             type="string",
 *             nullable=true,
 *             example="+244922334455",
 *             description="Phone number (optional)"
 *         ),
 *         @OA\Property(
 *             property="offers",
 *             type="string",
 *             nullable=true,
 *             example="Free consultations on weekends",
 *             description="Available offers or promotions (optional)"
 *         ),
 *         @OA\Property(
 *             property="user_id",
 *             type="integer",
 *             example=1,
 *             description="User ID who is submitting the request (required)"
 *         )
 *     )
 * )
 */
class InformalTypeRequest extends FormRequest
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
            'name' => 'required',
            'nif' => 'required',
            // 'docs' => 'required',
            // 'website' => 'required',
            // 'whatsapp' => 'required',
            'contacto' => 'required',
            // 'offers' => 'required',
            'user_id' => 'required',
        ];
    }
}
