<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CompanyDataRequest",
 *     required=true,
 *     description="Dados da empresa",
 *     @OA\JsonContent(
 *         required={"nif", "user_id"},
 *         @OA\Property(property="name", type="string", example="Empresa XPTO Ltda"),
 *         @OA\Property(property="nif", type="string", example="123456789"),
 *         @OA\Property(property="location", type="string", example="Luanda, Angola"),
 *         @OA\Property(property="certification", type="string", example="ISO 9001"),
 *         @OA\Property(property="user_id", type="string", example="abc123xyz")
 *     )
 * )
 */

class CompanyDataRequest extends FormRequest
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
            'nif' => 'required|string',
            'location' => 'nullable|string',
            'certification' => 'nullable|string',
            'user_id' => 'required',
        ];
    }
}
