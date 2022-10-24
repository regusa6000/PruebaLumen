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
$router->get('manoAmanoPorOctavo','PedidosController@manoAmanoPorOctavo');


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

//Categorias por Producto
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
$router->get('ventasSemanalesTodasLasTiendas','EstadisticasController@ventasSemanalesTodasLasTiendas');

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
$router->get('productosTopIncidenciasMensual','PrevisionesController@productosTopIncidenciasMensual');

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

//Roturas Actuales
$router->get('roturasActuales','EstadisticasController@roturasActuales');


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


//
$router->get('categoriasRedireccionadas','ProductosController@categoriasRedireccionadas');
$router->get('countCategoriasRedireccionadas','ProductosController@countCategoriasRedireccionadas');


//Productos top entre fechas
$router->get('productosTopEntreFechas/{fechaInicio}/{fechaFin}','PrevisionesController@productosTopEntreFechas');
$router->get('productosTopUltimosDias','PrevisionesController@productosTopUltimosDias');


//Arbol de Categorias
$router->get('arbolCategorias','EstadisticasController@arbolCategorias');

//Opiniones
$router->get('listadoCanales','OpinionesController@listadoCanales');
$router->get('listadoGeneral','OpinionesController@listadoGeneral');
$router->get('baseTipoOpinion/{id}','OpinionesController@baseTipoOpinion');
$router->post('registrarPorcentaje','OpinionesController@registrarPorcentaje');
$router->put('actualizarPorcentaje','OpinionesController@actualizarPorcentaje');
$router->delete('eliminarPorcentaje/{idOpinionesTipo}','OpinionesController@eliminarPorcentaje');
$router->get('rellenarSelect','OpinionesController@rellenarSelect');
$router->get('cargarGrafico/{id}','OpinionesController@cargarGrafico');

//Zonas
$router->get('cargarZonas','ZonasController@cargarZonas');
$router->get('cargarLinksPorZonas/{idZona}','ZonasController@cargarLinksPorZonas');
$router->post('crearNuevaZona','ZonasController@crearNuevaZona');
$router->put('actualizarDatosZona','ZonasController@actualizarDatosZona');
$router->get('cargarLinks','ZonasController@cargarLinks');
$router->get('cargarSelectZonas','ZonasController@cargarSelectZonas');
$router->post('crearNuevoLink','ZonasController@crearNuevoLink');
$router->put('actualizarLink','ZonasController@actualizarLink');
$router->delete('eliminarLink/{idLink}','ZonasController@eliminarLink');

//Elementor
$router->get('productosDescatalogadosElementor','PrevisionesController@productosDescatalogadosElementor');
$router->get('badgeProductosDescatalogadosElementor','PrevisionesController@badgeProductosDescatalogadosElementor');


//Precios Cambiados
$router->get('controlPreciosCambiadosAx','ProductosController@controlPreciosCambiadosAx');
$router->get('badgeControlPreciosCambiadosAx','ProductosController@badgeControlPreciosCambiadosAx');

//Faqs
$router->get('cargarFaqs','ProductosController@cargarFaqs');
$router->post('crearFaq','ProductosController@crearFaq');
$router->put('actualizarFaq','ProductosController@actualizarFaq');
$router->delete('eliminarFaq/{idFaq}','ProductosController@eliminarFaq');


//Alertas Amazon
$router->get('alertaCaracteresAmazon','PrevisionesController@alertaCaracteresAmazon');
$router->get('countAlertaCaracteresAmazon','PrevisionesController@countAlertaCaracteresAmazon');
$router->get('productosNoPublicadosAmazon','PedidosController@productosNoPublicadosAmazon');
$router->get('productosNoPublicadosAmazonMP','PedidosController@productosNoPublicadosAmazonMP');


//Pre-Almacen
$router->get('preAlmacen','PedidosController@preAlmacen');
$router->get('countPreAlmacen','PedidosController@countPreAlmacen');


//Favoritos
$router->get('cargarTopFavoritos','ProductosController@cargarTopFavoritos');
$router->get('cargarGraficoFavoritos','ProductosController@cargarGraficoFavoritos');


//Precios Fijos Makro
$router->get('cargarSelectProductos','RangosController@cargarSelectProductos');
$router->get('cargarTablaPreciosFijos','RangosController@cargarTablaPreciosFijos');
$router->post('registrarPrecioFijo','RangosController@registrarPrecioFijo');
$router->put('actualizarPrecioFijo','RangosController@actualizarPrecioFijo');
$router->delete('eliminarPrecioFijo/{id}','RangosController@eliminarPrecioFijo');

//Ventas Habitantes
$router->get('ventasHabitantes','EstadisticasController@ventasHabitantes');

//Alertas transferencias bancarias sin stock
$router->get('transferenciaBancariaSinStock','PrevisionesController@transferenciaBancariaSinStock');
$router->get('countTransferenciaBancariaSinStock','PrevisionesController@countTransferenciaBancariaSinStock');

//Rutas Dashboard
$router->get('productosTopHoy','PrevisionesController@productosTopHoy');
$router->get('productosTopUltimos7DiasDashboard','PrevisionesController@productosTopUltimos7DiasDashboard');
$router->get('productosTopUltimos30DiasDashboard','PrevisionesController@productosTopUltimos30DiasDashboard');


$router->get('avanceSemanal','EstadisticasController@avanceSemanal');
$router->get('graficoVentas','EstadisticasController@graficoVentas');
$router->get('graficoVentasUnaSemana','EstadisticasController@graficoVentasUnaSemana');
$router->get('graficoVentasUnMes','EstadisticasController@graficoVentasUnMes');
$router->get('ventasSemanalesDashBoard','EstadisticasController@ventasSemanalesDashBoard');
$router->get('roturaDeStock','EstadisticasController@roturaDeStock');
$router->get('graficoVentasPaisesHoy','EstadisticasController@graficoVentasPaisesHoy');
$router->get('graficoVentasPaisesUnaSemana','EstadisticasController@graficoVentasPaisesUnaSemana');
$router->get('graficoVentasPaisesUnMes','EstadisticasController@graficoVentasPaisesUnMes');
$router->get('graficoComparacionVentas','EstadisticasController@graficoComparacionVentas');


//Productos Top por Canales Hoy
$router->get('productosTopCanales/{variable}','EstadisticaCanalesController@productosTopCanales');
$router->get('productosTopCanalOrion','EstadisticaCanalesController@productosTopCanalOrion');
$router->get('productosTopCanalWish','EstadisticaCanalesController@productosTopCanalWish');

//Productos Top por Canales 15 dias
$router->get('productosTopCanales15Dias/{variable}','EstadisticaCanalesController@productosTopCanales15Dias');
$router->get('productosTopCanalOrion15Dias','EstadisticaCanalesController@productosTopCanalOrion15Dias');
$router->get('productosTopCanalWish15Dias','EstadisticaCanalesController@productosTopCanalWish15Dias');

//Productos Top por Canales 30 dias
$router->get('productosTopCanales30Dias/{variable}','EstadisticaCanalesController@productosTopCanales30Dias');
$router->get('productosTopCanalOrion30Dias','EstadisticaCanalesController@productosTopCanalOrion30Dias');
$router->get('productosTopCanalWish30Dias','EstadisticaCanalesController@productosTopCanalWish30Dias');

//Presupuestos 2022
$router->get('cargarSelectEstados','PedidosController@cargarSelectEstados');
$router->get('vistaPresupuestos','PedidosController@vistaPresupuestos');
$router->post('registrarPresupuesto','PedidosController@registrarPresupuesto');
$router->delete('eliminarPresupuesto/{idPresupuesto}','PedidosController@eliminarPresupuesto');
$router->put('actualizarPresupuesto','PedidosController@actualizarPresupuesto');

//BUSCADOR DE PRODUCTOS
$router->get('buscadorProductos/{value}','ProductosController@buscadorProductos');

//PRODUCTOS SIN EAN13
$router->get('productosSinEan13','ProductosController@productosSinEan13');
$router->get('countProductosSinEan13','ProductosController@countProductosSinEan13');

//PRODUCTOS CON POCAS IMAGENES
$router->get('productosConPocasImagenes','ProductosController@productosConPocasImagenes');

//CONECTORES
$router->get('conectores','EstadisticasController@conectores');

//Subir Archivos Noticias
$router->post('registrarNoticias','DocumentosController@registrarNoticias');
$router->get('listadoNoticias/{idUser}','DocumentosController@listadoNoticias');
$router->put('actualizarNoticia','DocumentosController@actualizarNoticia');
$router->delete('eliminarNoticia/{idNoticia}/{nameImagen}','DocumentosController@eliminarNoticia');


//Guardar Archivos por producto
$router->get('cargarSelectProductos','DocumentosController@cargarSelectProductos');
$router->post('buscarEan13PorNombreProducto','DocumentosController@buscarEan13PorNombreProducto');
$router->get('cargarSelectTipoDeDocumento','DocumentosController@cargarSelectTipoDeDocumento');
$router->post('registrarDocumento','DocumentosController@registrarDocumento');
$router->get('cargarListadoDocumentosPorEan13/{ean13}','DocumentosController@cargarListadoDocumentosPorEan13');
$router->get('cargarListadoCompleto','DocumentosController@cargarListadoCompleto');
$router->post('eliminarArchivos','DocumentosController@eliminarArchivos');

//Productos Pendientes de Validación Lengow
$router->get('controlPedidosPendientesValidacion','PedidosController@controlPedidosPendientesValidacion');
$router->get('BadgeControlPedidosPendientesValidacion','PedidosController@BadgeControlPedidosPendientesValidacion');

//Pedidos > 5 dias no enviados
$router->get('pedidosNoEnviados','PedidosController@pedidosNoEnviados');
$router->get('countPedidosNoEnviados','PedidosController@countPedidosNoEnviados');

//Diferencia Precios Combinados
$router->get('diferenciaPreciosCombinados','ProductosController@diferenciaPreciosCombinados');
$router->get('badgeDiferenciaPreciosCombinados','ProductosController@badgeDiferenciaPreciosCombinados');

//Abonos
$router->post('buscarAbonosPorFechas','AbonosController@buscarAbonosPorFechas');
$router->post('buscarLineasAbonos','AbonosController@buscarLineasAbonos');

//Incidencias
$router->post('buscarIncidenciaPorAbono','AbonosController@buscarIncidenciaPorAbono');
$router->post('countBuscarIncidenciaPorAbono','AbonosController@countBuscarIncidenciaPorAbono');

//Incidencias Motivos y SubMotivos
$router->get('cargarSelectMotivos','AbonosController@cargarSelectMotivos');
$router->get('cargarSelectSubMotivos/{idMotivo}','AbonosController@cargarSelectSubMotivos');
$router->post('registrarMotivosYSubMotivos','AbonosController@registrarMotivosYSubMotivos');


//Precio Base < Precio Oferta
$router->get('controlPreciosBaseMenorPrecioOferta','ProductosController@controlPreciosBaseMenorPrecioOferta');
$router->get('countControlPreciosBaseMenorPrecioOferta','ProductosController@countControlPreciosBaseMenorPrecioOferta');


//Pedidos Duplicados
$router->get('pedidosDuplicados','PedidosController@pedidosDuplicados');
$router->get('countPedidosDuplicados','PedidosController@countPedidosDuplicados');


//Contraseñas Plataformas
$router->get('clavesPlataformas','ZonasController@clavesPlataformas');
$router->post('registrarClavesPlataformas','ZonasController@registrarClavesPlataformas');
$router->put('actualizarClavesPlataformas','ZonasController@actualizarClavesPlataformas');
$router->delete('eliminarClavesPlataforma/{idPlataforma}','ZonasController@eliminarClavesPlataforma');

//Abonos Incidencias Motivos
$router->post('incidenciaAbonosMotivos','AbonosController@incidenciaAbonosMotivos');

//Productos solo categorizados en OUTLET
$router->get('productosEnCategoriaOulet','ProductosController@productosEnCategoriaOulet');
$router->get('countProductosEnCategoriaOulet','ProductosController@countProductosEnCategoriaOulet');

//Productos SIN categoria predeterminada
$router->get('productosSinCategoriaPredeterminada','ProductosController@productosSinCategoriaPredeterminada');
$router->get('countProductosSinCategoriaPredeterminada','ProductosController@countProductosSinCategoriaPredeterminada');


//Abonos Motivo Transporte
$router->post('abonosMotivosTransporte','AbonosController@abonosMotivosTransporte');

//Productos Sin MP_NombreArticulo
$router->get('productosSinMPNombreArticulo','ProductosController@productosSinMPNombreArticulo');
$router->get('countProductosSinMPNombreArticulo','ProductosController@countProductosSinMPNombreArticulo');


//Listado Tabla de Registro de Pedidos con Estado PreAlmacen
$router->get('pedidosEstadosPreAlmacen','PedidosController@pedidosEstadosPreAlmacen');


//Indice Abonos por Canal
$router->post('indiceAbonosPorCanal','AbonosController@indiceAbonosPorCanal');


//Ventas Por Producto
$router->post('ventasPorProducto','PedidosController@ventasPorProducto');


//DATOS FACTURACION AX
$router->get('datosFacturacionAx','EstadisticasController@datosFacturacionAx');

//Facturas AX Entre Fechas
$router->post('datosFacturacionAxEntreFechas','EstadisticasController@datosFacturacionAxEntreFechas');


//Abonos por productos entre fechas
$router->post('abonosProductosEntreFechas','AbonosController@abonosProductosEntreFechas');


//DESCUENTOS
$router->get('descuentos','EstadisticasController@descuentos');


//Productos Sin Bullets
$router->get('productosSinBullets','ProductosController@productosSinBullets');
$router->get('countProductosSinBullets','ProductosController@countProductosSinBullets');

//Category Faqs
$router->get('cargarFaqsCategorias','ProductosController@cargarFaqsCategorias');
$router->post('crearFaqCategory','ProductosController@crearFaqCategory');
$router->put('actualizarFaqCategory','ProductosController@actualizarFaqCategory');
$router->delete('eliminarFaqCategory/{idFaq}','ProductosController@eliminarFaqCategory');


//Control de Menú
$router->get('visualizacionMenu/{idUser}','UserAdminController@visualizacionMenu');

//Cargar Botones Selección Menu
$router->get('cargarBotonesSeleccionMenu','UserAdminController@cargarBotonesSeleccionMenu');

//Alertas Categorias Sin Facetas
$router->get('alertasCategoriasSinFacetas','EstadisticaCanalesController@alertasCategoriasSinFacetas');
$router->get('countAlertasCategoriasSinFacetas','EstadisticaCanalesController@countAlertasCategoriasSinFacetas');

//Encontrar IdPedido dado una Referencia
$router->post('encontrarIdPedido','PedidosController@encontrarIdPedido');

//Devoluciones Por Nombre
$router->post('devolucionesPorNombre','PedidosController@devolucionesPorNombre');

//Productos Novedades
$router->get('productosNovedades','ProductosController@productosNovedades');


//No Mapeados AliExpress
$router->get('noMapeadosAliExpress','ProductosController@noMapeadosAliExpress');
$router->get('countNoMapeadosAliExpress','ProductosController@countNoMapeadosAliExpress');


//Pedidos Vendor
$router->get('pedidosVendor','PedidosController@pedidosVendor');
$router->post('pedidosVendorItems','PedidosController@pedidosVendorItems');
$router->post('registrarLineaVendor','PedidosController@registrarLineaVendor');
$router->post('registrarOrderVendorAx','PedidosController@registrarOrderVendorAx');

//Productos Nombre = MP
$router->get('productosNombreMp','ProductosController@productosNombreMp');

//Ultimo pedido enviado hace 2 horas
$router->get('ultimoPedidoEnviado','PedidosController@ultimoPedidoEnviado');

//Ultimo pedido Enviado hace 8 horas y alertar por SMS
$router->get('ultimoPedidoEnviado8Horas','PedidosController@ultimoPedidoEnviado8Horas');

//Pedidos Eliminados
$router->get('pedidosEliminados','PedidosController@pedidosEliminados');
$router->get('countPedidosEliminados','PedidosController@countPedidosEliminados');

//Top 10 Abonos/Motivos
$router->get('top10AbonoMotivo','AbonosController@top10AbonoMotivo');
$router->get('top10ProductosAbonados','AbonosController@top10ProductosAbonados');

//Graficos Abonos
$router->get('graficoAbonosHoy','AbonosController@graficoAbonosHoy');
$router->get('graficoAbonos7Dias','AbonosController@graficoAbonos7Dias');
$router->get('graficoAbonos30Dias','AbonosController@graficoAbonos30Dias');

//Informe de Abonos Entre Fechas
$router->post('informeAbonosEntreFechas','AbonosController@informeAbonosEntreFechas');
