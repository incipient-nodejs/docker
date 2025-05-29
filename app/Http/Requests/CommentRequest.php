<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CommentRequest",
 *     required=true,
 *     description="Dados de um comentário enviado pelo usuário",
 *     @OA\JsonContent(
 *         required={"name", "phone", "feedback", "send_data"},
 *         @OA\Property(property="name", type="string", example="João da Silva"),
 *         @OA\Property(property="phone", type="string", example="+244923123456"),
 *         @OA\Property(property="feedback", type="string", example="Gostei muito do serviço!"),
 *         @OA\Property(property="send_data", type="string", format="date-time", example="2025-04-21T15:00:00Z")
 *     )
 * )
 */
class CommentRequest extends FormRequest
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
            'name' => 'string|required',
            'phone' => 'string|required',
            'feedback' => 'string|required',
            'send_data' => 'string|required',
        ];
    }
}
