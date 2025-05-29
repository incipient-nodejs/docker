<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="UserRequest",
 *     required=true,
 *     description="User data for creation or update, including optional image upload",
 *     @OA\MediaType(
 *         mediaType="multipart/form-data",
 *         @OA\Schema(
 *             required={"name", "phone", "password", "confirmed"},
 *             @OA\Property(property="name", type="string", example="João Silva", description="User's full name"),
 *             @OA\Property(property="email", type="string", format="email", example="joao@email.com", description="User's email address"),
 *             @OA\Property(property="password", type="string", example="123456", description="User's password"),
 *             @OA\Property(property="confirmed", type="string", example="123456", description="Password confirmation"),
 *             @OA\Property(property="phone", type="string", example="912345678", description="User's phone number"),
 *             @OA\Property(property="gender", type="string", example="Male", description="User's gender"),
 *             @OA\Property(property="address", type="string", example="123 ABC Street", description="User's address"),
 *             @OA\Property(
 *                 property="image",
 *                 type="string",
 *                 format="binary",
 *                 description="Profile image file upload"
 *             ),
 *             @OA\Property(property="birthday", type="string", example="1990-05-20", description="User's birth date (YYYY-MM-DD)")
 *         )
 *     )
 * )
 */
class UserRequest extends FormRequest
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
            'password' => 'nullable|string',
            'phone' => 'required|string',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
            'image'  => 'nullable|string',
            'birthday'  => 'nullable|string',
        ];
    }
}
