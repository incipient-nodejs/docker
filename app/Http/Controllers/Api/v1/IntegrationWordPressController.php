<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\Util\IntegrationService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/v1/integration-wordpress")
 *
 * @OA\Tag(name="Integration wordpress", description="Operations related to integration wordpress")
 */
class IntegrationWordPressController extends Controller
{
    private $fields;
    private $integrationService;

    function __construct(){
        $this->integrationService =  new IntegrationService();
        $this->fields = collect([
            ['name' => 'name', 'api_field' => 'PRODUCT_NAME',],
            ['name' => 'price', 'api_field' => 'PRODUCT_PRICE', ],
            ['name' => 'description', 'api_field' => 'PRODUCT_DESCRIPTION',],
            ['name' => 'image_url', 'api_field' => 'PRODUCT_PHOTO',],
        ]);
    }

    /**
     * @OA\Post(
     *     tags={"Integration wordpress"},
     *     path="/api/v1/integration-wordpress",
     *     summary="Save integration",
     *     description="Integration with api of Wordpress",
     *     @OA\RequestBody(
     *      required=true,
     *      description="URL registration payload",
     *      @OA\JsonContent(
     *         required={"url", "user_id"},
     *         @OA\Property(
     *             property="url",
     *             type="string",
     *             format="url",
     *             example="https://example.com",
     *             description="A valid URL"
     *         ),
     *         @OA\Property(
     *             property="user_id",
     *             type="integer",
     *             example=1,
     *             description="ID of the user making the request"
     *         )
     *     )
     * ),
     *     @OA\Response(response=201, description="Category created successfully"),
     *     @OA\Response(response=400, description="Invalid data")
     * )
     */
    public function create(Request $request){
        $request->validate(['url' => 'required|url', 'user_id' => 'required' ]);
        return $this->integrationService->request($request, $this->fields);
    }
}
