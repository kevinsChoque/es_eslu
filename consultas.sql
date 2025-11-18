---consulta para ver los etiquetados por programa
select CourtEscn,* from INSCRIPC where CourtEscn is not null
---limpiar de los etiquetados por programa
update INSCRIPC set 
CourtEscn=null,
CtaMesActOldEscn=null,
StateUserEscn=null
---verificar cargo
select top 666 * from CARGOS order by CargoNro desc
---ver el registro si pago
SELECT CourtEscn,StateUserEscn,CtaMesActOldEscn,CtaMesAct,* from INSCRIPC where InscriNro='00075963'
---pagar recibo
update INSCRIPC set CtaMesAct=0 where InscriNro='00004920'
---mostrar lista por etiqueta
select CourtEscn,StateUserEscn,CtaMesActOldEscn,CtaMesAct,* from INSCRIPC where CourtEscn='158_2_junio_2024'


------------------------------
select CourtEscn,CtaMesActOldEscn,StateUserEscn,* from INSCRIPC where CourtEscn is not null

update INSCRIPC set CourtEscn=null,CtaMesActOldEscn=null,StateUserEscn=null 

select i.CtaMesActOldEscn as CtaMesActOld,i.StateUserEscn as courtState,t.FacEstado as paid, c.PreMzn as code, c.PreLote as cod,t.InscriNrx as numberInscription, c.Clinomx as client,rz.CalTip as streetType,
rz.CalTip + ' ' + rz.CalDes as streetDescription,i.Tarifx as rate, T.FMedidor as meter,i.CtaMesAct as monthDebt, i.CtaFacSal as amount, c.CodTipSer as serviceEnterprise, t.FConsumo as consumption
    from TOTFAC t INNER JOIN CONEXION c ON t.InscriNrx=c.InscriNro
    left outer join INSCRIPC i ON i.InscriNro=c.InscriNro
    left outer join rzcalle rz ON rz.calcod = c.precalle
where t.InscriNrx is not null and i.CourtEscn is null  and c.PreMzn in (80,81,70,71,72,73,82)  and t.FacFecFac='01-09-2024'  and i.CtaMesAct >=3  and t.FacEstado=0   and c.CodTipSer in (1,2,3)  order by c.PreMzn, c.PreLote


update INSCRIPC set StateUserEscn=null 


select * from CARGOS order by cargonro desc

1509557

select * from docum whe

update docum set UltNro='1509557' where DocTip='cargo'
---
select CtaMesAct,* from INSCRIPC where InscriNro='00131564'

update INSCRIPC set CtaMesAct=0 where InscriNro='00131564'


