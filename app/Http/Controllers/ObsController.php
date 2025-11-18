<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

use App\Models\TObs;
use App\Models\TObsevi;

class ObsController extends Controller
{
    public function actShowObs(Request $r)
    {
        // dd($r->all());
        //  inscription
        $obs = TObs::where('idAss', Session::get('assign')->idAss)->where('inscription', $r->inscription)->first();
        if(is_null($obs))
            return response()->json(['state' => true, 'obs' => null, 'list' => null]);
        $list = TObsevi::where('idObs', $obs->idObs)->get();
        // dd($obs,$list);
        return response()->json(['state' => true, 'obs' => $obs, 'list' => $list]);
    }
    // posiblemente ya no se use esta funcion
    public function actSaveObs(Request $r)
    {
        dd('esta para borrar-',$r->all());
        $obs = TObs::where('idAss', Session::get('assign')->idAss)->where('inscription', $r->inscription)->first();
        $r->merge(['idAss' => Session::get('assign')->idAss]);
        $r->merge(['inscription' => $r->inscription]);
        if($obs!=null)
        {
            $obs->update($r->all());
            return response()->json(['state' => true, 'obs' => $obs]);
        }
        else
        {
            $obs=TObs::create($r->all());
            return response()->json(['state' => true, 'obs' => $obs]);
        }

    }
    public function actSendImgObs_b(Request $r)
    {
        $idAss = Session::get('assign')->idAss;
        $idObs = $r->idObs;
        if(is_null($r->idObs))
        {
            $data = [
                'idAss' => $idAss,
                'inscription' => $r->oinscription,
                'comment' => $r->oobs,
            ];
            $idObs = DB::table('obs')->insertGetId($data);
            if(!$idObs)
                return response()->json(['state' => false, 'message' => 'No fue posible crear el registro de observacion.']);
        }
        if (!$r->hasFile('files'))
            return response()->json(['state' => true, 'message' => 'Se guardo la observacion.']);
        // dd($idObs);
        if ($r->hasFile('files'))
        {
            $uploadedFiles = $r->file('files');
            $storedFiles = [];
            foreach ($uploadedFiles as $file)
            {
                $filename = time() . '_' . $file->getClientOriginalName();
                $dir = 'obsevi/'.Session::get('assign')->idAss.'/'.$r->oinscription.'-'.$idObs;
                $path = $file->storeAs($dir, $filename, 'public');
                if ($path)
                {
                    $r->merge([
                        'idObs' => $idObs,
                        'path' => $path,
                        'date' => Carbon::now()->format('Y-m-d'),
                        'hour' => Carbon::now()->format('H:i:s')
                    ]);
                    $oe=TObsevi::create($r->all());
                    if(!$oe)
                        return response()->json(['state' => false, 'message' => 'No fue posible crear el registro.']);
                } else
                    return response()->json(['state' => false, 'message' => 'Ocurrió un error al guardar la imagen.']);
            }
            return response()->json(['state' => true, 'paths' => $storedFiles, 'message' => 'La imagen se guardo exitosamente.', 'idObs' => $idObs]);
        }
        return response()->json(['state' => false, 'message' => 'Ocurrio un error']);
    }
    public function actSendImgObs(Request $r)
    {
        DB::beginTransaction();
        try {
            // dd($r->all());
            $idAss = Session::get('assign')->idAss;
            $idObs = $r->idObs;
            if (is_null($r->idObs))
            {
                $data = [
                    'idAss' => $idAss,
                    'inscription' => $r->oinscription,
                    'comment' => $r->oobs,
                ];
                $idObs = DB::table('obs')->insertGetId($data);
                if (!$idObs)
                {
                    DB::rollBack(); // Revertir transacción si no se pudo insertar
                    return response()->json(['state' => false, 'message' => 'No fue posible crear el registro de observación.']);
                }
            }
            else
            {
                $obs = TObs::find($idObs);
                $obs->comment = $r->oobs;
                if(!$obs->save())
                    return response()->json(['state' => false, 'message' => 'No fue posible crear el registro de observación.']);
            }
            if (!$r->hasFile('files'))
            {
                DB::commit();
                return response()->json(['state' => true, 'message' => 'Se guardó la observación.']);
            }
            if ($r->hasFile('files'))
            {
                $uploadedFiles = $r->file('files');
                $storedFiles = [];

                foreach ($uploadedFiles as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $dir = 'obsevi/' . Session::get('assign')->idAss . '/' . $r->oinscription . '-' . $idObs;
                    $path = $file->storeAs($dir, $filename, 'public');

                    if ($path)
                    {
                        $r->merge([
                            'idObs' => $idObs,
                            'path' => $path,
                            'date' => Carbon::now()->format('Y-m-d'),
                            'hour' => Carbon::now()->format('H:i:s')
                        ]);
                        $oe = TObsevi::create($r->all());
                        if (!$oe)
                        {
                            DB::rollBack();
                            return response()->json(['state' => false, 'message' => 'No fue posible crear el registro.']);
                        }
                        $storedFiles[] = $path;
                    }
                    else
                    {
                        DB::rollBack(); // Revertir la transacción si no se pudo guardar la imagen
                        return response()->json(['state' => false, 'message' => 'Ocurrió un error al guardar la imagen.']);
                    }
                }
                DB::commit();
                return response()->json(['state' => true, 'paths' => $storedFiles, 'message' => 'La imagen se guardó exitosamente.', 'idObs' => $idObs]);
            }
            DB::rollBack(); // Revertir la transacción si algo falla
            return response()->json(['state' => false, 'message' => 'Ocurrió un error inesperado.']);

        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de una excepción
            return response()->json(['state' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function actDeleteEvidenceObs(Request $r)
    {
        $evi = tobsevi::find($r->idOe);
        if($evi->delete())
        {
            $filePath = storage_path('app/public/'.$evi->path);
            if (file_exists($filePath))
            {
                if(unlink($filePath))
                    return response()->json(["message"=>"Se elimino la evidencia","state"=>true]);
                return response()->json(["message"=>"No fue posible eliminar la evidencia","state"=>false]);
            }
            else
                return response()->json(["message"=>"No fue posible eliminar la evidencia","state"=>false]);
        }
        else
            return response()->json(["message"=>"No fue posible eliminar la evidencia","state"=>false]);
    }
    public function actShowObsevi(Request $r)
    {
        // dd($r->all());
        // $list = TObsevi::where('inscription',$r->inscription)
        //     ->where('type',$r->type)->get();
        $list = TObsevi::where('idObs', $r->idObs)->get();
        return response()->json(['state' => true, 'data' => $list]);
    }
}
