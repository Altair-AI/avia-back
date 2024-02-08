<?php

namespace App\Http\Controllers\Swagger;

use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     title="Avia-back API",
 *     version="1.2.6",
 *     description="Дата обновления: 08.02.2024"
 * ),
 *
 * @OA\PathItem(
 *     path="/api/"
 * ),
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *     ),
 * ),
 */
class MainController extends Controller
{
    //
}
