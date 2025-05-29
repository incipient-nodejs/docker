<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="ServiceRequest",
 *     required=true,
 *     description="Dados do serviço",
 *     @OA\JsonContent(
 *         required={"name"},
 *         @OA\Property(property="name", type="string", example="Consultoria em Marketing"),
 *         @OA\Property(property="image", type="string", example="servico.jpg"),
 *         @OA\Property(property="video", type="string", example="apresentacao.mp4"),
 *         @OA\Property(property="description", type="string", example="Descrição completa do serviço."),
 *         @OA\Property(property="user_id", type="string", example="1"),
 *         @OA\Property(property="category_id", type="string", example="2")
 *     )
 * )
 */
class ServiceRequest extends FormRequest
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
            'user_id' => 'nullable|string',
            'category_id' => 'nullable|string',
        ];
    }
}
