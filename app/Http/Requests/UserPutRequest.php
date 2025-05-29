<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UserPutRequest",
 *     required=true,
 *     description="User data",
 *     @OA\JsonContent(
 *         required={"name", "phone", "password", "confirmed"},
 *         @OA\Property(property="name", type="string", example="João Silva"),
 *         @OA\Property(property="email", type="string", format="email", example="joao@email.com"),
 *         @OA\Property(property="phone", type="string", example="912345678"),
 *         @OA\Property(property="gender", type="string", example="Masculino"),
 *         @OA\Property(property="address", type="string", example="Rua ABC, nº 123"),
 *         @OA\Property(property="image", type="string", example="perfil.jpg"),
 *         @OA\Property(property="birthday", type="string", example="1990-05-20")
 *     )
 * )
 */
class UserPutRequest extends FormRequest
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
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'image'  => 'nullable|string',
            'birthday'  => 'nullable|string',
        ];
    }
}
