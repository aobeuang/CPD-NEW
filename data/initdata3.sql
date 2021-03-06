INSERT ALL 
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (1,'01001','เลี้ยงสัตว์','โคเนื้อ','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (2,'01008','เลี้ยงสัตว์','กระบือ','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (3,'01003','เลี้ยงสัตว์','สุกร','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (4,'01004','เลี้ยงสัตว์','แพะ','h')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (5,'01005','เลี้ยงสัตว์','ไก่','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (6,'01006','เลี้ยงสัตว์','เป็ด','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (7,'01099','เลี้ยงสัตว์','อื่น ๆ','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (8,'02001','ประมง','ปลาดุก','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (9,'02002','ประมง','ปลาสวาย','h')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (10,'02003','ประมง','ปลาทับทิม','h')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (11,'02004','ประมง','ปลานิล','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (12,'02099','ประมง','ปลาอื่น ๆ','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (13,'01002','เลี้ยงสัตว์','โคนม','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (14,'02005','ประมง','ปลาช่อน','s')
INTO TYPE_ANIMAL(ID_NO,ID_AN, AN_TYPE,AN_NAME,SHOW_F ) VALUES (15,'01007','เลี้ยงสัตว์','นกกระทา','s')
SELECT * FROM DUAL;

INSERT ALL 
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (1,1001,'ปุ๋ยเคมี','สูตร 46-0-0','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (2,1002,'ปุ๋ยเคมี','สูตร 15-15-15','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (3,1003,'ปุ๋ยเคมี','สูตร 16-20-0','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (4,1004,'ปุ๋ยเคมี','สูตร 13-13-21','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (5,1010,'ปุ๋ยเคมี','อื่น ๆ','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (6,2001,'ปุ๋ยอินทรีย์','ปุ๋ยอินทรีย์','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (7,3001,'เคมีเกษตร','ยาปราบศัตรูพืช','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (8,3002,'เคมีเกษตร','ยาปราบวัชพืช','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (9,4001,'เมล็ดพันธุ์','เมล็ดพันธุ์','s')
INTO TYPE_INFRA_USE(ID_NO,ID_TYPE,INFRA_TYPE,TYPEDET,SHOW_F ) VALUES (10,3099,'เคมีเกษตร','อื่น ๆ','s')
SELECT * FROM DUAL;

INSERT ALL 
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (1,1001,'สหกรณ์/กลุ่มเกษตรกร')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (2,1002,'ธกส.')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (3,1003,'ธนาคารอื่น ๆ')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (4,1004,'กองทุนหมู่บ้าน')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (5,1005,'พ่อค้าคนกลาง/นายทุน')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (6,1006,'ญาติ/เพื่อนบ้าน')
INTO TYPE_LOAN(ID_NO,ID_LONE,LOAN_NAME) VALUES (7,1007,'อื่น ๆ')
SELECT * FROM DUAL;

INSERT ALL 
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('1','10001','ข้าว','ข้าวชัยนาท','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('2','10002','ข้าว','ข้าวสุพรรณ','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('3','10003','ข้าว','ข้าวหอมมะลิ(105)','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('4','10099','ข้าว','ข้าวอื่น ๆ','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('5','20001','มันสำปะหลัง','มันสำปะหลังระยอง 5,7,9','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('6','20002','มันสำปะหลัง','มันสำปะหลังเกษตรศาสตร์ 50','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('7','20003','มันสำปะหลัง','มันสำปะหลังห้วยบง 60','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('8','20099','มันสำปะหลัง','มันสำปะหลังอื่น ๆ','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('9','30001','ข้าวโพด','ข้าวโพดคาร์กิลล์','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('10','30002','ข้าวโพด','ข้าวโพดซีพี','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('11','30003','ข้าวโพด','ข้าวโพดนครสวรรค์','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('12','30099','ข้าวโพด','ข้าวโพดอื่น ๆ','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('13','90001','ข้าวฟ่าง','ข้าวฟ่าง','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('14','90002','งา','งา','h')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('15','10004','ข้าว','ข้าวเจ้า กข.15','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('16','10005','ข้าว','ข้าวเหนียว กข.6','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('17','10006','ข้าว','ข้าวพิษณุโลก 2','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('18','10007','ข้าว','ข้าวเหนียวสันป่าตอง(กข.10)','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('19','30004','ข้าวโพด','ข้าวโพดแปซิฟิก 999','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('20','30005','ข้าวโพด','ข้าวโพดซีพี 888','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('21','30006','ข้าวโพด','ข้าวโพดมอนซานโต 919','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('22','30007','ข้าวโพด','ข้าวโพดไพโอเนีย ว.87','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('23','30008','ข้าวโพด','ข้าวโพดไพโอเนีย B.80','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('24','30010','ข้าวโพด','ข้าวโพดไพโอเนีย BP.89','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('25','30011','ข้าวโพด','ข้าวโพดซูก้า 75','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('26','30012','ข้าวโพด','ข้าวโพด A.P.S.5','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('27','31001','ถั่วเหลือง','ถั่วเหลืองเชียงใหม่  60','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('28','91001','ยางพารา','ยางพารา M666','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('29','40001','ลำไย','ลำไยอีดอ','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('30','41001','ลิ้นจี่','ลิ้นจี่ฮงอวย','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('31','41002','ลิ้นจี่','ลิ้นจี่จักรพรรดิ','s')
INTO TYPE_PLANT(ID_NO,ID_PLANT,PLANT_TYPE,PLANT_NAME,SHOW_F) VALUES ('32','41003','ลิ้นจี่','ลิ้นจี่โอเชียะ','s')
SELECT * FROM DUAL;


