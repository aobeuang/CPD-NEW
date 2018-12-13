<script src="/assets/default/js/angular.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script type="text/javascript">
    // google.charts.load('current', {'packages':['bar',"corechart","table"]});
    google.charts.load('current', { packages: ['corechart', 'table']});

    var report4_2= angular.module('report4_2', []);


// Define the `PhoneListController` controller on the `phonecatApp` module
report4_2.controller('report4_2Controller', function MyController($scope) {


	$scope.resultList = {};

    $scope.queryRiceAreaAllRegion = function() {

        $scope.resultSummaryArea = {};
        $scope.totalArea = 0;

        $('#pageLoading').fadeIn();
        $.ajax({
            url:"queryRiceAreaAllRegion",
            type:"GET",
            dataType: 'json',
            success:function(result){

                // $scope.resultListYearly = result;
                $scope.resultSummaryArea = result;

                $scope.resultSummaryArea.forEach(function(element) {
                    $scope.totalArea = parseFloat($scope.totalArea) + parseFloat(element.RAI);
                });

                console.log('totalArea:' + $scope.totalArea);


                google.charts.setOnLoadCallback($scope.drawType);


                $('#pageLoading').fadeOut();
                $scope.$apply();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred... ' + errorThrown);

                $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);

                $('#pageLoading').fadeOut();
            }
        })
    };

    $scope.queryRiceAreaAllProvince = function(regionName) {

        $scope.resultProvinceArea = {};
        $scope.totalRegion = 0;

        $('#pageLoading').fadeIn();
        $.ajax({
            url:"queryRiceAreaAllProvince",
            type:"GET",
            dataType: 'json',
            data: {
                "regionName": regionName
            },
            success:function(result){
                // $scope.resultListYearly = result;
                $scope.resultProvinceArea = result;

                $scope.resultProvinceArea.forEach(function(element) {
                    if (element.TOTAL_RAI) {
                        $scope.totalRegion = parseFloat($scope.totalRegion) + parseFloat(element.TOTAL_RAI);
                    }

                });

                $scope.regionName = regionName;
                if (!regionName) {
                    $scope.regionName = 'ทั้งประเทศ';
                }

                $('#pageLoading').fadeOut();
                $scope.$apply();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred... ' + errorThrown);

                $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);

                $('#pageLoading').fadeOut();
            }
        })
    };



	 function resetStyling(id) {
         $('#' + id + ' table')
             .removeClass('google-visualization-table-table')
             .addClass('table table-bordered table-condensed table-striped table-hover');
         var parentRow = $('#' + id + ' td.TotalCell').parent();
         parentRow.addClass('TotalRow');
     }

    function selectChartHandler()
    {
        var selectedItem = chart.getSelection()[0];

        if (selectedItem)
        {
            var topping = dataChart.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping);
        }
    }

    resetStyling('table_div');


    var options = {
        title: 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท',
        width: '100%',
        height: '350',
        fontName:'Kanit',
        // is3D: true,
        sliceVisibilityThreshold: 0,
        // legend: { position: 'labeled' },
        titleTextStyle: {
            color: '#455A64',
            fontSize: 16
        },
        chartArea: {
            width: '100%',
            height: '900'
        },

        pieSliceText: 'label',
        slices: {  0: {offset: 0.2},
            1: {offset: 0.3},
            2: {offset: 0.4},
            3: {offset: 0.5},
        },
        slices: {
            0: { color: '#6588C4' },
            1: { color: '#D5702C' },
            2: { color: '#56978c' },
            3: { color: '#FFBF00' },
            4: { color: '#7B749B' },
            5: { color: '#a971a7' },
            6: { color: '#70AB46' },
            7: { color: '#35507F' },
            8: { color: '#FFAEDB' },
            9: { color: '#A3A3A3' },
        },

        tooltip: {
            isHtml: true,
            trigger: 'selection'
        },
    };

    var dataChart = null;

    $scope.drawType = function() {
    // function drawType() {
        try{
            var data_coop = [['ประเภท', 'จำนวนสมาชิก']];
            var jsonData = $scope.resultSummaryArea;

            console.log(jsonData.length);

            for(var i=0;i<jsonData.length;i++)
            {

                // var temp = [jsonData[i].REGION_NAME, jsonData[i].RAI];
                var temp = [];
                console.log(jsonData[i].REGION_NAME+ '-->' + jsonData[i].RAI);

                temp.push(jsonData[i].REGION_NAME);
                temp.push(parseInt(jsonData[i].RAI));

                data_coop.push(temp);
            }
            // console.log(data_coop);

            // alert(JSON.stringify( data_coop));
            var dataChart = google.visualization.arrayToDataTable(data_coop);

            options.title = 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท';

            var chart_div = document.getElementById('chart_div');
            chart = new google.visualization.PieChart(chart_div);
            google.visualization.events.addListener(chart, 'select', selectChartHandler);


            chart.draw(dataChart ,options);
        }catch(err) {
            console.log(err);
        }

    };

    var now = new Date();
    var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
        "เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
        "ตุลาคม","พฤศจิกายน","ธันวาคม");
    var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);

    $('#datethai').html("ที่มาข้อมูล : กรมการข้าว " + datethai);

	 $scope.queryRiceAreaAllRegion();

});
</script>

<style>
#myBar {
  width: 0%;
  height: 30px;
  background-color: #4CAF50;
  text-align: center;
  line-height: 30px;
  color: white;
}
text:hover
{
	fill: mediumblue/*#219*/;
	cursor: pointer;
}

.table .google-visualization-table-tr-odd, .table .google-visualization-table-tr-even {
    background-color: transparent;
}

.table-striped > th {
    background-color: #00CC00;
}

.table-data th {
    background-color: #00CC00;
}

.google-visualization-table-td {
text-align: center !important;
}

#table_div.table {
    margin-bottom: 0;
}
#table_div .TotalRow {
    background-color: #e4e9f4;
    text-align: center;
}
#table_div .TotalRow td {
    background-image:linear-gradient(to bottom, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.7) 30%, rgba(255, 255, 255, 0.5) 60%, rgba(255, 255, 255, 0) 100%);
    font-weight : 700;
}
.Textcenterodd {
	vertical-align: middle  !important;
	background-color: transparent !important;
}
.Textcentereven {
	vertical-align: middle  !important;
	background-color: transparent !important;
}
#table_div .position.google-visualization-table-td
{
	text-align: right!important;
}
table.center {
    margin-left:auto; 
    margin-right:auto;
  }

#report #right-container{
    padding-left :0px!important;
}

/* Safari */
@-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
	
<div id="report" class="mis" ng-app="report4_2">
		<div id="main-wrapper" ng-controller="report4_2Controller">
            <p>Page Code : DR102</p>
            <pre>
<!--               log_path --><?php //echo$this->load->vars($this->config->item('log_path')); ?>
               log_path <?php echo $this->config->item('log_path'); ?>
               is_dir <?php echo is_dir($this->config->item('log_path')); ?>
               is_writable  <?php echo is_writable ($this->config->item('log_path')); ?>
<!--               is_really_writeable --><?php //echo is_really_writeable($this->config->item('log_path')); ?>

            </pre>
            <div class="report-result">

                <div style="position: relative;">
                    <h2  class="report-title-center" style="text-align:center"><center>
                            รายงานจำนวนพื้นที่ผู้ปลูกข้าวทั่วไป ของสมาชิกสหกรณ์
                        </center></h2>
                    <!-- 				<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4> -->
                </div>


                <div class="row" style="padding-top: 20px; display: block; margin-left: auto; margin-right: auto;  width: 80%; ">
                    <div class="col-md-7">
                        <div id="chart_div"></div>
                    </div>
                    <div class="col-md-5">
                        <div id="" style="display: block; margin-left: auto; margin-right: auto;  width: 80%;" class="text-center">
                            <table class="table table-bordered table-condensed table-data table-striped table-hover " ng-show="resultSummaryArea.length > 0">
                                <tr>
                                    <th>ภาค</th>
                                    <th>พื้นที่(ไร่)</th>
                                </tr>
                                <tr ng-repeat="row in resultSummaryArea">
                                    <td align="center" style="vertical-align: middle;" valign="middle">
                                        <a ng-click="queryRiceAreaAllProvince(row.REGION_NAME)" style="cursor: pointer;"> {{row.REGION_NAME}} </a>
                                    </td>
                                    <td align="right">{{row.RAI|number}}</td>
                                </tr>
                                <tr >
                                    <td align="center" style="vertical-align: middle;" valign="middle">
                                        <a ng-click="queryRiceAreaAllProvince(null)" style="cursor: pointer;"> รวมทั้งหมด </a>

                                    </td>
                                    <td align="right">{{totalArea|number}}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="row" ng-show="resultProvinceArea.length > 0">
                    <center><h2  class="report-title-center" style="text-align:center; margin-top: 10px">ข้อมูลพื้นที่{{regionName}} {{totalRegion | number}} ไร่</h2></center>
                    <div id="table_div" style="display: block; margin-left: auto; margin-top: 10px;  margin-right: auto;  width: 80%;" class="text-center" >
                        <table class="center">
                            <tr>
                                <th>ลำดับ</th>
                                <th>จังหวัด</th>
                                <th>ข้าวหอมมะลิ</th>
                                <th>ข้าวหอมประทุม</th>
                                <th>ข้าวเจ้า</th>
                                <th>ข้าวเหนียว</th>
                                <th>ข้าวสี</th>
                                <th>ข้าวอินทรีย์</th>
                                <th>รวม</th>
                            </tr>


                            <tr ng-repeat="row in resultProvinceArea track by $index">
                                <td>
                                    {{$index + 1}}
                                </td>
                                <td align="left" style="vertical-align: middle;" valign="middle">
                                    {{row.PROVINCE_NAME}}
                                </td>
                                <td align="right">{{row.COL01_SUM_RAI | number}}</td>
                                <td align="right">{{row.COL02_SUM_RAI | number}}</td>
                                <td align="right">{{row.COL03_SUM_RAI | number}}</td>
                                <td align="right">{{row.COL04_SUM_RAI | number}}</td>
                                <td align="right">{{row.COL05_SUM_RAI | number}}</td>
                                <td align="right">{{row.COL06_SUM_RAI | number}}</td>
                                <td align="right">{{row.TOTAL_RAI | number}}</td>

                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td colspan="7">
                                    รวม
                                </td>
                                <td align="right">{{totalRegion | number}}</td>

                            </tr>

                        </table>
                    </div>
                </div>

<!--                <div class="row">-->
<!--                    <div id="table_div" style="display: block; margin-left: auto; margin-top: 40px;  margin-right: auto;  width: 80%;" class="text-center">-->
<!--                        <table class="center">-->
<!--                            <tr>-->
<!--                                <th>ปี</th>-->
<!--                                <th>ประเภท</th>-->
<!--                                <th>พื้นที่(ไร่)</th>-->
<!--                            </tr>-->
<!---->
<!--                            <tbody ng-repeat="group in resultListGroup">-->
<!--                            <tr ng-repeat="row in group.members">-->
<!--                                <td rowspan="{{group.members.length}}" align="center" style="vertical-align: middle;" valign="middle" ng-hide="$index>0">-->
<!--                                    {{row.PROJECT_CODE}}-->
<!--                                </td>-->
<!--                                <td align="center">{{row.TYPE_DETAIL}}</td>-->
<!--                                <td align="right">{{row.RAI|number}}</td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                </div>-->


                <p id="datethai" class="text-right r20"> </p>
            </div>
<!--		<div id="main-container" class="container-fluid col-md-12 col-xs-12" >-->
<!--            -->
<!--        </div>-->


		
		
	</div>

</div>

</div>

<style>
<!--

-->
th
{
	text-align: center;
}
</style>






    <style type="text/css">
    	#table_div{
    		pointer-events:none !important;
    	}
    </style>
