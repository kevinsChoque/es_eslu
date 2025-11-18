<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\TEnding;

class EndingController extends Controller
{
    public function actSearchEnding()
    {
        $end = TEnding::where('state',1)->first();
        if($end)
        {
            $endDateTime = Carbon::parse($end->date . ' ' . $end->hour);
            $now = Carbon::now();

            // Verificar si la fecha y hora del registro es mayor a la actual
            if ($endDateTime->isPast())
            {
                // Actualizar el estado a 0
                $end->state = 0;
                if($end->save())
                    return response()->json(['state' => true,'modal' => true,"message"=>"INGRESE FECHA DE FINALIZACION DE PROGRAMAS", "end"=>$end]);
                else
                    return response()->json(['state' => false,'modal' => false,"message"=>"Error al actualizar el estado de finalización de programas"]);
            }
            else
            {
                session(['ending' => $end]);
                return response()->json(['state' => true,'modal' => false,"end"=>$end]);
            }
        }
        else
        {
            $end = TEnding::orderBy('idEnd', 'desc')->first();
            return response()->json(['state' => true,'modal' => true, "end"=>$end, "message"=>"NO EXISTE FECHA DE FINALIZACION DE PROGRAMAS, INGRESE FECHA DE FINALIZACION"]);
        }

    }
    public function actSaveEnding(Request $r)
    {
        $endDateTime = Carbon::parse($r->date . ' ' . $r->hour);
        if ($endDateTime->isPast())
            return response()->json(['state' => false, "message"=>"La fecha debe ser mayor a la actual."]);
        $r->merge(['state' => '1']);
        $r->merge(['mes' => Carbon::now()->locale('es')->isoFormat('MMMM_Y')]);
        $end=TEnding::create($r->all());
        if($end)
            return response()->json(['state' => true, "message"=>"Se registro correctamente.", "end"=>$end]);
        else
            return response()->json(['state' => false, "message"=>"Error al registrar."]);
    }
    public function actUpdateEnding(Request $r)
    {
        $end = TEnding::find($r->idEnd);
        if($end)
            return response()->json(['state'=>true, 'end'=>$end]);
        else
            return response()->json(['state'=>false, 'Ocurrio un error.']);
    }
    public function actSaveChangeEnding(Request $r)
    {
        $endDateTime = Carbon::parse($r->date . ' ' . $r->hour);
        if ($endDateTime->isPast())
            return response()->json(['state' => false, "message"=>"La fecha debe ser mayor a la actual."]);
        $end = TEnding::find($r->idEnd);
        $r->merge(['state' => 1]);
        $end->fill($r->all());
        if($end->save())
            return response()->json(['state'=>true, 'message'=>"Se actualizo correctamente.", 'end'=>$end]);
        else
            return response()->json(['state'=>false, 'message'=>"Ocurrio un error en la actualizacion."]);
    }
}
