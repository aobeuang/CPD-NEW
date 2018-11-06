select IN_D_PIN,ROWID
from
(
    select ROWID,IN_D_PIN,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 2;
and number_of_coop=null

// check number
select count(*)
from (
    select count(*),IN_D_PIN from moiuser.master_data where OU_D_FLAG in(1) GROUP BY IN_D_PIN
    having count(*)=1
)


//  **************************** update in sequence ****************************
update MOIUSER.MASTER_DATA set number_of_coop=1 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 1 )
commit;


update MOIUSER.MASTER_DATA set number_of_coop=10 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 10 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=10
)
and number_of_coop<10


update MOIUSER.MASTER_DATA set number_of_coop=9 where 
ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 9 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=9
)
and number_of_coop<9;
commit;


update MOIUSER.MASTER_DATA set number_of_coop=8 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 8 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=8
)
and number_of_coop<8;
commit;


update MOIUSER.MASTER_DATA set number_of_coop=7 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 7 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=7
)
and number_of_coop<7;
commit;


update MOIUSER.MASTER_DATA set number_of_coop=6 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 6 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=6
)
and number_of_coop<6;
commit;



update MOIUSER.MASTER_DATA set number_of_coop=5 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 5 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=5
)
and number_of_coop<5;
commit;



update MOIUSER.MASTER_DATA set number_of_coop=4 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 4 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=4
)
and number_of_coop<4;
commit;



update MOIUSER.MASTER_DATA set number_of_coop=3 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 3 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=3
)
and number_of_coop<3;
commit;


update MOIUSER.MASTER_DATA set number_of_coop=2 where ROWID in 
(select ROWID
from
(
    select ROWID,
           row_number() over (partition by IN_D_PIN order by IN_D_MDATE) rn
    from   MOIUSER.MASTER_DATA
)
where rn = 2 );
update  MOIUSER.MASTER_DATA set number_of_coop=null 
where IN_D_PIN in 
(
	select IN_D_PIN from MOIUSER.MASTER_DATA where number_of_coop=2
)
and number_of_coop<2;
commit;







/////1,968,791 rows updated.



2
884,980 rows updated.

3
145,234 rows updated.

4
29,543 rows updated.

5
7,658 rows updated.

6
2,629 rows updated.


//CREATE  PRECAL-REPORT3

CREATE TABLE report
AS(select DISTINCT(KHET_DATA.COL001),COOP_INFO.COOP_NAME_TH,COOP_INFO.ORG_ORG_ID,COOP_INFO.PROVINCE_ID,COOP_INFO.coop_type,COOP_TYPE.TYPE_NAME,
COOP_INFO.AMPHUR_ID,DISTRICT.AMPHUR_NAME,
 KHET_DATA.COL003 as KHET_NAME,KHET_DATA.COL008 as PROVINCE_NAME,KHET_DATA.COL012 as ORG_NAME,KHET_DATA.COL002 as KHET_NUMBER
,a.TOTAL_COOP
from COOP_INFO
left join(
    select  IN_D_COOP, count(IN_D_PIN) as TOTAL_COOP 
     from moiuser.master_data 
     where OU_D_FLAG in (1,2)
     group by IN_D_COOP having DECODE(replace(translate(IN_D_COOP,'1234567890','##########'),'#'),NULL,'NUMBER','NON NUMER') = 'NUMBER'

) a on COOP_INFO.REGISTRY_NO_2 = a.IN_D_COOP
left join KHET_DATA on KHET_DATA.COL011 = COOP_INFO.ORG_ORG_ID
left join COOP_TYPE on COOP_TYPE.TYPE_ID = COOP_INFO.COOP_TYPE
left join DISTRICT on DISTRICT.AMPHUR_ID = COOP_INFO.AMPHUR_ID );