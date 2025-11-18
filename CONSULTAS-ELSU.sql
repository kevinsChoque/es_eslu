
PreMzn='10' and PreLote='10'

select * from lectura1
select * from HISLEC where PreMzn='10' and PreLote='10' order by HmedlecFe desc
---hmedlec hislec
registrar
lect anterior
medfecha 2025-02-24 00:00:00.000 24 de cada mes
fecant restarle 1 mes al de arriba
consumo, consumog= resta de lectura y anteror
promedio lo q yo saco


SELECT
    c.PreMzn AS code,
    c.PreLote AS cod,
    c.InscriNro AS numberInscription,
    c.Clinomx AS client,
    rz.CalTip AS streetType,
    rz.CalTip + ' ' + rz.CalDes AS streetDescription,
    i.Tarifx AS rate,
    l.MedCodNro AS meter,
    h.hmedlec AS lastReading,
    h.HmedlecFe AS lastReadingDate
FROM LECTURA1 l
INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
LEFT JOIN (
    SELECT h1.InscriNry, h1.hmedlec, h1.HmedlecFe
    FROM HISLEC h1
    WHERE h1.HmedlecFe = (
        SELECT MAX(h2.HmedlecFe)
        FROM HISLEC h2
        WHERE h2.InscriNry = h1.InscriNry
    )
) h ON h.InscriNry = l.InscriNro
WHERE c.InscriNro IS NOT NULL AND l.FlatEslu IS NULL AND c.PreMzn IN (10)
ORDER BY c.PreMzn, c.PreLote






SELECT
    c.PreMzn AS code,
    c.PreLote AS cod,
    c.InscriNro AS numberInscription,
    c.Clinomx AS client,
    rz.CalTip AS streetType,
    rz.CalTip + ' ' + rz.CalDes AS streetDescription,
    i.Tarifx AS rate,
    l.MedCodNro AS meter,
    l.LectAnt AS lecOld2,
    h.hmedlec AS lecOld,
    h.HmedlecFe
FROM LECTURA1 l
INNER JOIN CONEXION c ON l.InscriNro = c.InscriNro
LEFT JOIN INSCRIPC i ON i.InscriNro = c.InscriNro
LEFT JOIN rzcalle rz ON rz.calcod = c.precalle
LEFT JOIN (
SELECT h1.InscriNry, h1.hmedlec, h1.HmedlecFe
FROM HISLEC h1
WHERE h1.HmedlecFe = (
    SELECT MAX(h2.HmedlecFe)
    FROM HISLEC h2
    WHERE h2.InscriNry = h1.InscriNry
)
) h ON h.InscriNry = l.InscriNro
WHERE l.FlatEslu = '211_2_2025'
ORDER BY c.PreMzn, c.PreLote

select * from LECTURA1 where FlatEslu='2_2025'

select LecAntEslu,FlatEslu,* from LECTURA1 where FlatEslu is not null

UPDATE LECTURA1 lec
SET lec.LecAntEslu = (
    SELECT MAX(h.hmedlec)
    FROM HISLEC h
	where h.PreMzn ='10' and h.PreLote ='10'
    WHERE h.InscriNry = lec.InscriNro
);
---
SELECT h1.InscriNry, h1.hmedlec, h1.HmedlecFe
FROM HISLEC h1
WHERE h1.HmedlecFe = (
    SELECT top 1 HmedLec
    FROM HISLEC h2
    WHERE h2.InscriNry = h1.InscriNry
	order by h2.HmedlecFe desc
)
---
select * from LECTURA1 l
inner join HISLEC h on l.InscriNro=h.InscriNry
where h.HmedLec = (
    SELECT top 1 HmedLec
    FROM HISLEC h2
    WHERE h2.InscriNry = h.InscriNry
	order by h2.HmedlecFe desc
)

select * from HISLEC
---
SELECT
    l.PreMzn,
	l.PreLote,
	l.LecAntEslu,
    h.hmedlec,
    h.HmedlecFe,
	CASE WHEN l.LecAntEslu = h.hmedlec THEN 'correcto' ELSE 'incorrecto' END AS estado
FROM LECTURA1 l
LEFT JOIN HISLEC h
    ON h.InscriNry = l.InscriNro
    AND h.HmedlecFe = (
        SELECT MAX(h2.HmedlecFe)
        FROM HISLEC h2
        WHERE h2.InscriNry = l.InscriNro
    )
	order by l.PreMzn,l.PreLote



-------
UPDATE LECTURA1
SET LecAntEslu = h.hmedlec
FROM LECTURA1 l
LEFT JOIN HISLEC h
    ON h.InscriNry = l.InscriNro
    AND h.HmedlecFe = (
        SELECT MAX(h2.HmedlecFe)
        FROM HISLEC h2
        WHERE h2.InscriNry = l.InscriNro
    );

--------------------------
ALTER TABLE LECTURA1 ADD LecAntEslu int
ALTER TABLE LECTURA1 ADD FlatEslu varchar (99)





----------------------
----------------------
----------------------
----------------------
----------------------
----------------------
select * from lectura1
hfechorl
LFecHorL

select * from LECTURA1 where InscriNro='00037796' or InscriNro='00046844'

select * from lectura1 where FlatEslu is not null

update lectura1 set FlatEslu=null

select PreMzn,count(InscriNro) as cant from LECTURA1 group by PreMzn order by cant

select InscriNro,FlatEslu,LecMed,MedObsCod,LectAnt,LFecHorL,* from LECTURA1 where InscriNro='00046844'

select MedObsCod, count(InscriNro) from LECTURA1 where MedObsCod!=0 group by MedObsCod

select * from OBSLEC where MedObsDes like '%error%'

select top 3 HmedLec,HmedlecFe,* from HISLEC where PreMzn='10' and PreLote='10' order by HmedlecFe desc
select top 3 FlatEslu,LecAntEslu,* from LECTURA1 where PreMzn='10' and PreLote='10' order by HmedlecFe desc


select * from LECTURA1 where InscriNro='00011426'
