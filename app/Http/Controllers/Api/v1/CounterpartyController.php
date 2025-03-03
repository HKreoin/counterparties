<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\Counterparty\CreateCounterpartyDTO;
use App\Http\Controllers\Controller;
use App\Services\CounterpartyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class CounterpartyController extends Controller
{
    public function __construct(private CounterpartyService $counterpartyService)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/counterparties",
     *     summary="Create a new counterparty",
     *     tags={"Counterparties"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"inn"},
     *             @OA\Property(property="inn", type="string", example="7707083893"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Counterparty created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="inn", type="string", example="7707083893"),
     *             @OA\Property(property="name", type="string", example="ПАО СБЕРБАНК"),
     *             @OA\Property(property="ogrn", type="string", example="1027700132195"),
     *             @OA\Property(property="address", type="string", example="г Москва, ул Вавилова, д 19"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time"),
     *         )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthorized"),
     *          )
     *      ),
     *     @OA\Response(
     *          response=409,
     *          description="Conflict. Counterparty with this INN already exists.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Counterparty with this INN already exists.")
     *          )
     *      ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *     )
     * )
     */
    public function store(CreateCounterpartyDTO $data): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        try {
            if ($this->counterpartyService->counterpartyExists($data->inn)) {
                return response()->json([
                    'message' => 'Counterparty with this INN already exists.',
                ], 409);
            }
            $counterparty = $this->counterpartyService->createCounterparty(auth()->user(), $data);
            return response()->json($counterparty, 201);
        } catch (Exception $e) {
            Log::error('Failed to create counterparty', [
                'error' => $e->getMessage(),
                'inn' => $data->inn,
            ]);

            return response()->json([
                'message' => 'Failed to create counterparty: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/counterparties",
     *     summary="Get all counterparties for the authenticated user",
     *     tags={"Counterparties"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of counterparties",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="inn", type="string", example="7707083893"),
     *                 @OA\Property(property="name", type="string", example="ПАО СБЕРБАНК"),
     *                 @OA\Property(property="ogrn", type="string", example="1027700132195"),
     *                 @OA\Property(property="address", type="string", example="г Москва, ул Вавилова, д 19"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *           @OA\JsonContent(
     *               @OA\Property(property="message", type="string", example="Unauthorized"),
     *           )
     *      ),
     * )
     */
    public function index(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $counterparties = $this->counterpartyService->getUserCounterparties(auth()->user());
        return response()->json($counterparties);
    }
}
