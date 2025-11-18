<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function connectionSql()
    {
        //$serverName = 'KEVIN-O3VME56';
        //$connectionInfo = array("Database"=>"SICEM_AB_m","CharacterSet"=>"UTF-8");
        $serverName = 'informatica2-pc\sicem_bd';
        $connectionInfo = array(
            "Database" => "SICEM_AB",
            "UID" => "comercial",
            "PWD" => "1",
            "CharacterSet" => "UTF-8"
        );
        return sqlsrv_connect($serverName, $connectionInfo);
    }
}
// select * from LECTURA1 where PreMzn='90' or PreMzn='95'

// --por ejemplo este cod catastral, sus 6 ultimas lecturas 13+7+4+6+9+11=50/6=8,33333333
// --7+4+6+9+11+12=49/6=8,16666667 en este caso la lectura1 esta procesado en hislec
// --y esto lo redondea a 8 en lectura1 al momento q ingreso la lectura con el sistema
// select top 7 Hmedcons,* from HISLEC where PreMzn='95' and PreLote='60' order by HmedOpeFe desc
// select promedio,* from LECTURA1 where PreMzn='95' and PreLote='60'
// -----------------------------------------
// select * from LECTURA1 l
// inner join HISLEC h on l.InscriNro=h.InscriNry
// where PreMzn='95' and PreLote='60'
// ----------------------------------------------------------------------
// UPDATE l
// SET
//     l.LectAnt = h.HmedLec,
//     l.Consumo = l.LecMed - h.HmedLec
// FROM LECTURA1 l
// OUTER APPLY (
//     SELECT TOP 1 HmedLec
//     FROM HISLEC h
//     WHERE h.InscriNry = l.InscriNro
//     ORDER BY h.HmedOpeFe DESC
// ) h
// WHERE l.PreMzn = '95' AND l.PreLote = '60'
//   AND h.HmedLec IS NOT NULL;
//   -----------------------
//   ---------------------
//   -----------------
//   -----------------
//   -------------
//   ------------
//   select i.CtaMesActOldEscn as CtaMesActOld,i.StateUserEscn as courtState,t.FacEstado as paid, c.PreMzn as code, c.PreLote as cod,t.InscriNrx as numberInscription, c.Clinomx as client,rz.CalTip as streetType,
//         rz.CalTip + ' ' + rz.CalDes as streetDescription,i.Tarifx as rate, T.FMedidor as meter,i.CtaMesAct as monthDebt, i.CtaFacSal as amount, c.CodTipSer as serviceEnterprise, t.FConsumo as consumption
//             from TOTFAC t INNER JOIN CONEXION c ON t.InscriNrx=c.InscriNro
//             left outer join INSCRIPC i ON i.InscriNro=c.InscriNro
//             left outer join rzcalle rz ON rz.calcod = c.precalle
// where i.CourtEscn='206_5_abril_2025' and t.FacFecFac='01-04-2025' and t.InscriNrx is not null and c.PreMzn in (11)  and c.CodTipSer in (1,2,3)


// select * from LECTURA1 where PreMzn='90' or PreMzn='95'

// --por ejemplo este cod catastral, sus 6 ultimas lecturas 6+6+16+17+12+14=71/6=11,8333333
// --6+16+17+12+14+11=76/6=12,6666667 creo q esto ya no cuenta porq no esta procesado en hislec
// --y esto lo redondea a 12 en lectura1 al momento q ingreso la lectura con el sistema
// select top 7 Hmedcons,* from HISLEC where PreMzn='95' and PreLote='60' order by HmedOpeFe desc
// select promedio,* from LECTURA1 where PreMzn='95' and PreLote='60'
// -----------------------------------------
// SELECT h.HmedOpeFe,h.HmedLec,*
// FROM LECTURA1 l
// OUTER APPLY (
//     SELECT TOP 1 *
//     FROM HISLEC h
//     WHERE h.InscriNry = l.InscriNro
//     ORDER BY h.HmedOpeFe DESC
// ) h
// WHERE l.PreMzn = '95' AND l.PreLote = '60';


