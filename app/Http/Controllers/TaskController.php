<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\TAssign;
use App\Models\TEnding;

class TaskController extends Controller
{
    public function actFillTask()
    {
        if (!Session::has('tecnical') || !Session::get('tecnical')->idTec)
            return response()->json(['state' => false, 'message' => 'No se encontró información del técnico en la sesión.']);
        $ending = TEnding::where('state', '1')->first();
        if (!$ending)
            return response()->json(['state' => false, 'message' => 'No se encontró un periodo de finalizacion de cortes activo.']);

        $idTec = Session::get('tecnical')->idTec;
        $idEnd = $ending->idEnd;
        $data = TAssign::where('idEnd', $idEnd)->where('idTec', $idTec)->select('idAss', 'flat', 'cant', 'routes')->get();
        if ($data->isEmpty())
            return response()->json(['state' => false, 'message' => 'No se encontraron registros de asignacion para el tecnico.']);

        return response()->json(['state' => true, 'data' => $data]);
    }

}
