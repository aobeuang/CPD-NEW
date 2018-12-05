<script src="/assets/default/js/angular.min.js"></script>
<script type="text/javascript">

var report4_1 = angular.module('report4_1', []);


report4_1.controller('report4_1Controller', function MyController($scope) {

	

	$scope.resultList = {};

	$scope.queryRiceAreaOrganic = function() {
		
		$scope.resultListYearly = {};

		$('#pageLoading').fadeIn();
		$.ajax({
			url:"queryRiceAreaOrganic",
		    type:"GET",
		    dataType: 'json',
		    success:function(result){
		    	$scope.resultListYearly = result;

		    	google.charts.setOnLoadCallback(drawChart(JSON.stringify($scope.resultListYearly)));
		    	
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
	
	$scope.queryRiceAreaOrganicDetail = function() {
		
		$scope.resultList = {};
		$scope.resultListGroup = [];
		$('#pageLoading').fadeIn();
		$.ajax({
			url:"queryRiceAreaOrganicDetail",
		    type:"GET",
		    dataType: 'json',
		    success:function(result){
		    	$scope.resultList = result;

		    	$scope.resultListGroup = {};

		    	
		    	result.forEach(function(entry) {

		    		if ($scope.resultListGroup[entry.PROJECT_CODE] == null) {
		    			obj = {};
		    			obj.PROJECT_CODE = entry.PROJECT_CODE;
			    		obj.members = [];
			    		$scope.resultListGroup[entry.PROJECT_CODE] = obj;
			    		$scope.resultListGroup[entry.PROJECT_CODE].members.push(entry);

		    		}
		    		else {
		    			$scope.resultListGroup[entry.PROJECT_CODE].members.push(entry);
		    		}
		    		
		    	});

// 		    	$scope.resultListGroup.reverse();
// 		    	alert($scope.resultListGroup.length);
		    	
		    	
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

	 
	 $scope.queryRiceAreaOrganic();
	 $scope.queryRiceAreaOrganicDetail();

  
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
	
<div id="report" class="mis" ng-app="report4_1">
		<div id="main-wrapper" ng-controller="report4_1Controller">
		<div id="main-container" class="container-fluid col-md-12 col-xs-12" >
			<div style="position: relative;">
			   	<h2  class="report-title-center" style="text-align:center"><center>
				รายงานจำนวนพื้นที่ผู้ปลูกข้าวอินทรีย์ ของสมาชิกสหกรณ์
				</center></h2>
<!-- 				<h4><center>จำนวนสมาชิกของสหกรณ์   <span id="total"></span> คน</center></h4> -->
			</div>
				
				
				<div id="chart_div"></div>
<!-- 				{{resultListGroup}} -->
				
				<div id="table_div" style="display: block; margin-left: auto;  margin-right: auto;  width: 80%;" class="text-center">
                    <table class="center">
                        <tr>
                            <th>ปี</th>
                            <th>ประเภท</th>
                            <th>พื้นที่(ไร่)</th>
                        </tr>
                        
                        <tbody ng-repeat="group in resultListGroup">
                            <tr ng-repeat="row in group.members">
                                <td rowspan="{{group.members.length}}" align="center" style="vertical-align: middle;" valign="middle" ng-hide="$index>0">
                                    {{row.PROJECT_CODE}}
                                </td>
                                <td align="center">{{row.TYPE_DETAIL}}</td>
                            <td align="right">{{row.RAI|number}}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
		
<!--     			<div id="table_div"> -->
<!--                     <table> -->
<!--                         <tr> -->
<!--                             <th>ปี</th> -->
<!--                             <th>ประเภท</th> -->
<!--                             <th>ไร่</th> -->
<!--                         </tr> -->
<!--                         <tr ng-repeat="row in resultList track by $index"> -->
<!--                             <td align="center">{{row.PROJECT_CODE}}</td> -->
<!--                             <td align="center">{{row.TYPE_DETAIL}}</td> -->
<!--                             <td align="right">{{row.RAI|number}}</td> -->
<!--                         </tr> -->
<!--                     </table> -->
    			
<!-- 				</div> -->
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

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar',"corechart","table"]});
      
      

      function drawChart(jsonData) {

    	  jsonData = JSON.stringify(eval("(" + jsonData + ")"));

    	  try {
    			var data = new google.visualization.DataTable(jsonData);
    			var chart = new google.visualization.LineChart(document
    					.getElementById('chart_div'));
    			chart.draw(data, options);
    		} catch (err) {
    			alert( err.message );			
    		}
    		return;
          
          var data = google.visualization.arrayToDataTable([
        	  ['City', '2010 Population',],
              ['New York City, NY', 8175000],
              ['Los Angeles, CA', 3792000],
              ['Chicago, IL', 2695000],
              ['Houston, TX', 2099000],
              ['Philadelphia, PA', 1526000]
          ]);

          var options = {
        	        title: 'Population of Largest U.S. Cities',
        	        chartArea: {width: '50%'},
        	        hAxis: {
        	          title: 'Total Population',
        	          minValue: 0
        	        },
        	        vAxis: {
        	          title: 'City'
        	        }
        	      };

          var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
          chart.draw(data, options);
        }

      

    
    </script>
    <style type="text/css">
    	#table_div{
    		pointer-events:none !important;
    	}
    </style>
