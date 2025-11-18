<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\TEvidence;
use App\Models\TCourt;
use App\Models\TActivation;

class EvidenceController extends Controller
{
    public function actSendEvidence(Request $r)
    {
        // dd($r->all(),Session::get('assign')->idAss);
        // dd(Carbon::now()->locale('es')->monthName);
        $mesAnio = Carbon::now()->locale('es')->isoFormat('MMMM_Y');
        if ($r->hasFile('files'))
        {
            $uploadedFiles = $r->file('files');
            $storedFiles = [];
            foreach ($uploadedFiles as $file)
            {
                $filename = time().'_'.$mesAnio.'.'. $file->getClientOriginalExtension();
                $dir = 'evidences/'.Session::get('assign')->idAss.'-'.$r->inscription.'/'.$mesAnio.'/';
                $path = $file->storeAs($dir, $filename, 'public');
                // $storedFiles[] = $path;
                if ($path)
                {
                    $r->merge(['idAss' => Session::get('assign')->idAss]);
                    $r->merge(['inscription' => $r->inscription]);
                    $r->merge(['path' => $path]);
                    $r->merge(['dateLec' => Carbon::now()->format('Y-m-d')]);
                    $evi=TEvidence::create($r->all());
                    if(!$evi)
                        return response()->json(['state' => false, 'message' => 'No fue posible crear el registro.']);
                    // $storedFiles[] = $path;
                } else {
                    return response()->json(['state' => false, 'message' => 'Ocurrió un error al guardar la evidencia.']);
                }
            }
            return response()->json(['state' => true, 'paths' => $storedFiles, 'message' => 'La evidencia se guardo exitosamente.']);
        }
        return response()->json(['state' => false, 'message' => 'Ocurrio un error']);
    }
    public function actShowEvidences(Request $r)
    {
        $list = TEvidence::where('inscription',$r->inscription)->get();
        return response()->json(['state' => true, 'data' => $list]);
    }
    public function actDeleteEvidence(Request $r)
    {
        DB::beginTransaction();
        try
        {
            $evi = TEvidence::find($r->idEvi);

            if ($evi->delete())
            {
                $filePath = storage_path('app/public/' . $evi->path);
                if (file_exists($filePath))
                {
                    if (unlink($filePath))
                    {
                        DB::commit();
                        return response()->json(["message" => "Se eliminó la evidencia", "state" => true]);
                    }
                    else
                        throw new \Exception("No fue posible eliminar el archivo de evidencia.");
                }
                else
                    throw new \Exception("El archivo de evidencia no existe.");
            }
            else
                throw new \Exception("No fue posible eliminar el registro de evidencia.");
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage(), "state" => false, "cath" => 'cath']);
        }
    }

}
