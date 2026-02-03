<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\ServiceProduct;
class ProductsController extends Controller{
    private ServiceProduct $service;
    public function __construct(ServiceProduct $service){
        $this->service=$service;
    }
    
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Obtener lista de productos",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
    
     *     @OA\Response(response=200, description="Operación exitosa"),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     * )
     */

    public function getProducts(){
        return response()->json($this->service->getAll());
    }

        /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obtener producto por ID",
     *     tags={"Products/id"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Operación exitosa"),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     * )
     */

    public function getProduct(int $id){
        $product=$this->service->getById($id);
        if (!$product){
            return response()->json(['message'=>'Producto no encontrado'], 404);
        }
        return response()->json($product);
    }
    
    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crear nuevo producto",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","description", "tax_cost","manufacturing_cost","price","currency"},  
     *                  @OA\Property(property="name", type="string", example="Producto 1"),
     *                  @OA\Property(property="description", type="string", example="Descripción del producto 1"),
     *                  @OA\Property(property="tax_cost", type="number", format="float", example="15.5"),
     *                  @OA\Property(property="manufacturing_cost", type="number", format="float", example="50.0"),
     *                  @OA\Property(property="price",type="object",required={"value"},
     *                      @OA\Property(property="value", type="number", format="float", example=750)),
     *                  @OA\Property(property="currency", type="object",
     *                      required={"id","name","symbol","exchange_rate"},
     *                      @OA\Property(property="id", type="integer", example="1"),
     *                      @OA\Property(property="name", type="string", example="US Dollar"),
     *                      @OA\Property(property="symbol", type="string", example="$"),
     *                      @OA\Property(property="exchange_rate", type="number", format="float", example=1.0)
     *                  )  
     *          )
     *      ),
     *          @OA\Response(
 *         response=201,
 *         description="Producto creado exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=10),
 *             @OA\Property(property="name", type="string", example="Laptop X"),
 *             @OA\Property(property="price", type="object",
 *                 @OA\Property(property="value", type="number", example=750)
 *             ),
 *             @OA\Property(property="currency", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="USD")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, description="Datos inválidos"),
 *     @OA\Response(response=401, description="No autorizado")

     * )
     */

    public function newProduct(Request $request){
        $data=$request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'tax_cost'=>'required|numeric',
            'manufacturing_cost'=>'required|numeric',
            'price.value'=>'required|numeric',
            'currency.id'=>'required|integer',
            'currency.name'=>'required|string',
            'currency.symbol'=>'required|string',
            'currency.exchange_rate'=>'required|numeric' ]);
        $product=$this->service->create($data);
        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Actualizar un producto",
     *     tags={"Products/id"},
     *     security={{"bearerAuth":{}}},
     *    @OA\Parameter( name="id", in="path", required=true, description="ID del producto existente",
     *      @OA\Schema(type="integer") ),
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *         required={"name","description", "tax_cost","manufacturing_cost","price","currency"},
     *         @OA\Property(property="name", type="string", example="Producto sustituto"),
     *         @OA\Property(property="description", type="string", example="Descripción actualizada del producto"),
     *         @OA\Property(property="tax_cost", type="number", format="float", example="555.0"),
     *         @OA\Property(property="manufacturing_cost", type="number", format="float", example="9999.0"),
     *         @OA\Property(property="price",type="object",required={"value"},
     *            @OA\Property(property="value", type="number", format="float", example=999999.99) ),
     *        @OA\Property(property="currency", type="object",
     *          @OA\Property(property="id", type="integer", example="1"),
     *          @OA\Property(property="name", type="string",example="US Dollar"),
     *          @OA\Property(property="symbol",type="string",example="$"),
     *          @OA\Property(property="exchange_rate",type="number",format="float",example=1.0) )
     *      )
     *    ),  
     *     @OA\Response(response=200, description="Actualizción exitosa", 
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Producto actualizado exitosamente")
     *      )
     *     ),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     * )
     */



    public function updateProduct(Request $request,int $id){
        $data=$request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'tax_cost'=>'required|numeric',
            'manufacturing_cost'=>'required|numeric',
            'price.value'=>'required|numeric',
            'currency.id'=>'required|integer',
            'currency.name'=>'required|string',
            'currency.symbol'=>'required|string',
            'currency.exchange_rate'=>'required|numeric']);
        $product=$this->service->update($id,$data);
        return response()->json($product);
    }
    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Borrar producto por ID",
     *     tags={"Products/id"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Operación exitosa"),
     *     @OA\Response(response=400, description="Solicitud incorrecta"),
     * )
     */

    public function deleteProduct(int $id){
        $this->service->delete($id);
        return response()->json(null, 204);
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}/prices",
     *     summary="Crear nuevo precio para un producto",
     *     tags={"Products/id/prices"},
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *        name="id",
     *        in="path",
     *        required=true,
     *        description="ID del producto",
     *       @OA\Schema(type="integer")
     *    ),
     *   @OA\RequestBody(
     *       required=true,
     *      @OA\JsonContent(
     *         @OA\Property(property="price", type="object",
     *           @OA\Property(property="value", type="number", format="float", example=77777.77) ),
     *         @OA\Property(property="currency", type="object",
     *           @OA\Property(property="id", type="integer", example=1),
     *           @OA\Property(property="name", type="string", example="US Dollar"),
     *           @OA\Property(property="symbol", type="string", example="$"),
     *           @OA\Property(property="exchange_rate", type="number", format="float", example=1.0) )
     *       ) 
     *      ),
     *     @OA\Response(response=200, description="Precio nuevo agregado exitosamente"),
     *     @OA\Response(response=400, description="No se pudo agregar el nuevo precio"),
     * )
     */

    public function newPriceProduct(Request $request,int $id)
    {
        $data=$request->validate([
            'price.value'=>'required|numeric',
            'currency.id'=>'required|integer',
            'currency.name'=>'required|string',
            'currency.symbol'=>'required|string',
            'currency.exchange_rate'=>'required|numeric']);
        $this->service->addPrice($id,$data);
        return response()->json(['message'=>'nuevo precio agregado'], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}/prices",
     *     summary="Obtener lista de precios de un producto",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Lista de precios obtenida exitosamente"),
     *     @OA\Response(response=404, description="Producto no encontrado")
     * )
     */
    public function getProductPrices($id){
        return response()->json($this->service->getPricesByProduct($id));
    }
}
