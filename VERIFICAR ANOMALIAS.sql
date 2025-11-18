select * from LECTURA1


select FlatEslu,LectAnt,* from LECTURA1 where PreMzn='80'
update LECTURA1 set LecAntEslu=null, FlatEslu=null
SELECT 
    c.PreMzn AS code,
    c.PreLote AS cod,
    c.InscriNro AS numberInscription,
    c.Clinomx AS client,
    rz.CalTip AS streetType,
    rz.CalTip + ' ' + rz.CalDes AS streetDescription,
    i.Tarifx AS rate,
    l.MedCodNro AS meter,
    h.HmedLec AS lastReading
FROM 
    LECTURA1 l
    INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
    LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
    LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
    OUTER APPLY (
        SELECT TOP 1 HmedLec
        FROM HISLEC h
        WHERE h.InscriNry = l.InscriNro
        ORDER BY h.HmedOpeFe DESC
    ) h
WHERE 
    c.InscriNro IS NOT NULL
    --AND l.FlatEslu IS NULL
    AND c.PreMzn IN ('80')
ORDER BY 
    c.PreMzn, 
    c.PreLote;
---
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
WHERE l.FlatEslu = '229_2_2025'
ORDER BY c.PreMzn, c.PreLote

select * from LECTURA1 where InscriNro='00008906'

SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = 'LECTURA1';

select MedFlag,count(InscriNro) from lectura1 group by MedFlag

---REPORTE DE LECTURA JUNIO
select PreMzn,count(InscriNro) as 'lecturas ingresadas' from LECTURA1 where LecMed !=0 and FlatEslu is not null group by PreMzn order by PreMzn

select PreMzn,count(InscriNro) as 'lecturas ingresadas' from LECTURA1 where FlatEslu is not null group by PreMzn order by PreMzn

select count(InscriNro) from LECTURA1 where LecMed !=0 and FlatEslu is not null

select count(InscriNro) from LECTURA1 
---editar lectura
select LecMed,* from lectura1 where PreMzn=30 and PreLote=150
---------------------------
select MedFlag,MedFecha,FecAnt,* from LECTURA1 where PreMzn=30 and LecMed !=0

update LECTURA1 set MedFecha = DATEADD(MONTH, 1, MedFecha), FecAnt = DATEADD(MONTH, 1, FecAnt) where PreMzn=30 and PreLote=50


SELECT MedFecha,FecAnt,* 
FROM LECTURA1
WHERE 
				CAST(MedFecha AS DATE) = '2025-05-24' and 
				CAST(FecAnt AS DATE) = '2025-04-24' and
				LecMed !=0 and 
				FlatEslu is not null

select MedFlag,* from LECTURA1 where MedFlag=0 and LecMed !=0 and FlatEslu is not null

select Promedio,VolProm,MedFlag,MedFecha,FecAnt,* from LECTURA1 where LecMed!=0


select * from LECTURA1 where PreMzn=10 order by MedFecha

select * from LECTURA1 where PreMzn=10 and LecMed=0

select * from LECTURA1 where PreMzn=10 and PreLote=5330

/* actualizacion de lectura en codigo
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
		Carbon::create(2025, 6, 24),
		Carbon::create(2025, 5, 24),
		'1',
		trim($r->inscription)];
*/
--- VISUALIZAR LECTURAS DE UNA RUTA
select LectAnt,LecMed,MedObsCod,LFecHorL,Consumo,ConsumoG,Promedio,MedFecha,FecAnt,MedFlag,VolProm,* 
from LECTURA1 where PreMzn=10 and FlatEslu is not null

select HmedLec,* from HISLEC where InscriNry='00063572' order by HmedOpeFe desc

select LectAnt,LecMed,MedObsCod,LFecHorL,Consumo,ConsumoG,Promedio,MedFecha,FecAnt,MedFlag,VolProm
from LECTURA1 where MedFecha != CAST('2025-06-24' AS datetime) and FlatEslu is not null

--- se encontro q llenaron lecturas en cero (AY COSAS RARAS VERIFICAR)
select FlatEslu,LectAnt,LecMed,MedObsCod,LFecHorL,CAST(LFecHorL AS VARCHAR),Consumo,ConsumoG,Promedio,MedFecha,CAST(MedFecha AS VARCHAR),FecAnt,MedFlag,VolProm,*
FROM LECTURA1
WHERE LecMed=0 and MedObsCod=0 and Promedio!=0 and CAST(LFecHorL AS VARCHAR) not like 'Jun % 2025%'
	--(FlatEslu IS NOT NULL and
	--CAST(MedFecha AS VARCHAR) not like 'Jun 24 2025%') or InscriNro='00006578'
	--CAST(MedFecha AS VARCHAR) like 'May 24 2025%')

--- verificando lo de arriba sus 2 ultimos registros
--00006726 dice medidor cambiado(3)
--00006578 medidor enterrado
select InscriNry,HmedLec,* from HISLEC where InscriNry='00006578' order by HmedOpeFe desc

---	actualizar fechas
--UPDATE LECTURA1
--SET FecAnt = DATEADD(MONTH, 1, FecAnt), MedFecha = DATEADD(MONTH, 1, MedFecha)
--WHERE CAST(MedFecha AS VARCHAR) like 'May 24 2025%'

--- actualizar bandera
--update LECTURA1 
--set MedFlag=1
--where InscriNro='00006578'

-----------------------------------------
-----------------------------------------
-----------------------------------------
select 
	CASE 
        WHEN Promedio = VolProm THEN 'Iguales'
        ELSE 'Diferentes'
    END AS Comparacion,
	LectAnt,LecMed,MedObsCod,LFecHorL,Consumo,ConsumoG,Promedio,MedFecha,FecAnt,MedFlag,VolProm,* 
from LECTURA1 where PreMzn=10
--- consulta para verificar si Promedio = VolProm ay algun diferente
select * from (
	select 
	CASE 
        WHEN Promedio = VolProm THEN 'Iguales'
        ELSE 'Diferentes'
    END AS Comparacion,
	LectAnt,LecMed,MedObsCod,LFecHorL,Consumo,ConsumoG,Promedio,MedFecha,FecAnt,MedFlag,VolProm 
	from LECTURA1 
	---where PreMzn=10
) as sub
where sub.Comparacion='Diferentes'
---


select MedFlag,count(InscriNro) from LECTURA1 group by MedFlag
select LectAnt,LecMed,MedObsCod,LFecHorL,Consumo,ConsumoG,Promedio,MedFecha,FecAnt,MedFlag,VolProm,* 
from LECTURA1 where MedFlag=2 and PreMzn=10

select HmedLec,* from HISLEC where InscriNry='00063572' order by HmedOpeFe desc

select * from LECTURA1

select * from CTACTE where InscriNro='00063572'

select * from LECTURA1 where MedFecha != CAST('2025-06-24' AS datetime)





