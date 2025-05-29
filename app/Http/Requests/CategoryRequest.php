<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CategoryRequest",
 *     required=true,
 *     description="Dados da categoria",
 *     @OA\JsonContent(
 *         required={"name"},
 *         @OA\Property(property="name", type="string", example="Tecnologia"),
 *         @OA\Property(property="type", type="string", enum={"service", "product"}, example="service"),
 *         @OA\Property(property="code", type="string", example="TEC001"),
 *         @OA\Property(property="description", type="string", example="Categoria relacionada a serviços de tecnologia."),
 *         @OA\Property(
 *             property="icon",
 *             type="string",
 *             format="binary",
 *             description="Imagem do ícone da categoria (máx: 1MB)"
 *         )
 *     )
 * )
 */
class CategoryRequest extends FormRequest
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
            'type' => 'in:service,product',
            'code' => 'nullable',
            'description' => 'nullable',
            'icon' => [
                'nullable',
                'image',
                'max:1024'
            ],
        ];
    }
}
