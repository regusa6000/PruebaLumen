<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*Rutas de Productos*/
$router->get('/productos/{id}','ProductosController@index');
$router->get('/productos','ProductosController@principal');
$router->get('/productosError','ProductosController@tablaError');
$router->get('/productosOk','ProductosController@tablaOk');

//Rutas de Login
$router->post('/login','UserAdminController@login');
$router->post('/register','UserAdminController@register');

//Datos de Usuario
$router->get('datosEmail/{idUser}','UserAdminController@datosEmail');

//Rutas de Errores
$router->get('/errors/{id_product}/{id_image}/{id_ax}/{error}/{ok}','ErrorsController@insertError');
$router->get('/errorsVerify/{id_image}','ErrorsController@verify');
$router->get('/resultError','ErrorsController@resultError');
$router->get('/updateError/{id_image}','ErrorsController@updateActiveError');
$router->delete('/deleteError/{id_image}','ErrorsController@deleteError');

//Rutas de Oks
$router->get('/ok/{id_product}/{id_image}/{id_ax}/{error}/{ok}','OkController@insertOk');
$router->get('/okVerify/{id_image}','OkController@verifyOk');
$router->get('/resultOk','OkController@resultOk');
$router->get('/updateOk/{id_image}','OkController.php@updateActiveOk');
$router->delete('/deleteOk/{id_image}','OkController@deleteOk');

//Rutas de Pedidos
$router->get('/controlPedidosAlmacen','PedidosController@controlPedidosAlmacen');
$router->get('/controlPedidosPagados','PedidosController@controlPedidosPagados');
$router->get('/controlCategoriasVacias','PedidosController@controlCategoriasVacias');
$router->get('/controlPreCompras','PedidosController@controlPreCompras');

//Rutas de Control de Transportistas
$router->get('/controlTransportistas','PedidosController@controlTransportistas');
$router->get('/controlTransportistasName/{nameTransportista}','PedidosController@controlTransportistasName');
$router->get('/cargarComboName','PedidosController@cargarComboName');

//Rutas de Control de Stock
$router->get('/controlHistoricoStock/{ean13}','PedidosController@controlHistoricoStock');

//Rutas Noticias
$router->post('/noticia','PedidosController@registrarNoticias');
$router->get('/noticias','PedidosController@mostrarNoticias');
$router->get('/noticiasGeneral','PedidosController@monstrarTodasNoticias');
$router->delete('/eliminarNoticia/{id_noticia}','PedidosController@eliminarNoticia');
$router->put('/actualizarNoticia','PedidosController@actualizarNoticia');

$router->get('controlAliExpress','PedidosController@controlAliExpress');
$router->get('badgeAliExpress','PedidosController@badgeAliExpress');

//Rutas Mano a Mano
$router->get('/manoAmano','PedidosController@manoAmano');
$router->get('/manoAmano/{idProducto}','PedidosController@manoAmanoPorProducto');
$router->get('/manoAManoDivision','PedidosController@manoAmanoPorDivision');
$router->get('/manoAmanoPorPrimero','PedidosController@manoAmanoPorPrimero');
$router->get('/manoAmanoPorSegundo','PedidosController@manoAmanoPorSegundo');
$router->get('/manoAmanoPorTercero','PedidosController@manoAmanoPorTercero');
$router->get('manoAmanoPorCuarto','PedidosController@manoAmanoPorCuarto');
$router->get('manoAmanoPorSexto','PedidosController@manoAmanoPorSexto');
$router->get('manoAmanoPorSeptimo','PedidosController@manoAmanoPorSeptimo');


//Rutas de Gráficos
$router->get('/controlStockGraficoIdProducto/{ean13}','PedidosController@controlStockGraficoIdProducto');

//Rutas Makro
$router->get('/productosTotalesMakro','PedidosController@productosTotalesMakro');
$router->get('/offersPublicados','PedidosController@offersPublicados');
$router->get('/offerNoPublicados','PedidosController@offerNoPublicados');
$router->get('/offerPorIdProducto/{idProduct}','PedidosController@offerPorIdProducto');

//Rutas de Estadisticas
$router->get('/importeDeVentas','EstadisticasController@importeDeVentas');
$router->get('/importeDeVentasManoMano','EstadisticasController@manoMano');
$router->get('/importeDeVentasCarrefour','EstadisticasController@carrefour');
$router->get('/importeDeVentasAliExpress','EstadisticasController@aliExpress');
$router->get('/importeDeVentasAmazon','EstadisticasController@amazon');
$router->get('/importeDeVentasGroupon','EstadisticasController@groupon');
$router->get('/importeDeVentasEmbargos','EstadisticasController@embargos');
$router->get('/importeDeVentasMequedoUno','EstadisticasController@mequedoUno');
$router->get('/importeDeVentasFnac','EstadisticasController@fnac');
$router->get('/importeDeVentasWish','EstadisticasController@wish');
$router->get('/importeDeVentasMakro','EstadisticasController@makro');
$router->get('/importeDeVentasPcComponentes','EstadisticasController@pcComponentes');
$router->get('/importeDeVentasSprinter','EstadisticasController@sprinter');
$router->get('/importeDeVentasBulevip','EstadisticasController@bulevip');

//Rutas de Sumatorias Semanales
$router->get('/sumatoriaPorSemana','EstadisticasController@sumatoriaPorSemana');
$router->get('/sumatoriaOrion','EstadisticasController@sumatoriaOrion');
$router->get('/sumatoriaManoMano','EstadisticasController@sumatoriaManoMano');
$router->get('/sumatorioCarrefour','EstadisticasController@sumatorioCarrefour');
$router->get('/sumatorioAliExpress','EstadisticasController@sumatorioAliExpress');
$router->get('/sumatoriaAmazon','EstadisticasController@sumatoriaAmazon');
$router->get('/sumatorioGrupon','EstadisticasController@sumatorioGrupon');
$router->get('/sumatorioEmbargos','EstadisticasController@sumatorioEmbargos');
$router->get('/sumatorioMequedoUno','EstadisticasController@sumatorioMequedoUno');
$router->get('/sumatorioFnac','EstadisticasController@sumatorioFnac');
$router->get('/sumatorioWish','EstadisticasController@sumatorioWish');
$router->get('/sumatorioMakro','EstadisticasController@sumatorioMakro');
$router->get('/sumatorioPcComponenetes','EstadisticasController@sumatorioPcComponenetes');
$router->get('/sumatorioSprinter','EstadisticasController@sumatorioSprinter');
$router->get('/sumatorioBulevip','EstadisticasController@sumatorioBulevip');

//Rutas Badges
$router->get('/controlPedidosPagadosBadge','PedidosController@controlPedidosPagadosBadge');
$router->get('/controlCategoriasVaciasBadge','PedidosController@controlCategoriasVaciasContador');
$router->get('/controlManoManoBadge','PedidosController@manoAmanoPorDivisionBadge');
$router->get('/pedidosAlmacenBadge','PedidosController@pedidosAlmacenBadge');

//Imagenes
$router->get('/imagenes','PedidosController@imagenes');
$router->get('/imagenesName/{name}','PedidosController@imagenesName');
$router->get('/imagenesReference/{reference}','PedidosController@imagenesReference');

//Caracteristicas
$router->get('/caracteristicasName','PedidosController@categoriasName');
$router->get('/caracteristicasNamePorIdCategory/{idCategory}','PedidosController@categoriaNamePorIdCategory');
$router->get('/cambiarPosicionCaracteristica/{position}/{idCategory}/{idFeature}','PedidosController@cambiarPosition');

//Caracteristicas por Producto
$router->get('/categoriasProductosName','PedidosController@categoriasProductosName');
$router->get('/productosPorIdCategoria/{idCategoria}','PedidosController@productosPorIdCategoria');
$router->get('/actualizarPosicionProducto/{idCategoria}/{idProducto}/{posicion}','PedidosController@actualizarPosicionProducto');


//Categorias por meses
$router->get('/categoriasPorMeses','EstadisticasController@categoriasPorMeses');
$router->get('/categoriaIdPorMeses/{idCategory}','EstadisticasController@categoriaIdPorMeses');
$router->get('/categoriasGeneral','EstadisticasController@categoriasGeneral');
$router->get('/categoriasPorTiendas/{variable}','EstadisticasController@categoriasPorTiendas');
$router->get('/categoriaIdPorMesesPorTienda/{variableTienda}/{idCategory}','EstadisticasController@categoriaIdPorMesesPorTienda');


//Categorias por meses ORION91
$router->get('/categoriasPorTiendaOrion','EstadisticasController@categoriasPorTiendaOrion');
$router->get('categoriaPorTiendaOrionPorIdCategoria/{idCategory}','EstadisticasController@categoriaPorTiendaOrionPorIdCategoria');


//Categorias por meses WISH
$router->get('/categoriasPorTiendaWish','EstadisticasController@categoriasPorTiendaWish');
$router->get('/categoriaPorTiendaWishPorIdCategoria/{idCategory}','EstadisticasController@categoriaPorTiendaWishPorIdCategoria');


//Venta de Productos
$router->get('ventaProductos/{idProducto}/{fechaInicio}/{fechaFin}/{tienda}','EstadisticasController@ventaProductos');
$router->get('ventasSemanalesTiendas','EstadisticasController@ventasSemanales');

//Rango de precios de makro
$router->get('productosPublicadosMakro','RangosController@productosPublicadosMakro');
$router->get('listaDeRangosMakro/{ean13}','RangosController@listaDeRangosMakro');
$router->put('actualizarRango','RangosController@actualizarRango');
$router->get('buscarListado/{ean13}','RangosController@buscarListado');
$router->post('registrarRangoMakro','RangosController@registrarNuevoRango');
$router->delete('eliminarRango/{ean13}/{rango}','RangosController@eliminarRango');

//Rango de precios de Makro Select
$router->get('productosPublicadosMakroConRangoYConStock','RangosController@productosPublicadosMakroConRangoYConStock');
$router->get('productosPublicadosMakroConRangoYSinStock','RangosController@productosPublicadosMakroConRangoYSinStock');
$router->get('productosPublicadosMakroSinRangoYConStock','RangosController@productosPublicadosMakroSinRangoYConStock');
$router->get('productosPublicadosMakroSinRangoYSinStock','RangosController@productosPublicadosMakroSinRangoYSinStock');


//Funciones para combinados predeterminados sin stock
$router->get('CombinadospredeterminadosSinStock','EstadisticasController@CombinadospredeterminadosSinStock');
$router->get('CombinadospredeterminadosSinStockCount','EstadisticasController@CombinadospredeterminadosSinStockCount');

//Funciones Dashboard
$router->get('dashboardsTodos','PrevisionesController@dashboardsTodos');
$router->get('dashboardsAmazon','PrevisionesController@dashboardsAmazon');
$router->get('dashboardsAliExpress','PrevisionesController@dashboardsAliExpress');
$router->get('dashboardsOrion91','PrevisionesController@dashboardsOrion91');
$router->get('dashboardsMakro','PrevisionesController@dashboardsMakro');
$router->get('dashboardsManoMano','PrevisionesController@dashboardsManoMano');
$router->get('dashboardsGroupon','PrevisionesController@dashboardsGroupon');
$router->get('dashboardsMequedoUno','PrevisionesController@dashboardsMequedoUno');


//Funciones Top
$router->get('productosTop','PrevisionesController@productosTop');
$router->get('canalesTop','PrevisionesController@canalesTop');
$router->get('productosTopIncidenciasHoy','PrevisionesController@productosTopIncidenciasHoy');

//Funciones Previsiones de Incidencias
$router->get('previsionIncidencias','PrevisionesController@previsionIncidencias');

//Funciones categorias anuales por opciones
$router->get('categoriasPorOpciones/{idCategory}/{fechaInicio}/{fechaFin}/{opcion}','EstadisticasController@categoriasPorOpciones');


//Ping
$router->get('pruebaPing','PedidosController@pruebaPing');


//Prueba Json
$router->get('textoJson','PedidosController@textoJson');
$router->get('enviarMensaje','PedidosController@enviarMensaje');

//Roturas de Stock
$router->get('roturaStock','EstadisticasController@roturaStock');


//Alertas de Pagos
$router->get('pedidosFraccionados','PedidosController@pedidosFraccionados');
$router->get('badgePedidosFraccionados','PedidosController@badgePedidosFraccionados');


//Pedidos Sin Stock Makro
$router->get('pedidosSinStockMakro','PedidosController@pedidosSinStockMakro');
$router->get('badgepedidosSinStockMakro','PedidosController@badgepedidosSinStockMakro');

//Porcentaje de transportistas
$router->get('porcentajeTransportistas','EstadisticasController@porcentajeTransportistas');



//Prueba RangosMakro
$router->get('pruebaRangos','RangosController@pruebaRangos');
