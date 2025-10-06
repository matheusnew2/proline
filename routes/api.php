<?php

use App\Http\Controllers\Api\V1\UploadsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/uploads', [ UploadsController::class,'getAllUploads' ]);
Route::post('/uploads', [UploadsController::class,'create']);
Route::get('/uploads/{batch_id}', [ UploadsController::class,'show' ]);
Route::post('/uploads/{batch_id}/reprocess', [ UploadsController::class,'reprocessBatch']);
Route::post('/uploads/job/{job_id}/reprocess', [ UploadsController::class,'reprocessJob']);
