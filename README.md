# README — API de Productos Begento

## Resumen / Propósito
Se realizó una **API RESTful** utilizando **Laravel** version 10+ cuya finalidad es la gestión de productos con las características que se detallan a continuación. La API devuelve datos en **formato JSON** y utiliza **Eloquent** para interactuar con la base de datos, está documentada con Swagger y con Postman

---

## Requisitos funcionales (tal como los diste)
- La API permite **crear, leer, actualizar y eliminar** productos.
- Cada producto tiene : **nombre**, **descripción**, **precio**, **costo de impuestos** y **costo de fabricación**.
- La API permite **registrar precios** de los productos en **diferentes divisas**.
- La API regresa datos en  **formato JSON**.
- La API utiliza **Eloquent** para interactuar con la base de datos.

---

## Modelo de datos 

### Productos
| Campo              | Tipo     | Descripción                         |
|-------------------:|---------:|-------------------------------------|
| id                 | integer  | Identificador único del producto    |
| name               | string   | Nombre del producto                 |
| description        | string   | Descripción del producto            |
| price              | decimal  | Precio del producto en la divisa base |
| currency_id        | integer  | Identificador de la divisa base     |
| tax_cost           | decimal  | Costo de impuestos del producto     |
| manufacturing_cost | decimal  | Costo de fabricación del producto   |

### Divisas
| Campo        | Tipo    | Descripción                 |
|-------------:|--------:|-----------------------------|
| id           | integer | Identificador único de la divisa |
| name         | string  | Nombre de la divisa         |
| symbol       | string  | Símbolo de la divisa        |
| exchange_rate| decimal | Tasa de cambio de la divisa |

### Precios de productos
| Campo       | Tipo    | Descripción                                |
|------------:|--------:|--------------------------------------------|
| id          | integer | Identificador único del precio del producto|
| product_id  | integer | Identificador del producto                 |
| currency_id | integer | Identificador de la divisa                 |
| price       | decimal | Precio del producto en la divisa especificada |

---

## Endpoints

Lista original requerida:
- `GET /products` — Obtener lista de productos
- `POST /products` — Crear un nuevo producto
- `GET /products/{id}` — Obtener un producto por ID
- `PUT /products/{id}` — Actualizar un producto
- `DELETE /products/{id}` — Eliminar un producto
- `GET /products/{id}/prices` — Obtener lista de precios de un producto
- `POST /products/{id}/prices` — Crear un nuevo precio para un producto

Rutas implementadas en `api.php` con un autorización con un middleware 

```
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum', 'apiroutes:manage-products'])->group(function () {
    Route::get("/products", [ProductsController::class, 'getProducts'])->name('getProducts');
    Route::get("/products/{id}", [ProductsController::class, 'getProduct'])->name('getProduct');
    Route::get("/products/{id}/prices", [ProductsController::class, 'getProductPrices'])->name('getProductPrices');
    Route::post('/products', [ProductsController::class, 'newProduct'])->name('newProduct');
    Route::post('/products/{id}/prices', [ProductsController::class, 'newPriceProduct'])->name('newPriceProduct');
    Route::put('/products/{id}', [ProductsController::class, 'updateProduct'])->name('updateProduct');
    Route::delete('/products/{id}', [ProductsController::class, 'deleteProduct'])->name('deleteProduct');
});
```

---

## Autenticación
- Existe un `AuthController` cuyo endpoint expuesto es `POST/login`.
- Las credenciales **que mencionaste** para pruebas son:
  - **Email:** `test@example.com`
  - **Password:** `:password`
- Comentario: **el seeder** genera varios usuarios pero **todos tienen la misma contraseña**.

---

## Middleware de autorización
Proporcionaste el middleware que valida si el usuario tiene el ability requerido. El middleware está en `App\Http\Middleware` y la clase que mostraste es `TokenApi`:

```
class TokenApi
{
    public function handle(Request $request, Closure $next, $ability)
    {
        $user = $request->user();
        if (!$user || ! $user->tokenCan($ability)){
            return response()->json(['mensage' => 'Petición sin autorización '.$ability], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
```
## Arquitectura
- Implementé una **arquitectura DDD** con capas/áreas para `product`, `currency`, `prices`.
- Los endpoints apuntan a un **ProductsController** que usa un **Service** 
- El **Service** consume una **interfaz**.
- El **repositorio** con la clase `DBProduct` que **implementa** `InterfaceProduct` se encarga de utilizar los datos de los modelos para realizar las acciones definidas en la interfaz.
---

## Migraciones / Datos iniciales
-  **Agregué migraciones** para `product`, `currency`, `prices` para comenzar a poblar datos.
- **Dejé** por defecto dejaste la base de datos Laravel y utilicé **Laragon** con la configuración de `app_url` como `http://begento-test.test`.

---

## Tecnologías / Versiones / Paquetes mencionados
- **PHP:** `8.5.2` 
- **Laravel:** `10.5` 
- **Swagger:** instalaste `darkaonline/l5-swagger:^8.6` y `swagger-api/swagger-ui` 


