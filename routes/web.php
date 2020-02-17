<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/login', 'auth/login');


Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Auth::routes();

/*Route::group(['prefix' => 'admin'], function () {*/

	Route::get('/', 'HomeController@index')->name('inicio');
	
	Route::group(['middleware' => ['auth']],function(){

		//usuarios
		Route::get('usuarios', 'UsuarioController@index')->name('listaUsuarios');//\\\->middleware('permiso:usuarios.listaUsuarios');
		Route::post('usuarios', 'UsuarioController@asignarRol')->name('agregarRol');//->middleware('permiso:usuarios.asignarRol');
	/*	Route::post('eliminarUsuarios','UsuarioController@eliminarUsuario')->name('eliminarUsuario');*/
		Route::post('editarUsuario','UsuarioController@eliminarUsuario')->name('eliminarUsuario');

		Route::post('resetPassword','UsuarioController@resetPassword')->name('resetPassword')->middleware('permiso:usuarios.resetPassword');
		Route::post('apiJerarquia','UsuarioController@jerarquia')->name('jerarquia');
		Route::post('altaUsuario','UsuarioController@registroUsuario')->name('registroUsuario');
		//primer cambio
		Route::get('primerIngreso','UsuarioController@primerPassword')->name('primerPassword');

		Route::post('primerIngreso','UsuarioController@cambioPrimerPassword')->name('cambioPrimerPassword');

		Route::post('editarPerfil','UsuarioController@editarPerfil')->name('editarPerfil');

		


		//roles
		Route::get('roles','RolController@index')->name('listaRoles');
		//alta
		Route::post('roles','RolController@crear')->name('crearRol');
		//modificacion
		Route::post('editarRol','RolController@editarRol')->name('editarRol');
		//borrado
		Route::post('eliminarRol','RolController@eliminarRol')->name('eliminarRol');

		//permisos
		Route::get('permisos','PermisosController@index')->name('listaPermisos');
		//alta
		Route::post('permisos','PermisosController@crearPermiso')->name('crearPermiso');
		//modificacion
		Route::post('editarPermiso','PermisosController@editarPermiso')->name('editarPermiso');
		//borrado
		Route::post('eliminarPermiso','PermisosController@eliminarPermiso')->name('eliminarPermiso');

		//roles permisos -> donde asignamos cada permiso a su respectivo rol
		Route::get('roles-permisos','RolController@rolPermisoIndex')->name('rolPermisos');

		//asignacion-->modificacion
		Route::post('modificar-rol-permiso','RolController@editarRolPermiso')->name('editarRolPermiso');


		//logistica
		Route::get('parte-semanal', 'logistica\LogisticaController@index')->name('idexParteSemanal');
		//alta
		Route::post('parte-semanal', 'logistica\LogisticaController@nuevoParte')->name('altaParte');
		//editar parte
		Route::post('parte-semanal-edicion', 'logistica\LogisticaController@editarParte')->name('editarParte');
		//baja
		Route::post('parte-semanal-baja', 'logistica\LogisticaController@eliminarParte')->name('eliminarParte');
		//pdf
		Route::get('parte-semanal-descargar-pdf/{desde?}/{hasta?}/{vehiculo?}', 'logistica\LogisticaController@descargaPDFParte')->name('descargaPDF');
	
		//vehiculos
		Route::get('alta-vehiculos', 'vehiculos\VehiculoController@index')->name('listaVehiculos');
		//alta
		Route::post('/alta-vehiculos', 'vehiculos\VehiculoController@crearVehiculo')->name('vehiculos.crearVehiculo');
		//editar
		Route::post('/editar-vehiculo', 'vehiculos\VehiculoController@updateVehiculo')->name('updateVehiculo');
		//baja
		Route::post('/baja-detalle-vehiculo', 'vehiculos\VehiculoController@fueraDeServicio')->name('eliminarVehiculos');

		Route::get('storage/{carpeta}/{archivo}','vehiculos\VehiculoController@Imagen')->name('storage');
		
		//lista de vehiculos para select2
		Route::get('/vehiculos-select','vehiculos\VehiculoController@getAllVehiculos')->name('listaVehiculosSelect');

		//tipo vehiculos
		Route::get('tipo-vehiculos','vehiculos\TipoVehiculoController@index')->name('listaTipoVehiculos');
		//alta
		Route::post('alta-tipo-vehiculo','vehiculos\TipoVehiculoController@crearTipoVehiculo')->name('crearTipoVehiculo');
		//modificacion
		Route::post('editar-tipo-vehiculo','vehiculos\TipoVehiculoController@editarTipoVehiculo')->name('editarTipoVehiculo');
		//baja
		Route::post('baja-tipo-vehiculo','vehiculos\TipoVehiculoController@eliminarTipoVehiculo')->name('eliminarTipoVehiculo');

		//estado vehiculo
		///fuera de servicio
		Route::get('fuera-de-servicio', 'vehiculos\VehiculoController@indexEstadoFueraServicio')->name('listadoEstadoVehiculo');
		//baja definitiva
		Route::get('baja-definitiva', 'vehiculos\VehiculoController@indexEstadoBajaDefinitiva')->name('listadoEstadoBajaDefinitiva');
		//historial completo
		Route::get('historial-completo','vehiculos\VehiculoController@indexEstadoHistorialCompleto')->name('historialCompleto');
		//reparacion
		Route::post('fuera-de-servicio','vehiculos\VehiculoController@estadoVehiculoAlta')->name('altaEstadoVehiculo');
		//baja definitiva
		Route::post('baja-definitiva','vehiculos\VehiculoController@bajaDefinitiva')->name('bajaDefinitiva');
		//pdf baja definitiva
		Route::get('baja-definitiva-pdf/{id}', 'vehiculos\VehiculoController@exportarPdfBajaDefinitiva')->name('exportarPdfBajaDefinitiva');


		//asignacion
		Route::get('asignacion','vehiculos\AsignacionController@index')->name('listaAsignacion');
		//getAllVehiculosDisponibles -> select 2
		Route::get('vehiculos-disponibles','vehiculos\AsignacionController@getAllVehiculosDisponibles')->name('getAllVehiculosDisponibles');
		//getAllAfectadosDisponibles -> select 2
		Route::get('afectados-disponibles','vehiculos\AsignacionController@getAllAfectadosDisponibles')->name('getAllAfectadosDisponibles');
		//guardamos asignacion
		Route::post('asignacion','vehiculos\AsignacionController@crearAsignacion')->name('crearAsignacion');
		//eliminar asignacion
		Route::post('eliminar-asignacion','vehiculos\AsignacionController@eliminarAsignacion')->name('eliminarAsignacion');
		//PDF
		Route::get('asignar-vehiculos/{id}', 'vehiculos\AsignacionController@exportarPdfCargo')->name('pdfVehiculosCargo');

		//vehiculos detalle
		Route::get('/detalleVehiculo/{id?}', 'vehiculos\DetallesController@index')->name('detalleVehiculo');
		//descargar el historial del vehiculo
		Route::get('historial-completo-pdf/{id}', 'vehiculos\DetallesController@exportarPdfHistorial')->name('pdfVehiculos');

		//asignacion de siniestros
		Route::get('/siniestros', 'vehiculos\SiniestroController@indexSiniestros')->name('indexSiniestros');

		Route::post('/siniestros', 'vehiculos\SiniestroController@altaSiniestro')->name('altaSiniestro');

		Route::get('/total-siniestros', 'vehiculos\SiniestroController@getAllSiniestros')->name('getAllSiniestros');

		Route::post('/detalle-pdf-siniestro','vehiculos\SiniestroController@getAllPdfsSiniestro');

		Route::get('/descargar-pdf-siniestro/{nombre}','vehiculos\SiniestroController@descargaPdfSiniestro')->name('descargarPDF');

		Route::post('/editar-siniestro','vehiculos\SiniestroController@editarSiniestro')->name('EditarSiniestro');

		//asignacion repuestos
		Route::get('repuestos', 'vehiculos\RepuestoController@index')->name('listaRepuestos');

		Route::post('/repuestos', 'vehiculos\RepuestoController@AsignarRepuesto')->name('asignarRepuesto');

		Route::get('/vehiculos-select-vehiculos-disponibles','vehiculos\RepuestoController@getAllVehiculosDisponiblesRepuestos')->name('getAllVehiculosDisponiblesRepuestos');

		Route::get('asignar-vehiculos-repuestos/{id}', 'vehiculos\RepuestoController@exportarPdfRepuestos')->name('descargarPDFRepuesto');

		//reportes gdona
		Route::get('/reportes', 'vehiculos\GraficosController@index')->name('ListaGraficos');

		Route::post('/reportesFiltro', 'vehiculos\GraficosController@reportesListadoFiltro')->name('reportesListadoFiltro');

		Route::get('totalVehiculos/{nombre?}', 'vehiculos\VehiculoController@getTotalVehiculos')->name('getTotalVehiculos');

		Route::get('Descargar-pdf-Vehiculos', 'vehiculos\VehiculoController@exportarPdfVehiculos')->name('exportarPdfVehiculos');

		Route::post('/estado-alta-vehiculo', 'vehiculos\VehiculoController@AltadeVehiculosDadosDeBaja')->name('AltadeVehiculosDadosDeBaja');

		//datatable detalles
		Route::get('/detalle-Datatable/{vehiculo}', 'vehiculos\VehiculoController@detalleDatatable')->name('detalleDatatable');




	});
/*});*/
