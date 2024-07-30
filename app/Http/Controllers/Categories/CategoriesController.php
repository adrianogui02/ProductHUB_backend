<?php

namespace App\Http\Controllers\Categories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    use ResponseTrait;

    public $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @OA\GET(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="Get Category List",
     *     description="Get Category List as Array",
     *     operationId="getCategoryList",
     *     security={{"bearer":{}}},
     *     @OA\Response(response=200, description="Get Category List as Array"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->categoryRepository->getAll();
            return $this->responseSuccess($data, 'Category List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/categories/view/all",
     *     tags={"Categories"},
     *     summary="All Categories - Publicly Accessible",
     *     description="All Categories - Publicly Accessible",
     *     operationId="getAllCategories",
     *     @OA\Response(response=200, description="All Categories - Publicly Accessible"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function indexAll(): JsonResponse
    {
        try {
            $categories = Category::all();
            return $this->responseSuccess($categories, 'Category List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\POST(
     *     path="/api/categories",
     *     tags={"Categories"},
     *     summary="Create New Category",
     *     description="Create New Category",
     *     operationId="createCategory",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Category 1"),
     *          ),
     *      ),
     *      security={{"bearer":{}}},
     *      @OA\Response(response=200, description="Create New Category"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $category = $this->categoryRepository->create($request->all());
            return $this->responseSuccess($category, 'New Category Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\GET(
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     summary="Show Category Details",
     *     description="Show Category Details",
     *     operationId="getCategoryDetails",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Category Details"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $category = Category::find($id);
            if (is_null($category)) {
                return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseSuccess($category, 'Category Details Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\PUT(
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     summary="Update Category",
     *     description="Update Category",
     *     operationId="updateCategory",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="name", type="string", example="Category 1"),
     *          ),
     *      ),
     *     @OA\Response(response=200, description="Update Category"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(CategoryRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->all();
            $category = $this->categoryRepository->update($id, $data);
            if (is_null($category)) {
                return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);
            }
            return $this->responseSuccess($category, 'Category Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\DELETE(
     *     path="/api/categories/{id}",
     *     tags={"Categories"},
     *     summary="Delete Category",
     *     description="Delete Category",
     *     operationId="deleteCategory",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Delete Category"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $category = Category::find($id);
            if (is_null($category)) {
                return $this->responseError(null, 'Category Not Found', Response::HTTP_NOT_FOUND);
            }
            $category->delete();
            return $this->responseSuccess($category, 'Category Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
