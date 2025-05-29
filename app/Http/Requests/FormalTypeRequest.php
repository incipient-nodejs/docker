<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="FormalTypeRequest",
 *     required=true,
 *     description="Formal type data",
 *     @OA\JsonContent(
 *         required={"nif", "user_id"},
 *         @OA\Property(
 *             property="name",
 *             type="string",
 *             nullable=true,
 *             example="Company XYZ",
 *             description="Formal name (optional)"
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
 *             description="Associated documents (optional)"
 *         ),
 *         @OA\Property(
 *             property="website",
 *             type="string",
 *             format="url",
 *             nullable=true,
 *             example="https://example.com",
 *             description="Company website URL (optional)"
 *         ),
 *         @OA\Property(
 *             property="whatsapp",
 *             type="string",
 *             nullable=true,
 *             example="+244900000000",
 *             description="WhatsApp number (optional)"
 *         ),
 *         @OA\Property(
 *             property="phone",
 *             type="string",
 *             nullable=true,
 *             example="+244912345678",
 *             description="Phone number (optional)"
 *         ),
 *         @OA\Property(
 *             property="offers",
 *             type="string",
 *             nullable=true,
 *             example="Discount on services",
 *             description="Details of available offers (optional)"
 *         ),
 *         @OA\Property(
 *             property="user_id",
 *             type="integer",
 *             example=1,
 *             description="User ID (required)"
 *         )
 *     )
 * )
 */
class FormalTypeRequest extends FormRequest
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
            'docs' => 'required',
            // 'website' => 'required|url',
            // 'whatsapp' => 'required',
            'contacto' => 'required',
            // 'offers' => 'required|string',
            'user_id' => 'required',
        ];
    }
}
