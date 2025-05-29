<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="DeleteAccountRequest",
 *     description="Dados para solicitar exclusão de conta",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"user_id", "feedback"},
 *         @OA\Property(property="user_id", type="string", example="12345"),
 *         @OA\Property(property="name", type="string", nullable=true, example="João Silva"),
 *         @OA\Property(property="phone", type="string", nullable=true, example="+244912345678"),
 *         @OA\Property(property="feedback", type="string", example="Quero excluir minha conta porque..."),
 *     )
 * )
 */
class DeleteAccountRequest extends FormRequest
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
            'name' => 'nullable',
            'phone' => 'nullable',
            'feedback' => 'required',
        ];
    }
}
