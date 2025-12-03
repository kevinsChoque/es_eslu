<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

use App\Models\TTecnical;
use App\Models\TAssign;
use App\Models\TEnding;
use App\Models\TCourt;
use App\Models\TActivation;
use App\Models\TEvidence;


class TecnicalController extends Controller
{
    public function actList()
    {
        $activePeriod = TEnding::where('state','1')->first();
        $list = TTecnical::all();
        return response()->json(['state' => true, 'data' => $list]);
    }
    public function procesarObservacion($r)
    {
        if($r->obs==38)
        {
            $conSql = $this->connectionSql();
            $query = "SELECT LecAntEslu FROM LECTURA1 WHERE InscriNro = ?";
            $params = [trim($r->inscription)];
            $stmt = sqlsrv_prepare($conSql, $query, $params);
            if (!$stmt)
                throw new \Exception('Error al preparar la consulta en SQL Server: ' . print_r(sqlsrv_errors(), true));
            if (!sqlsrv_execute($stmt))
                throw new \Exception('Error al ejecutar la consulta en SQL Server: ' . print_r(sqlsrv_errors(), true));
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($row && isset($row['LecAntEslu']))
                return $row['LecAntEslu'];
            throw new \Exception('No se encontraron lecturas para la inscripción proporcionada.');
        }
        else
        {
            if (in_array($r->obs, [5, 6, 13, 40]))
                return ((int) ($this->obtenerPromedioLecturas($r)))+((int) ($r->lecAnt));
            else
                return $r->lec;
        }
    }
    public function obtenerPromedioLecturas($r)
    {
        $conSql = $this->connectionSql();
        $query = "SELECT TOP 6 Hmedcons FROM hislec WHERE InscriNry = ? ORDER BY HmedlecFe DESC";
        $params = [trim($r->inscription)];
        $stmt = sqlsrv_prepare($conSql, $query, $params);
        if (!sqlsrv_execute($stmt))
            throw new \Exception('Error al consultar las lecturas en SQL Server.');
        $sum = 0;
        $count = 0;
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
        {
            $sum += $row['Hmedcons'];
            $count++;
        }
        if ($count === 0)
            throw new \Exception('No se encontraron suficientes lecturas para calcular el promedio.');
        return (int) round($sum / $count);
    }
    public function verificarLectura($r)
    {
        $conSql = $this->connectionSql();
        $query = "SELECT LecAntEslu FROM LECTURA1 WHERE InscriNro = ?";
        $params = [trim($r->inscription)];
        $stmt = sqlsrv_prepare($conSql, $query, $params);
        if (!sqlsrv_execute($stmt) || !($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
            throw new \Exception('Error al consultar o no se encontró la inscripción en SQL Server.');
        }
        // dd($row['LecAntEslu']);
        if ($r->lec <= $row['LecAntEslu'] && empty($r->obs)) {
            throw new \Exception('Error: Si la lectura es menor o igual que la anterior, debe incluir una observación.');
        }
        return true;
    }
    public function actEditarLectura(Request $r)
    {
        // dd($r->all());
        try {
            if($r->lec)
                $consumo = (int) (($r->lec)-($r->lecAnt));
            else
                $consumo = 0;
            $consumog = (float) number_format($consumo, 2, ',', '');
            $promedio = $this->obtenerPromedioLecturas($r);
            $obsValue =  empty($r->obs) || $r->obs==null || $r->obs==666?'0':$r->obs;
// dd($r->all(),$consumo,$consumog,$promedio,$obsValue);
$conSql = $this->connectionSql();
            sqlsrv_begin_transaction($conSql);
            $query = "UPDATE LECTURA1 SET LectAnt = ?,LecMed = ?, MedObsCod = ?, LFecHorL = ?,
                Consumo = ?, ConsumoG = ?, Promedio = ?,
                MedFecha = ?,FecAnt = ?,MedFlag = ? WHERE InscriNro = ?";
            $params = [trim($r->lecAnt),
                trim($r->lec),
                $obsValue,
                Carbon::now(),
                $consumo,
                $consumog,
                $promedio,
                Carbon::create(2025, 11, 24),
                Carbon::create(2025, 10, 24),
                '1',
                trim($r->inscription)];
            $stmt = sqlsrv_prepare($conSql, $query, $params);
            if (!$stmt || !sqlsrv_execute($stmt))
            {
                sqlsrv_rollback($conSql);
                // DB::rollBack();
                return response()->json(['state' => false, 'message' => 'Error al actualizar LECTURA1 en SQL Server.'], 500);
            }
            sqlsrv_commit($conSql);
            // DB::commit();
            return response()->json(['state' => true, 'message' => 'Lectura MODIFICADA, correctamente.']);
        } catch (\Exception $e)
        {
            DB::rollBack(); // Revertir transacción en MySQL
            if (isset($conSql))
                sqlsrv_rollback($conSql); // Revertir cambios en SQL Server
            return response()->json(['state' => false, 'message' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }
    public function actUpdateLectura(Request $r)
    {
        // dd($r->all());
        try {
            if($r->lec)
            {
                $consumo = (int) (($r->lec)-($r->lecAnt));
                $consumog = (float) number_format($consumo, 2, ',', '');
            }
            else
            {
                $consumo = 0;
                $consumog = (float) number_format($consumo, 2, ',', '');
            }
            $promedio = $this->obtenerPromedioLecturas($r);
            $obsValue =  empty($r->obs) || $r->obs==null || $r->obs==666?'0':$r->obs;
            // dd($r->all(),$consumo,$consumog,$promedio,$obsValue);
            $ass = TAssign::find(session('assign')->idAss);
            if (!$ass)
                return response()->json(['state' => false, 'message' => 'Error: No se encontro ninguna asignacion en la sesion.'], 500);
            $lecturas = json_decode($ass->listCutsOld, true);
            $nuevaLista = array_filter($lecturas, function ($lec) use ($r) {
                return $lec['inscription'] !== $r->inscription;
            });
            if (count($lecturas) == count($nuevaLista))
                return response()->json(['state' => false, 'message' => 'Error: Registro no encontrado en la lista de lecturas.'], 500);
            $conSql = $this->connectionSql();
            if (!$conSql)
                return response()->json(['state' => false, 'message' => 'No se pudo establecer conexión con SQL Server.'], 500);
            DB::beginTransaction();
            $ass->cant = count($nuevaLista);
            $ass->listCutsOld = json_encode(array_values($nuevaLista));
            if (!$ass->save())
            {
                DB::rollBack();
                return response()->json(['state' => false, 'message' => 'Error al actualizar ASSIGN en MySQL.'], 500);
            }
            sqlsrv_begin_transaction($conSql);
            $query = "UPDATE LECTURA1 SET LectAnt = ?,LecMed = ?, MedObsCod = ?, LFecHorL = ?,
                Consumo = ?, ConsumoG = ?, Promedio = ?,
                MedFecha = ?,FecAnt = ?,MedFlag = ? WHERE InscriNro = ?";
            $params = [trim($r->lecAnt),
                trim($r->lec),
                $obsValue,
                Carbon::now(),
                $consumo,
                $consumog,
                $promedio,
                Carbon::create(2025, 11, 24),
                Carbon::create(2025, 10, 24),
                '1',
                trim($r->inscription)];
            $stmt = sqlsrv_prepare($conSql, $query, $params);
            if (!$stmt || !sqlsrv_execute($stmt))
            {
                sqlsrv_rollback($conSql);
                DB::rollBack();
                return response()->json(['state' => false, 'message' => 'Error al actualizar LECTURA1 en SQL Server.'], 500);
            }
            sqlsrv_commit($conSql);
            DB::commit();
            return response()->json(['state' => true, 'message' => 'Lectura actualizada, registro eliminado de la lista y cantidad disminuida correctamente.']);
        } catch (\Exception $e)
        {
            DB::rollBack(); // Revertir transacción en MySQL
            if (isset($conSql))
                sqlsrv_rollback($conSql); // Revertir cambios en SQL Server
            return response()->json(['state' => false, 'message' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }
    public function actUpdateLectura_b(Request $r)
    {
        try {
            // dd($r->all());
            if (!(in_array($r->obs, [5, 6, 13, 40, 38])))
            {
                // dd($r->all(),(int) (($r->lec)-($r->lecAnt)),(float) number_format((int) (($r->lec)-($r->lecAnt)), 2, ',', ''));
                $this->verificarLectura($r);
                $consumo = (int) (($r->lec)-($r->lecAnt));
                $consumog = (float) number_format($consumo, 2, ',', '');
                // dd($consumo,$consumog);
            }
            else
            {
                $consumo = 0;
                $consumog = (float) number_format($consumo, 2, ',', '');
            }
            // dd($r->all(),'fuera del if');
            $promedio = $this->obtenerPromedioLecturas($r);
            // $obsValue = !empty($r->obs) && $r->obs !== "666" ? trim($r->obs) : "0";
            // $obsValue = (!empty($r->obs) && $r->obs !== "666") ? $this->procesarObservacion($r) : "0";
            if(!empty($r->obs) && $r->obs !== "666")
            {
                $r->lec = $this->procesarObservacion($r);
                $obsValue =  trim($r->obs);
            }
            else
            {
                $obsValue = '0';
            }
            $ass = TAssign::find(session('assign')->idAss);
            if (!$ass)
                return response()->json(['state' => false, 'message' => 'Error: No se encontro ninguna asignacion en la sesion.'], 500);
            $lecturas = json_decode($ass->listCutsOld, true);
            $nuevaLista = array_filter($lecturas, function ($lec) use ($r) {
                return $lec['inscription'] !== $r->inscription;
            });
            if (count($lecturas) == count($nuevaLista))
                return response()->json(['state' => false, 'message' => 'Error: Registro no encontrado en la lista de lecturas.'], 500);
            $conSql = $this->connectionSql();
            if (!$conSql)
                return response()->json(['state' => false, 'message' => 'No se pudo establecer conexión con SQL Server.'], 500);
            DB::beginTransaction();
            $ass->cant = count($nuevaLista);
            $ass->listCutsOld = json_encode(array_values($nuevaLista));
            if (!$ass->save())
            {
                DB::rollBack();
                return response()->json(['state' => false, 'message' => 'Error al actualizar ASSIGN en MySQL.'], 500);
            }
            sqlsrv_begin_transaction($conSql);
            $query = "UPDATE LECTURA1 SET LectAnt = ?,LecMed = ?, MedObsCod = ?, LFecHorL = ?,
                Consumo = ?, ConsumoG = ?, Promedio = ?,
                MedFecha = ?,FecAnt = ? WHERE InscriNro = ?";
            $params = [trim($r->lecAnt),trim($r->lec),$obsValue,Carbon::now(),
                $consumo,$consumog,$promedio,
                Carbon::create(2025, 2, 24),Carbon::create(2025, 1, 24),trim($r->inscription)];
            $stmt = sqlsrv_prepare($conSql, $query, $params);
            if (!$stmt || !sqlsrv_execute($stmt))
            {
                sqlsrv_rollback($conSql);
                DB::rollBack();
                return response()->json(['state' => false, 'message' => 'Error al actualizar LECTURA1 en SQL Server.'], 500);
            }
            sqlsrv_commit($conSql);
            DB::commit();
            return response()->json(['state' => true, 'message' => 'Lectura actualizada, registro eliminado de la lista y cantidad disminuida correctamente.']);
        } catch (\Exception $e)
        {
            DB::rollBack(); // Revertir transacción en MySQL
            if (isset($conSql))
                sqlsrv_rollback($conSql); // Revertir cambios en SQL Server
            return response()->json(['state' => false, 'message' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }
    public function actAssign(Request $r)
    {
        try{
            $flat = $r->idTec.'_'.Carbon::now()->year;
            $filter = Session::get('lastFilter');
            $r->merge(['idEnd' => TEnding::where('state',1)->orderBy('idEnd', 'desc')->first()->idEnd]);
            $r->merge(['flat' => $flat]);
            $r->merge(['filter' => $filter]);
            $r->merge(['routes' => Session::get('routes')]);
            $r->merge(['dr' => Carbon::now()]);
            $idAss = TAssign::insertGetId($r->all());
            if($idAss)
            {
                $conSql = $this->connectionSql();
                if($conSql)
                {
                    $flat = $idAss.'_'.$flat;
                    $stringLimpio = str_replace("c.", "", Session::get('lastFilter'));
                    $script = "UPDATE LECTURA1 SET FlatEslu = '".$flat."' ".$stringLimpio." and FlatEslu is null";
                    $stmt = sqlsrv_query($conSql, $script);
                    if($stmt)
                    {
                        $filter = str_replace("and i.CourtEscn is null", " ", $filter);
                        $script = "SELECT
                                    c.PreMzn AS code,
                                    c.PreLote AS cod,
                                    c.InscriNro AS numberInscription,
                                    c.Clinomx AS client,
                                    rz.CalTip AS streetType,
                                    rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                                    i.Tarifx AS rate,
                                    l.MedCodNro AS meter,
                                    l.LectAnt AS lecOld3,
                                    l.LecAntEslu AS lecOld2,
                                    h.HmedLec AS lecOld
                            FROM LECTURA1 l
                                INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
                                LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
                                LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
                                OUTER APPLY (
                                    SELECT TOP 1 HmedLec
                                    FROM HISLEC h
                                    WHERE h.InscriNry = l.InscriNro
                                    ORDER BY h.HmedOpeFe DESC
                                ) h
                            WHERE l.FlatEslu = '".$flat."'
                            ORDER BY c.PreMzn, c.PreLote";
                        //     $script="
                        //         SELECT
                        //             c.PreMzn AS code,
                        //             c.PreLote AS cod,
                        //             c.InscriNro AS numberInscription,
                        //             c.Clinomx AS client,
                        //             rz.CalTip AS streetType,
                        //             rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                        //             i.Tarifx AS rate,
                        //             l.MedCodNro AS meter,
                        //             l.LectAnt AS lecOld3,
                        //             l.LecAntEslu AS lecOld2,
                        //             h.HmedLec AS lecOld
                        //         FROM LECTURA1 l
                        //         left JOIN CONEXION c ON l.InscriNro = c.InscriNro
                        //         LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
                        //         LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
                        //         LEFT JOIN (
                        //             SELECT InscriNry, HmedLec,
                        //                    ROW_NUMBER() OVER (PARTITION BY InscriNry ORDER BY HmedOpeFe DESC) AS rn
                        //             FROM HISLEC
                        //         ) h ON h.InscriNry = l.InscriNro AND h.rn = 1
                        //         WHERE l.PreMzn = '24'
                        //         ORDER BY c.PreMzn, c.PreLote;";
                        $scriptCant = "select count(*) as cant from LECTURA1 where FlatEslu='".$flat."'";
                        $stmt = sqlsrv_query($conSql, $script);
                        $stmtCant = sqlsrv_query($conSql, $scriptCant);
                        $rowCant = sqlsrv_fetch_array( $stmtCant, SQLSRV_FETCH_ASSOC);

                        // $data = array();
                        // while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) )
                        // {   $data[] = $row;}
                        // $listCutsOld = [];
                        // for ($i = 0; $i < count($data); $i++) {
                        //     $listCutsOld[] = [
                        //         "code" => $data[$i]['code'],
                        //         "cod" => $data[$i]['cod'],
                        //         "inscription" => $data[$i]['numberInscription'],
                        //         "client" => $data[$i]['client'],
                        //         "streetType" => $data[$i]['streetType'],
                        //         "streetDescription" => $data[$i]['streetDescription'],
                        //         "rate" => $data[$i]['rate'],
                        //         "meter" => $data[$i]['meter'],
                        //         "lecOld" => $data[$i]['lecOld'],
                        //         "lec" => '',
                        //         "obs" => '',
                        //     ];
                        // }
                        $listCutsOld = [];
                        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $listCutsOld[] = [
                                "code"              => $row['code'],
                                "cod"               => $row['cod'],
                                "inscription"       => $row['numberInscription'],
                                "client"            => $row['client'],
                                "streetType"        => $row['streetType'],
                                "streetDescription" => $row['streetDescription'],
                                "rate"              => $row['rate'],
                                "meter"             => $row['meter'],
                                "lecOld"            => $row['lecOld'],
                                "lec"               => '',
                                "obs"               => '',
                            ];
                        }
                        // $ass=TAssign::where('idTec',$ass->idTec)->where('idEnd',$ass->idEnd)->first();
                        $ass = TAssign::find($idAss);
                        $ass->listCutsOld = json_encode($listCutsOld, JSON_PRETTY_PRINT);
                        $ass->flat = $flat;
                        $ass->cant = $rowCant['cant'];
                        $ass->save();
                        // realizar la consulta
                        return response()->json(['state' => true, 'message' => 'Se realizó la asignación correctamente']);
                    }
                    else
                    {
                        throw new \Exception('Error al momento de actualizar: ' . print_r(sqlsrv_errors(), true));
                        // return response()->json(['state' => false, 'message' => 'Error al momento de actualizar CORTES: ' . print_r(sqlsrv_errors(), true)]);
                    }
                }
                else
                {
                    // return response()->json(['state' => false, 'message' => 'Ocurrio un error en la conexion al sistema.']);
                    throw new \Exception('Ocurrió un error en la conexión al sistema.');
                }
            }
            else
            {
                throw new \Exception('No fue posible crear una asignación.');
                // return response()->json(['state' => false, 'message' => 'No fue posible crear una asignacion.']);
            }
        }
        catch (\Exception $e) {
            return response()->json(['state' => false, 'message' => $e->getMessage()]);
        }
    }
    public function verifyListCutsOld($inscription)
    {
        $data = json_decode(Session::get('assign')->listCutsOld, true);
        if (json_last_error() !== JSON_ERROR_NONE)
        {
            dd('Error al decodificar JSON');
            // return ['state' => false, 'checked' => false, 'message' => 'Error al decodificar JSON'];
        }
        $found = null;
        foreach ($data as $element)
        {
            if ($element['numberInscription'] == $inscription)
            {
                $found = $element;
                break;
            }
        }
        if ($found)
        {
            // dd("Elemento encontrado: ",$found);
            return ['state' => true, 'reg' => $found];
        }
        else
            dd("Elemento no encontrado para el número de inscripción $numeroInscripcionABuscar.\n");
    }


    public function actShowAssignTecnical(Request $r)
    {
        // dd('cascacsac csaca vdsv');
        return view('assign.list');
    }
    public function actListCut(Request $r)
    {
        // quiero sacar el assign de la variable de sesion q ya existe con su id quiero sacarlo
        // dd(Session::get('assign'));
        if (!Session::get('assign'))
            return response()->json(['state' => false,'message' => 'El tecnico aun no cuenta con asignacion.']);
        $listCut = TAssign::find(Session::get('assign')->idAss);
        return response()->json(['state' => true, 'data' => $listCut->listCutsOld]);
    }
    public function actListCutdt_old()
    {
$inicio = microtime(true);   // ⏱ INICIO
        if (!Session::get('assign'))
            return response()->json(['data' => [],'error' => 'El técnico aún no cuenta con asignación.']);
        $conSql = $this->connectionSql();
        $query = "
            SELECT
                c.PreMzn AS code,
                c.PreLote AS cod,
                c.InscriNro AS numberInscription,
                c.Clinomx AS client,
                rz.CalTip AS streetType,
                rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                i.Tarifx AS rate,
                l.MedCodNro AS meter,
                l.LectAnt AS lecOld3,
                l.LecAntEslu AS lecOld2,
                h.HmedLec AS lecOld,
                l.LFecHorL,
                l.LecMed,
                l.MedObsCod as obs,
                l.InscriNro as inscription
            FROM LECTURA1 l
            INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
            LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
            LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
            OUTER APPLY (
                SELECT TOP 1 HmedLec
                FROM HISLEC h
                WHERE h.InscriNry = l.InscriNro
                ORDER BY h.HmedOpeFe DESC
            ) h
            WHERE l.FlatEslu = '".Session::get('assign')->flat."' and MedFlag=1
            ORDER BY l.LFecHorL desc";
        $stmt = sqlsrv_prepare($conSql, $query);
        if (!$stmt)
            return response()->json(['state' => false, 'data' => [], 'error' => 'Error al preparar la consulta: ' . print_r(sqlsrv_errors(), true)]);
        if (!sqlsrv_execute($stmt))
            return response()->json(['state' => false, 'data' => [],'error' => 'Error al ejecutar la consulta: ' . print_r(sqlsrv_errors(), true)]);
        $data = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {$data[] = $row;}
$fin = microtime(true); // ⏱ FIN
$duracion = round($fin - $inicio, 4); // segundos, con 4 decimales
    // Responder en formato DataTables
return response()->json([
    'data' => $data,
    'state' => true,
    'tiempo' => $duracion . ' segundos'
]);
        return response()->json(['data' => $data, 'state' => true]);
    }
    public function actListCutdt(Request $request)
    {
        $inicio = microtime(true);

        if (!Session::get('assign')) {
            return response()->json(['state' => false, 'data' => [], 'error' => 'El técnico aún no cuenta con asignación.']);
        }

        // ⬅️ Datos para paginación
        $page = intval($request->page ?? 1);
        $perPage = intval($request->per_page ?? 3);
        $offset = ($page - 1) * $perPage;

        $conSql = $this->connectionSql();

        // =======================
        // 🔹 1. Obtener total
        // =======================
        $queryTotal = "
            SELECT COUNT(*) AS total
            FROM LECTURA1
            WHERE FlatEslu = '" . Session::get('assign')->flat . "'
            AND MedFlag = 1
        ";

        $stmtTotal = sqlsrv_query($conSql, $queryTotal);
        $rowTotal = sqlsrv_fetch_array($stmtTotal, SQLSRV_FETCH_ASSOC);
        $total = $rowTotal['total'];

        // =======================
        // 🔹 2. Query paginada
        // =======================
        $query = "
            SELECT
                c.PreMzn AS code,
                c.PreLote AS cod,
                c.InscriNro AS numberInscription,
                c.Clinomx AS client,
                rz.CalTip AS streetType,
                rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                i.Tarifx AS rate,
                l.MedCodNro AS meter,
                l.LectAnt AS lecOld3,
                l.LecAntEslu AS lecOld2,
                h.HmedLec AS lecOld,
                l.LFecHorL,
                l.LecMed,
                l.MedObsCod as obs,
                l.InscriNro as inscription
            FROM LECTURA1 l
            INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
            LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
            LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
            OUTER APPLY (
                SELECT TOP 1 HmedLec
                FROM HISLEC h
                WHERE h.InscriNry = l.InscriNro
                ORDER BY h.HmedOpeFe DESC
            ) h
            WHERE l.FlatEslu = '" . Session::get('assign')->flat . "'
            AND MedFlag = 1
            ORDER BY l.LFecHorL DESC
            OFFSET {$offset} ROWS FETCH NEXT {$perPage} ROWS ONLY
        ";

        $stmt = sqlsrv_query($conSql, $query);
        $data = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = $row;
        }

        $fin = microtime(true);
        $duracion = round($fin - $inicio, 4);

        return response()->json([
            'state' => true,
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'tiempo' => $duracion . ' segundos'
        ]);
    }




    public function actListCut2(Request $r)
    {
        // quiero sacar el assign de la variable de sesion q ya existe con su id quiero sacarlo
        // dd(Session::get('assign')->idAss);
        $listCut = TAssign::find($r->idAss);
        session(['assign' => $listCut]);
        // dd($listCut->listCutsOld);
        return response()->json(['state' => true, 'data' => $listCut->listCutsOld]);
    }
    public function actUpdateRecords(Request $r)
    {
        // dd($r->all());
        $ass = TAssign::find(Session::get('assign')->idAss);
        $ass->listCutsOld = $r->data;
        if($ass->save())
            return response()->json(['state' => true, 'message' => "Se actualizo la informacion local."]);
        return response()->json(['state' => false, 'message' => "Error"]);

    }
    public function actShowAsignacion_eli()
    {
        if (!Session::get('assign'))
            return response()->json(['state' => false,'message' => 'El tecnico aun no cuenta con asignacion.']);
        $conSql = $this->connectionSql();
        $query = "
            SELECT
                c.PreMzn AS code,
                c.PreLote AS cod,
                c.InscriNro AS numberInscription,
                c.Clinomx AS client,
                rz.CalTip AS streetType,
                rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                i.Tarifx AS rate,
                l.MedCodNro AS meter,
                l.LectAnt AS lecOld3,
                l.LecAntEslu AS lecOld2,
                h.HmedLec AS lecOld
            FROM LECTURA1 l
            INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
            LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
            LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
            OUTER APPLY (
                SELECT TOP 1 HmedLec
                FROM HISLEC h
                WHERE h.InscriNry = l.InscriNro
                ORDER BY h.HmedOpeFe DESC
            ) h
            WHERE l.FlatEslu = ?
            ORDER BY c.PreMzn, c.PreLote";

        $params = [Session::get('assign')->flat];
        $stmt = sqlsrv_prepare($conSql, $query, $params);
        if (!$stmt)
            throw new \Exception('Error al preparar la consulta: ' . print_r(sqlsrv_errors(), true));
        if (!sqlsrv_execute($stmt))
            throw new \Exception('Error al ejecutar la consulta: ' . print_r(sqlsrv_errors(), true));
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    }
    public function actShowAsignacion()
    {
        if (!Session::get('assign'))
            return response()->json(['state' => false,'message' => 'El técnico aún no cuenta con asignación.']);
        $conSql = $this->connectionSql();
        $query = "
            SELECT
                c.PreMzn AS code,
                c.PreLote AS cod,
                c.InscriNro AS numberInscription,
                c.Clinomx AS client,
                rz.CalTip AS streetType,
                rz.CalTip + ' ' + rz.CalDes AS streetDescription,
                i.Tarifx AS rate,
                l.MedCodNro AS meter,
                l.LectAnt AS lecOld3,
                l.LecAntEslu AS lecOld2,
                h.HmedLec AS lecOld
            FROM LECTURA1 l
            INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
            LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
            LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
            OUTER APPLY (
                SELECT TOP 1 HmedLec
                FROM HISLEC h
                WHERE h.InscriNry = l.InscriNro
                ORDER BY h.HmedOpeFe DESC
            ) h
            WHERE l.FlatEslu = ?
            ORDER BY c.PreMzn, c.PreLote
        ";

        $params = [Session::get('assign')->flat];
        $stmt = sqlsrv_prepare($conSql, $query, $params);

        if (!$stmt)
            throw new \Exception('Error al preparar la consulta: ' . print_r(sqlsrv_errors(), true));
        if (!sqlsrv_execute($stmt))
            throw new \Exception('Error al ejecutar la consulta: ' . print_r(sqlsrv_errors(), true));
        // Recorremos todos los resultados
        $data = [];
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data[] = [
                "code" => $row['code'],
                "cod" => $row['cod'],
                "inscription" => $row['numberInscription'],
                "client" => $row['client'],
                "streetType" => $row['streetType'],
                "streetDescription" => $row['streetDescription'],
                "rate" => $row['rate'],
                "meter" => $row['meter'],
                "lecOld3" => $row['lecOld3'],
                "lecOld2" => $row['lecOld2'],
                "lecOld" => $row['lecOld'],
                "lec" => '',
                "obs" => '',
            ];
        }

        return response()->json([
            'state' => true,
            'data' => $data
        ], 200, [], JSON_PRETTY_PRINT);
    }


}
