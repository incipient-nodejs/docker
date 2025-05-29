<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\GridSetting;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/grid-settings")
 *
 * @OA\Tag(name="Grid settings", description="Operations related to grid settings")
 */
class GridSettingController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Grid settings"},
     *     path="/api/v1/grid-settings",
     *     summary="List grid settings",
     *     description="Display listing of the resource",
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return response()->json(GridSetting::all(), 200);
    }

    /**
     * @OA\Get(
     *     tags={"Grid settings"},
     *     path="/api/v1/grid-settings/{id}",
     *     summary="Show account grid settings by ID",
     *     description="Display a listing by ID",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="Search by ID",
     *      @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($id)
    {
        $setting = GridSetting::find($id);
        if (!$setting) {
            return response()->json(['message' => 'Configuração não encontrada'], 404);
        }
        return response()->json($setting, 200);
    }

    /**
     * @OA\Post(
     *     tags={"Grid settings"},
     *     path="/api/v1/grid-settings",
     *     summary="Save account grid settings",
     *     description="Creates and returns a new grid settings",
     *     @OA\RequestBody(ref="#/components/requestBodies/GridSettingsRequest"),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'cross_axis_count' => 'integer',
            'child_aspect_ratio' => 'numeric',
            'main_axis_spacing' => 'integer',
            'cross_axis_spacing' => 'integer',
        ]);

        $setting = GridSetting::create($request->all());
        return response()->json($setting, 201);
    }

    /**
     * @OA\Put(
     *     tags={"Grid settings"},
     *     path="/api/v1/grid-settings/{id}",
     *     summary="Update account grid settings",
     *     description="Update the specified resource in storage",
     *     @OA\Parameter(
     *      name="id", in="path", required=true, description="Search by ID", @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/GridSettingsRequest"),
     *     @OA\Response(response=201, description="Category updated successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * ),
     */
    public function update(Request $request, $id)
    {
        $setting = GridSetting::find($id);
        if (!$setting) {
            return response()->json(['message' => 'Configuração não encontrada'], 404);
        }

        $setting->update($request->all());
        return response()->json($setting, 200);
    }

    /**
     * @OA\Delete(
     *     tags={"Grid settings"},
     *     path="/api/v1/grid-settings/{id}",
     *     summary="Remove the specified resource from storage",
     *     description="Delete account grid settings",
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
    public function destroy($id)
    {
        $setting = GridSetting::find($id);
        if (!$setting) {
            return response()->json(['message' => 'Configuração não encontrada'], 404);
        }

        $setting->delete();
        return response()->json(['message' => 'Configuração removida'], 200);
    }
}
