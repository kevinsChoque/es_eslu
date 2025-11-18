<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Models\TAssign;
use App\Models\TCourt;

class AssignController extends Controller
{
    public function actListAssign()
    {
        // $list = TAssign::all();
        // dd($activePeriod);
        $sql = "select t.*, a.month, a.flat, a.idAss, a.routes, a.monthDebt,a.cant
            from assign a
                inner join tecnical t on a.idTec=t.idTec
                inner join ending e on e.idEnd=a.idEnd
            where e.state=1 order by idAss";
            // dd($sql);
        $list=DB::select($sql);

        return response()->json(['state' => true, 'data' => $list]);
    }
    public function actDeleteAssign_b(Request $r)
    {
        // eliminar un registro segun idass en la tabla assign, asiendo uso de eloquent y verificando con un if la eliminacion
        // dd($r->all());
        $assign = TAssign::find($r->idAss);
        if($assign)
        {
            if($assign->delete())
            {
                // return response()->json(['state' => true, 'data' => $assign]);
                $sql = "update INSCRIPC set
                    CourtEscn=null,
                    CtaMesActOldEscn=null,
                    StateUserEscn=null
                where CourtEscn='.$r->flat.'";
                $list=DB::select($sql);

                // return response()->json(['state' => true, 'data' => $list]);
            }

        }
        else
            return response()->json(['state' => false, 'data' => 'No se encontro la asignacion.']);
    }
    public function actDeleteAssign(Request $r)
    {
        dd('funcionalidad para actualizar para lectura');
        DB::beginTransaction();
        try {
            $list = TCourt::where('idAss',$r->idAss)->exists();
            if($list)
                return response()->json(['state' => false, 'message' => 'No es posible eliminar, ya que tiene cortes asociados a esta asignación.']);

            // dd('llego aki');
            $assign = TAssign::find($r->idAss);
            if (!$assign)
                return response()->json(['state' => false, 'message' => 'No se encontró la asignación.']);
            $assign->delete();
            $conSql = $this->connectionSql();
            $script = "UPDATE INSCRIPC SET
                CourtEscn = NULL,
                CtaMesActOldEscn = NULL,
                StateUserEscn = NULL
                WHERE CourtEscn = ?";
            $params = [$assign->flat];
            $stmt = sqlsrv_query($conSql, $script, $params);
            if ($stmt === false)
                throw new \Exception('Error en la actualización de INSCRIPC.');
            DB::commit();
            return response()->json(['state' => true, 'message' => 'Asignación eliminada correctamente.']);
        } catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json(['state' => false, 'message' => 'Ocurrió un error durante la eliminación: ' . $e->getMessage()]);
        }
    }


}
