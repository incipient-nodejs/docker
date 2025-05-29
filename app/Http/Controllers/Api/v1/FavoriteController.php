<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Service;

/**
 * @OA\PathItem(path="/api/v1/favorites")
 *
 * @OA\Tag(name="Favorites", description="Operations related to favorites")
 */
class FavoriteController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Favorites"},
     *     path="/api/v1/favorites/search/{id}",
     *     summary="Show favorite by ID of user",
     *     description="Display a listing by ID of user",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by ID of user",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function getFavorites($userid)
    {
        try {
            $favorite = Favorite::where('user_id', $userid)->first();
            if (!$favorite) {
                return response()->json(
                    [
                        'haveError' => true,
                        'message' => 'não existem favoritos',
                    ],
                    200
                );
            }
            $favorites = Favorite::with(['product','product.category' ,'service','service.category','product.user.companyData','service.user.companyData'])
                ->where('user_id', $userid)
                ->get();

            $result = [
                'products' => $favorites->pluck('product')->filter()->values(),
                'services' => $favorites->pluck('service')->filter()->values(),
                'users' => $favorites->pluck('service')->filter()->values(),
            ];

            return response()->json(
                [
                    'haveError' => false,
                    'message' => 'Sucesso',
                    'products' => $result['products'] ?? [],
                    'services' => $result['services'] ?? [],
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'Erro ao buscar Favoritos : ' . $th->getMessage(),
                    'haveError' => true,
                ],
                500
            );
        }
    }

 /**
 * @OA\Post(
 *     path="/api/v1/favorites/store",
 *     tags={"Favorites"},
 *     summary="Save favorite",
 *     description="Creates and returns a new favorite",
 *     @OA\RequestBody(
 *         description="Relationship between user, product, and service",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id"},
 *             @OA\Property(
 *                 property="user_id",
 *                 type="integer",
 *                 example=1,
 *                 description="User ID (must exist in the users table)"
 *             ),
 *             @OA\Property(
 *                 property="product_id",
 *                 type="integer",
 *                 nullable=true,
 *                 example=10,
 *                 description="Product ID (optional, must exist in the products table)"
 *             ),
 *             @OA\Property(
 *                 property="service_id",
 *                 type="integer",
 *                 nullable=true,
 *                 example=5,
 *                 description="Service ID (optional, must exist in the services table)"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Favorite created successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid data"
 *     )
 * )
 */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'nullable|integer|exists:products,id',
            'service_id' => 'nullable|integer|exists:services,id',
        ];

        $messages = [
            'user_id.required' => 'O ID do usuário é obrigatório',
            'user_id.exists' => 'Usuário não encontrado',
            'product_id.exists' => 'Produto não encontrado',
            'service_id.exists' => 'Serviço não encontrado',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Erro de validação',
                    'haveError' => true,
                ],
                400
            );
        }

        if (empty($request->product_id) && empty($request->service_id)) {
            return response()->json(
                [
                    'message' => 'Informe pelo menos um produto ou serviço',
                    'haveError' => true,
                ],
                400
            );
        }
        try {
            $existingFavorite = Favorite::where('user_id', $request->user_id)
                ->where(function ($query) use ($request) {
                    if ($request->product_id) {
                        $query->where('product_id', $request->product_id);
                    }
                    if ($request->service_id) {
                        $query->orWhere('service_id', $request->service_id);
                    }
                })
                ->first();
            if ($existingFavorite) {
                $itemType = $existingFavorite->product_id ? 'produto' : 'serviço';
                $clear = $existingFavorite->delete();
                return response()->json(
                    [
                        'message' => "Este $itemType já está nos seus favoritos",
                        'haveError' => true,
                        'existingFavorite' => $existingFavorite,
                    ],
                    409
                );
            }
            $favorite = Favorite::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'service_id' => $request->service_id,
                'uuid' => Str::uuid()->toString(),
            ]);
            $favorite->load(['product', 'service']);
            return response()->json(
                [
                    'message' => 'Item adicionado aos favoritos com sucesso',
                    'favorite' => $favorite,
                    'haveError' => false,
                ],
                201
            );
        } catch (\Throwable $th) {
            \Log::error('Erro ao salvar favorito: ' . $th->getMessage());
            return response()->json(
                [
                    'message' => 'Falha ao salvar favorito',
                    'haveError' => true,
                    'error' => config('app.debug') ? $th->getMessage() : null,
                ],
                500
            );
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Favorites"},
     *     path="/api/v1/favorites/delete/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete favorite",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Delete by ID",
     *      @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy(Request $request, $item_id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|integer|exists:users,id',
                'item_type' => 'required|in:product,service',
            ],
            [
                'user_id.required' => 'O ID do usuário é obrigatório',
                'user_id.exists' => 'Usuário não encontrado',
                'item_type.required' => 'O tipo de item é obrigatório',
                'item_type.in' => 'O tipo deve ser "product" ou "service"',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'message' => 'Erro de validação dos dados',
                    'haveError' => true,
                ],
                400
            );
        }
        try {
            $column = $request->item_type == 'product' ? 'product_id' : 'service_id';
            $favorite = Favorite::where('user_id', $request->user_id)->where($column, $item_id)->first();
            if (!$favorite) {
                return response()->json(
                    [
                        'message' => 'Item não encontrado nos favoritos do usuário',
                        'haveError' => true,
                    ],
                    404
                );
            }
            $result = $favorite->delete();
            if ($result) {
                return response()->json(
                    [
                        'message' => 'Item removido dos favoritos com sucesso',
                        'haveError' => false,
                    ],
                    200
                );
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao remover favorito: ' . $e->getMessage());
            return response()->json(
                [
                    'message' => 'Ocorreu um erro ao processar sua solicitação',
                    'haveError' => true,
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ],
                500
            );
        }
    }
}
