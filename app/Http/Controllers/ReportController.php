<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function actShowReport()
    {
        return view('report.report');
    }
    public function actAdvanceCuts()
    {
        $sqlOnlyCuts = "select c.idAss,count(c.idCou) as cant,t.name,a.cant as total
            from court c
                left join activation ac on c.idCou=ac.idCou
                inner join assign a on c.idAss=a.idAss
                inner join tecnical t on a.idTec=t.idTec
            where ac.idAct is null
            group by c.idAss,t.name,a.cant
            order by c.idAss;";
        $sqlOnlyCuts = "select c.idAss,count(c.idCou) as cant,t.name,a.cant as total
            from court c
                left join activation ac on c.idCou=ac.idCou
                LEFT join assign a on c.idAss=a.idAss
                left join tecnical t on a.idTec=t.idTec
            where ac.idAct is null
            group by c.idAss,t.name,a.cant;";
        $sqlOnlyAct = "SELECT idAss,count(idAct) cantAct FROM activation group by idAss;";
		// dd($sql);
		$recordsOnlyCuts = DB::select($sqlOnlyCuts);
		$recordsOnlyAct = DB::select($sqlOnlyAct);
        // dd($recordsOnlyCuts);
		return response()->json(["recordsOnlyCuts"=>$recordsOnlyCuts, "recordsOnlyAct"=>$recordsOnlyAct]);
    }
    public function actSumary_eli()
    {
        $data = DB::table('LECTURA1')
            ->select(DB::raw('CONVERT(varchar, lfechorl, 120) as timestamp'))
            ->where('PreMzn', 69) // o cualquier valor de ruta que necesites
            ->where('MedFlag', 1)
            ->orderBy('lfechorl')
            ->get();


        return response()->json($data);
    }
    public function actSumary(Request $r)
    {
        try {
            $conSql = $this->connectionSql();
            if (!$conSql)
                return response()->json(['state' => false, 'message' => 'No se pudo establecer la conexión a la base de datos'], 500);

            // $preMzn = intval($r->PreMzn); // por ejemplo 69
            $preMzn = intval(13);
            $script = "SELECT CONVERT(varchar, lfechorl, 120) AS timestamp
                    FROM LECTURA1
                    WHERE PreMzn = ? AND MedFlag = 1
                    ORDER BY lfechorl";

            $params = [$preMzn];
            $stmt = sqlsrv_query($conSql, $script, $params);

            if ($stmt === false)
                return response()->json(['state' => false, 'message' => 'Error al ejecutar la consulta'], 500);

            $result = [];
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $result[] = $row;
            }

            return response()->json(['state' => true, 'data' => $result, 'script' => $script]);
        } catch (Exception $e) {
            return response()->json(['state' => false, 'message' => 'Error en la conexión', 'error' => $e->getMessage()], 500);
        }
    }


}


// select c.idAss,count(c.idCou) as cant
// from court c
// 	left join activation ac on c.idCou=ac.idCou
// group by c.idAss;
