<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *     @OA\RequestBody(
 *      request="GridSettingsRequest",
 *      required=true,
 *      description="Grid configuration parameters",
 *      @OA\JsonContent(
 *         @OA\Property(
 *             property="cross_axis_count",
 *             type="integer",
 *             example=3,
 *             description="Number of items along the cross axis"
 *         ),
 *         @OA\Property(
 *             property="child_aspect_ratio",
 *             type="number",
 *             format="float",
 *             example=1.5,
 *             description="Aspect ratio of each child item"
 *         ),
 *         @OA\Property(
 *             property="main_axis_spacing",
 *             type="integer",
 *             example=10,
 *             description="Spacing along the main axis"
 *         ),
 *         @OA\Property(
 *             property="cross_axis_spacing",
 *             type="integer",
 *             example=8,
 *             description="Spacing along the cross axis"
 *         )
 *       )
 *     )
 */
class GridSettingsRequest extends FormRequest
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
            'full_name' => 'nullable|string',
            'nif_bi' => 'nullable|string',
            'phone' => 'nullable|string',
            'image' => 'nullable|string',
            'user_id' => 'required',
        ];
    }
}
