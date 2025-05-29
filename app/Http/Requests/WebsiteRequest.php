<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="WebsiteRequest",
 *     required=true,
 *     description="Website creation or update data",
 *     @OA\JsonContent(
 *         required={"url", "shop_type", "is_integration_api", "business_detail_id"},
 *         @OA\Property(
 *             property="url",
 *             type="string",
 *             example="https://example.com",
 *             description="URL of the website"
 *         ),
 *         @OA\Property(
 *             property="shop_type",
 *             type="string",
 *             example="ecommerce",
 *             description="Type of the shop"
 *         ),
 *         @OA\Property(
 *             property="is_integration_api",
 *             type="boolean",
 *             example=true,
 *             description="Indicates if the website integrates via API"
 *         ),
 *         @OA\Property(
 *             property="business_detail_id",
 *             type="string",
 *             example="bd_12345",
 *             description="ID that refers to the business details"
 *         )
 *     )
 * )
 */
class WebsiteRequest extends FormRequest
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
            'url' => 'required|string',
            'shop_type' => 'required|string',
            'is_integration_api' => 'required|boolean',
            'business_detail_id' => 'required|string',
        ];
    }
}
