<?php  

putenv("LD_LIBRARY_PATH=/devphp/oracle_client");
putenv("ORACLE_HOME=/devphp/oracle_client");
putenv("DYLD_LIBRARY_PATH=/devphp/oracle_client");
putenv("TNS_ADMIN=/devphp/oracle_client/networks/admin");


phpinfo();

die();

try {
	$hostname = "54.251.97.78";
	$port = 1433;
	$dbname = "member2561";
	$username = "analytic";
	$CHAR_SET = "charset=utf8"; // เช็ตให้อ่านภาษาไทยได้
	$pw = "analytic";
	$dbh = new PDO ("dblib:version=7.0;host=$hostname:$port;dbname=$dbname;$CHAR_SET","$username","$pw");
} catch (PDOException $e) {
	echo "Failed to get DB handle: " . $e->getMessage() . "\n";
	exit;
}

$stmt = $dbh->prepare("select * from  ta_member where D_PIN='3160100651961'");
$stmt->execute();
while ($row = $stmt->fetch()) {
	print_r($row);
}
unset($dbh); unset($stmt);


///

exec("export ORACLE_HOME=/usr/lib/oracle/12.2/client64/; export LD_LIBRARY_PATH=/usr/lib/oracle/12.2/client64/lib; export PATH=\$PATH:/usr/lib/oracle/12.2/client64/bin; export TNS_ADMIN=/usr/lib/oracle/12.2/client64/network/admin ;cd /var/www/html; echo \$ORACLE_HOME; echo \$PATH;  sqlldr ANALYTICDEV/AD12bd0WOR_d@CPDANALYTICS control=mahadthai.ctl,log=test.log;", $a);
print_r( $a );
