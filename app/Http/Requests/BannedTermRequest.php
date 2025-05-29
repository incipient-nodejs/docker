<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="BannedTermRequest",
 *     required=true,
 *     description="Texto proibido que será cadastrado",
 *     @OA\JsonContent(
 *         required={"text_en"},
 *         @OA\Property(property="text_en", type="string", example="badword")
 *     )
 * )
 */
class BannedTermRequest extends FormRequest
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
            'text_en' => 'required|string'
        ];
    }
}
