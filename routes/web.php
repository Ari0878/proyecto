<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllerApi;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AuthControllerApi;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TrayectoriaController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ManteniminetoController;
use App\Http\Controllers\DetalleController;


Route::get('/', function () {
    return view('inicio');
})->name('inicio');


Route::get('quienes-somos', function(){
    return view('quienes-somos');
});

// Rutas para usuarios
Route::get('altaUsers', [UserControllerApi::class, 'getUsers'])->name('index');
Route::get('usuarios/{id_usuario}', [UserControllerApi::class, 'getUserById'])->name('show');
Route::get('createUser', [UserControllerApi::class, 'createUser'])->name('createUser');
Route::post('usuarios', [UserControllerApi::class, 'updateUser'])->name('updateUser');
Route::get('usuarios/{id_usuario}/edit', [UserControllerApi::class, 'edit'])->name('edit');
Route::put('usuarios/{id_usuario}', [UserControllerApi::class, 'update'])->name('update');
Route::delete('usuarios/{id_usuario}', [UserControllerApi::class, 'destroy'])->name('destroy');

// Ruta para login
Route::get('login', [AuthControllerApi::class, 'showLoginForm'])->name('login');  // Muestra el formulario de login
Route::post('login', [AuthControllerApi::class, 'login'])->name('login.submit');  // Procesa el login



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login/success', [LoginController::class, 'loginSuccess'])->name('login_success');


// Ruta para mostrar el formulario de solicitud de restablecimiento de contraseña
Route::get('/forgot-password', [AuthControllerApi::class, 'showForgotPasswordForm'])->name('password.request');

// Ruta para enviar el código de verificación al correo
Route::post('/forgot-password', [AuthControllerApi::class, 'sendResetCode'])->name('password.email');

// Ruta para mostrar el formulario de restablecimiento de contraseña
Route::get('/reset-password/{correo}', [AuthControllerApi::class, 'showResetPasswordForm'])->name('password.reset');

// Ruta para procesar el restablecimiento de contraseña
Route::post('/reset-password', [AuthControllerApi::class, 'resetPassword'])->name('password.update');

use App\Http\Controllers\PdfController;

Route::get('/pdf/usuarios', [PdfController::class, 'generarPdf'])->name('pdf.usuarios');
Route::get('/pdf/vehiculo', [PdfController::class, 'generarPdfvehiculo'])->name('pdf.vehiculo');
Route::get('/pdf/trayectoria', [PdfController::class, 'generarPdftrayectoria'])->name('pdf.trayectoria');
Route::get('/pdf/sensor', [PdfController::class, 'generarPdfsensor'])->name('pdf.sensor');
Route::get('/pdf/mantenimiento', [PdfController::class, 'generarPdfmantenimiento'])->name('pdf.mantenimiento');
Route::get('/pdf/detalle', [PdfController::class, 'generarPdfdetalle'])->name('pdf.detalle');


/////////////////////////Vehiculo/////////////////////////////////////////////////////////////
Route::get('/consultar-vehi', [VehiculoController::class, 'getData'])->name('/consultar-vehi');
Route::match(['get', 'post'], '/alta-vehi', [VehiculoController::class, 'postData'])->name('enviar.datoss');
Route::get('/alta-vehi', [VehiculoController::class, 'showForm'])->name('/alta-vehi');
Route::get('/consultar2-vehi/{id}', [VehiculoController::class, 'getData2']);
Route::get('/actualizar-vehi/{id}', [VehiculoController::class, 'updateData']);
Route::put('/actualizar-vehi/{id}', [VehiculoController::class, 'actualizar'])->name('actualizar.vehi');
Route::get('/borrar-vehi/{id}', [VehiculoController::class, 'deleteData']);

/////////////////////////Trayectoria/////////////////////////////////////////////////////////////

Route::get('/consultar-tray', [TrayectoriaController::class, 'trayData'])->name('consultar-tray');
Route::match(['get', 'post'], '/alta-tray', [TrayectoriaController::class, 'traypostData'])->name('alta-tray');
Route::get('/consultar2-tray/{id}', [TrayectoriaController::class, 'traygetData2']);
Route::get('/actualizar-tray/{id}', [TrayectoriaController::class, 'trayupdateData']);
Route::put('/actualizar-tray/{id}', [TrayectoriaController::class, 'trayactualizar'])->name('actualizar.api');
Route::get('/borrar-tray/{id}', [TrayectoriaController::class, 'traydeleteData']);


/////////////////////////////Sensor///////////////////////////////////////////


Route::get('/consultar-sensor', [SensorController::class, 'sensorData'])->name('/consultar-sensor');
Route::match(['get', 'post'], '/alta-api', [SensorController::class, 'sensorpostData'])->name('datos');
Route::get('/alta-sensor', [SensorController::class, 'showForm'])->name('/alta-sensor');
Route::get('/consultar2-sensor/{id}', [SensorController::class, 'sensorgetData2']);
Route::get('/actualizar-sensor/{id}', [SensorController::class, 'sensorupdateData']);
Route::put('/actualizar-sensor/{id}', [SensorController::class, 'sensoractualizar'])->name('actualizar.sensor');
Route::get('/borrar-sensor/{id}', [SensorController::class, 'sensordeleteData']);
///////Mantenimiento-sensor///////////////////////
Route::get('/consultar-mantenimiento', [ManteniminetoController::class, 'mantenimientoData'])->name('/consultar-mantenimiento');
Route::match(['get', 'post'], '/alta-mantenimiento', [ManteniminetoController::class, 'mantenimientopostData'])->name('enviar.mantenimiento');
Route::get('/alta-mantenimiento', [ManteniminetoController::class, 'showForm'])->name('/alta-api');
Route::get('/consultar2-mantenimiento/{id}', [ManteniminetoController::class, 'mantenimientoData2']);
Route::get('/actualizar-mantenimiento/{id}', [ManteniminetoController::class, 'mantenimientoupdateData']);
Route::put('/actualizar-mantenimiento/{id}', [ManteniminetoController::class, 'mantenimientoactualizar'])->name('actualizar.mantenimiento');
Route::get('/borrar-mantenimiento/{id}', [ManteniminetoController::class, 'mantenimientodeleteData']);

////////////////////detalle-trayectoria//////////////
// Consultar detalles (página principal)
Route::get('/consultar-detalle', [DetalleController::class, 'detalleData'])->name('consultar-detalle');
Route::match(['get', 'post'], '/alta-detalle', [DetalleController::class, 'detallepostData'])->name('enviar.detalle');
Route::get('/alta-detalle', [DetalleController::class, 'showForm'])->name('alta-detalle');
Route::get('/consultar2-detalle/{id}', [DetalleController::class, 'detallegetData2']);
Route::get('/actualizar-api/{id}', [DetalleController::class, 'detalleupdateData']);
Route::put('/actualizar-api/{id}', [DetalleController::class, 'detalleactualizar'])->name('actualizar.detalle');
Route::get('/borrar-detalle/{id}', [DetalleController::class, 'detalledeleteData']);

///////////////////////////Excel///////////////////////////////
///////////////Vehiculo/////////////////////////////////////
Route::get('/upload-excel', [ExcelController::class, 'showUploadForm'])->name('upload.excel.form');
Route::post('/upload-excel', [ExcelController::class, 'upload'])->name('upload.excel');

/////////////Trayectoria///////////////////////////////////////
Route::get('/trayupload-excel', [ExcelController::class, 'showUploadFormtray'])->name('trayupload.excel.form');
Route::post('/trayupload-excel', [ExcelController::class, 'trayupload'])->name('trayupload.excel');

//////////////////////Mantenimiento-sensor/////////////////////////////
Route::post('/mantenimientoupload-excel', [ExcelController::class, 'mantenimientoupload'])->name('mantenimientoupload.excel');
Route::get('/mantenimientoupload-excel', [ExcelController::class, 'showUploadFormmatenimiento'])->name('mantenimientoupload.excel.form');
////////////////Sensor///////////////////////
Route::get('/sensorupload-excel', [ExcelController::class, 'showUploadFormsensor'])->name('sensorupload.excel.form');
Route::post('/sensorupload-excel', [ExcelController::class, 'sensorupload'])->name('sensorupload.excel');

/////////////////////Detalles trayectoria/////////////////////////////
 
Route::get('/detalleupload-excel', [ExcelController::class, 'detalleshowUploadForm'])->name('detalleupload.excel.form');
Route::post('/detalleupload-excel', [ExcelController::class, 'detalleupload'])->name('detalleupload.excel');