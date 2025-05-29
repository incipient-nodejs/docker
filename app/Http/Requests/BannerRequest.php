<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="BannerRequest",
 *     required=true,
 *     description="Dados do banner",
 *     @OA\JsonContent(
 *         required={"name", "imagem", "posicao_grupo", "posicao_interna"},
 *         @OA\Property(property="name", type="string", example="Banner de Verão"),
 *         @OA\Property(property="imagem", type="string", example="https://meusite.com/banners/banner-verao.jpg"),
 *         @OA\Property(property="posicao_tela", type="string", enum={"tudo", "servicos", "produtos"}, example="servicos"),
 *         @OA\Property(property="posicao_grupo", type="string", example="home"),
 *         @OA\Property(property="posicao_interna", type="string", example="topo"),
 *         @OA\Property(property="type", type="string", enum={"horizontal", "vertical"}, example="horizontal")
 *     )
 * )
 */
class BannerRequest extends FormRequest
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
            'imagem' => 'required|string',
            'posicao_tela' => 'nullable|in:tudo,servicos,produtos',
            'posicao_grupo' => 'required|string',
            'posicao_interna' => 'required|string',
            'type' => 'nullable|in:horizontal,vertical'
        ];
    }
}
