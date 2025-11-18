<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\TecnicalController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\EndingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\ObsController;
use App\Http\Controllers\TaskController;

use App\Http\Middleware\MDUser;
use App\Http\Middleware\MDLogin;
Route::middleware([MDLogin::class])->group(function () {
    Route::get('/',[StartController::class, 'actLogin']);
});
Route::get('login/login',[LoginController::class, 'actLogin']);//verificar si esta en uso
Route::post('login/sigin',[LoginController::class, 'actSigin'])->name('login');

Route::middleware([MDUser::class])->group(function () {
    // login
    Route::get('login/logout',[LoginController::class, 'actLogout'])->name('logout');
    // cortes
    Route::get('court/start',[CourtController::class, 'actStart'])->name('home');
    Route::get('court/showCourtFilter',[CourtController::class, 'actShowCourtFilter']);
    Route::post('court/searchRecords',[CourtController::class, 'actSearchRecords'])->name('searchRecords');
    Route::get('court/courtAssign',[CourtController::class, 'actCourtAssign'])->name('listCourtAssign');
    // tecnical
    Route::get('tecnical/list',[TecnicalController::class, 'actList'])->name('tecnicalList');
    Route::post('tecnical/assign',[TecnicalController::class, 'actAssign'])->name('assignTecnical');
    Route::post('tecnical/courtUser',[TecnicalController::class, 'actCourtUser'])->name('courtUser');
    Route::post('tecnical/activateUser',[TecnicalController::class, 'actActivateUser'])->name('activateUser');
    Route::get('tecnical/showAssignTecnical',[TecnicalController::class, 'actShowAssignTecnical'])->name('showAssignTecnical');
    Route::post('tecnical/updateRecords',[TecnicalController::class, 'actUpdateRecords'])->name('updateRecords');
    Route::post('tecnical/showBlue',[TecnicalController::class, 'actShowBlue'])->name('showBlue');
    // --------------------------------------------------------------------test
    Route::get('tecnical/listCut',[TecnicalController::class, 'actListCut'])->name('listCut');

Route::get('tecnical/updateLectura',[TecnicalController::class, 'actUpdateLectura'])->name('updateLectura');
    Route::post('tecnical/listCut2',[TecnicalController::class, 'actListCut2'])->name('listCut2');
    // evidence
    Route::post('evidence/sendEvidence',[EvidenceController::class, 'actSendEvidence'])->name('sendEvidence');
    Route::post('evidence/showEvidences',[EvidenceController::class, 'actShowEvidences'])->name('showEvidences');
    Route::post('evidence/deleteEvidence',[EvidenceController::class, 'actDeleteEvidence'])->name('deleteEvidence');
    // fecha de finalizacion de los cortes y rehabilitacion
    Route::post('ending/searchEnding',[EndingController::class, 'actSearchEnding'])->name('searchEnding');
    Route::post('ending/saveEnding',[EndingController::class, 'actSaveEnding'])->name('saveEnding');
    Route::post('ending/updateEnding',[EndingController::class, 'actUpdateEnding'])->name('updateEnding');
    Route::post('ending/saveChangeEnding',[EndingController::class, 'actSaveChangeEnding'])->name('saveChangeEnding');
    // reportes
    Route::get('report/showReport',[ReportController::class, 'actShowReport'])->name('showReport');
    Route::post('report/advanceCuts',[ReportController::class, 'actAdvanceCuts'])->name('advanceCuts');
    Route::get('report/sumary',[ReportController::class, 'actSumary'])->name('sumary');
    // asignaciones
    Route::get('assign/listAssign',[AssignController::class, 'actListAssign'])->name('listAssign');
    Route::post('assign/deleteAssign',[AssignController::class, 'actDeleteAssign'])->name('deleteAssign');
    // observacion
    Route::post('obs/showObs',[ObsController::class, 'actShowObs'])->name('showObs');
    Route::post('obs/saveObs',[ObsController::class, 'actSaveObs'])->name('saveObs');
    Route::post('obs/sendImgObs',[ObsController::class, 'actSendImgObs'])->name('sendImgObs');
    Route::post('obs/deleteEvidenceObs',[ObsController::class, 'actDeleteEvidenceObs'])->name('deleteEvidenceObs');
    Route::post('obs/showObsevi',[ObsController::class, 'actShowObsevi'])->name('showObsevi');
    // task
    Route::post('task/fillTask',[TaskController::class, 'actFillTask'])->name('fillTask');
    // esta ruta solo es para recuperar la data eliminada
    Route::get('/recovery',[TecnicalController::class, 'actRecoveryData']);
    // guardar comentario
    Route::post('court/showObs',[CourtController::class, 'actShowComentario'])->name('showComentario');
    Route::post('court/saveComentario',[CourtController::class, 'actSaveComentario'])->name('saveComentario');
});
Route::get('tecnical/showAsignacion',[TecnicalController::class, 'actShowAsignacion'])->name('showAsignacion');



