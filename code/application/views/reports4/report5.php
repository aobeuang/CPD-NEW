<script src="/assets/default/js/angular.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['bar',"corechart","table"]});

    var options = {
        title: 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท',
        width: '100%',
        height: '100%',
        fontName:'Kanit',
        // is3D: true,
        sliceVisibilityThreshold: 0.0,
        // legend: { position: 'labeled' },
        pieSliceText: 'value',
        legend: {
            position: 'labeled',
            labeledValueText: 'both',
            textStyle: {
                color: 'blue',
                fontSize: 14
            }
        },
        titleTextStyle: {
            color: '#455A64',
            fontSize: 16
        },
        chartArea: {
            width: '100%',
            height: '700'
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

    function drawType(jsonData) {
        try{
            var data_coop = [['ประเภท', 'จำนวนสมาชิก']];

            console.log(jsonData.length);

            for(var i=0;i<jsonData.length;i++)
            {

                // var temp = [jsonData[i].REGION_NAME, jsonData[i].RAI];
                var temp = [];
                console.log(jsonData[i].TYPE_DETAIL + '-->' + jsonData[i].RAI);

                temp.push(jsonData[i].TYPE_DETAIL);
                temp.push(parseInt(jsonData[i].RAI));

                data_coop.push(temp);
            }
            // console.log(data_coop);

            // alert(JSON.stringify( data_coop));
            var dataChart = google.visualization.arrayToDataTable(data_coop);

            options.title = 'จำนวนสมาชิกสหกรณ์แบ่งตามประเภท';

            var chart_div = document.getElementById('chart_div');
            chart = new google.visualization.PieChart(chart_div);
            // google.visualization.events.addListener(chart, 'select', selectChartHandler);


            chart.draw(dataChart ,options);

        }catch(err) {
            console.log(err);
        }

    };








</script>

<script type="text/javascript">

    var report4_5= angular.module('report4_5', []);

    // Define the `PhoneListController` controller on the `phonecatApp` module
    report4_5.controller('report4_5Controller', function MyController($scope) {



        $scope.resultListType = {};

        $scope.queryFarmer1Type = function() {

            $scope.resultListType = {};
            $scope.totalRai = 0;
            $scope.resultListGroup = [];
            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryFarmer1Type",
                type:"GET",
                dataType: 'json',
                data : {
                    "groupCode" : 2
                },
                success:function(result){

                    $scope.resultListType = result;

                    $scope.resultListType.forEach(function (e) {
                        $scope.totalRai = parseFloat($scope.totalRai) + parseFloat(e.RAI);
                    });

                    $scope.resultListType.forEach(function (e) {
                        e.percentRai = parseFloat(e.RAI) / $scope.totalRai * 100;
                    });

                    // google.charts.setOnLoadCallback(drawType(result));


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


        $scope.queryFarmer1TypeDetail = function() {

            $scope.resultListTypeDetail = {};

            $('#pageLoading').fadeIn();
            $.ajax({
                url:"queryFarmer1TypeDetail",
                type:"GET",
                dataType: 'json',
                data : {
                    "groupCode" : 2
                },
                success:function(result){

                    $scope.resultListTypeDetail = result;

                    $scope.resultListTypeDetail.forEach(function (e) {
                        $scope.totalRai = parseFloat($scope.totalRai) + parseFloat(e.RAI);
                    });

                    $scope.resultListTypeDetail.forEach(function (e) {
                        e.percentRai = parseFloat(e.RAI) / $scope.totalRai * 100;
                    });

                    google.charts.setOnLoadCallback(drawType(result));

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

        resetStyling('table_div');


        $scope.queryFarmer1Type();
        $scope.queryFarmer1TypeDetail();

        var now = new Date();
        var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม",
            "เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน",
            "ตุลาคม","พฤศจิกายน","ธันวาคม");
        var datethai = "ข้อมูล ณ วันที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " พ.ศ. " + (0+now.getFullYear()+543);

        $('#datethai').html("ที่มาข้อมูล : สศก. " + datethai);


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
</style>

<div id="report" class="mis" ng-app="report4_5">
    <div id="main-wrapper" ng-controller="report4_5Controller">
        <!--		<div id="main-container" class="container-fluid col-md-12 col-xs-12" >-->
        <div class="report-result">
            <div style="position: relative;">
                <h2  class="report-title-center" style="text-align:center"><center>รายงานทะเบียนเลี้ยงสัตว์ จำนวนพื้นที่ของสมาชิกสหกรณ์</center></h2>
                <!-- 				<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4> -->
            </div>

            <div class="row" style="padding-top: 20px; display: block; margin-left: auto; margin-right: auto;  width: 80%; ">
                <div class="col-md-12">
                    <div id="chart_div"></div>
                </div>
            </div>

            <div class="row" ng-show="resultListTypeDetail.length > 0">

                <center><h2  class="report-title-center" style="text-align:center; margin-top: 20px">ข้อมูลพื้นที่ตามประเภท</h2></center>
                <div id="table_div" style="display: block; margin-left: auto; margin-top: 10px;  margin-right: auto;  width: 80%;" class="text-center" >
                    <table class="table table-bordered table-condensed table-data table-striped table-hover">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ประเภท</th>
                            <th>พื้นที่ (ไร่)</th>
                            <th>สัดส่วน %</th>
                        </tr>


                        <tr ng-repeat="row in resultListTypeDetail track by $index">
                            <td>
                                {{$index + 1}}
                            </td>
                            <td align="left" style="vertical-align: middle;" valign="middle">
                                {{row.TYPE_DETAIL}}
                            </td>
                            <td align="right">{{row.RAI | number}}</td>
                            <td align="right">{{row.percentRai | number : 2}}%</td>

                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td colspan="1" align="center">
                                รวม
                            </td>
                            <td align="right">{{totalRai | number}}</td>
                            <td align="right">100%</td>
                        </tr>

                    </table>
                </div>
            </div>
            <p id="datethai" class="text-right r20"> </p>



        </div>


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
