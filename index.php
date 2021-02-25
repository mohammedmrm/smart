<?php include("loginCheck.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Smart Meter System</title>
  <link rel="manifest" href="pwa/manifest.webmanifest">
  <style>
  body {
    overflow-x: hidden;
  }

  .dev {
    background-color: #FFCC99;
    padding: 10px;

  }
  .dev label {
    color: #EEEEEE;
    font-size: 20px;
  }

  .hr {
    border: 2px solid red;
  }

  #ecg{
    height: 550px;
  }
  #emg{
    height: 300px;
  }

  .gauge {
    //border-left: 2px #BBBBBB solid;
    //border-right: 2px #BBBBBB solid;
  }
  .onoff {
    margin-bottom: 10px;
  }

  .alarmlabel{
    font-size: 20px;
  }

  .alarmlightg{
    display: inline-block;
    height: 25px;
    width: 25px;
    border-radius: 300px;
    background-color: #339900;
    box-shadow: 0px 0px 10px #33FF00;
  }
@keyframes alarm {
  0%   {box-shadow: 0px 0px 1px #FF3300;background-color: #aa0000;}
  25%  {box-shadow: 0px 0px 5px #FF3300;background-color: #ff0000;}
  50%  {box-shadow: 0px 0px 10px #FF3300;background-color: #aa0000;}
  100% {box-shadow: 0px 0px 15px #FF3300;background-color: #ff0000;}
}
@keyframes spin {
  0%   {transform: rotate(0deg)}
  8.3%  {transform: rotate(30deg)}
  16.6%  {transform: rotate(60deg)}
  24.9% {transform: rotate(90deg)}
  33.2% {transform: rotate(120deg)}
  41.5% {transform: rotate(150deg)}
  49.8% {transform: rotate(180deg)}
  58.1% {transform: rotate(210deg)}
  66.4% {transform: rotate(240deg)}
  74.7% {transform: rotate(270deg)}
  83% {transform: rotate(300deg)}
  91.3% {transform: rotate(330deg)}
  98% {transform: rotate(360deg)}
  100% {transform: rotate(0deg)}
}
    .leftlist {
      border-right:3px #666666  solid;
      left: 0px;
      padding: 15px;
    }

   .alarmlightr{
    display: inline-block;
    height: 25px;
    width: 25px;
    border-radius: 300px;
    background-color: #CC0000;
    animation-name: alarm;
    animation-iteration-count: infinite;
    animation-duration: 0.8s;
  }
  .spin {
    animation-name: spin;
    animation-iteration-count: infinite;
    animation-duration: 0.5s;
    color: #33CC00;
  }

  #thh, #tht{
    display: block;
    height: 40px;
    text-align: center;
    font-size: 25px;
    background-color: #000000;
    color: #FFFFFF;
    padding: 5px;
  }
  #systemconnection {
    display: block;
    height: 40px;
    text-align: center;
    font-size: 25px;
    padding: 5px;
  }

  .thresholds {
    cursor: pointer;
  }
   #lineemg, #lineecg {
     min-height: 350px;
   }

  .sys{
    text-align: center;
    padding-top: 100px;
  }
  .sys button {
    width: 150px;
    border-radius: 10px;
    height: 40px;
  }
   #systemstatus {
     display: block;
     width: 100%;
     height: 50px;
     padding: 8px;
     color: #FFFFFF;
     position: relative;
     font-size: 18px;
     background-color: #FF9900;
     cursor: pointer;
     border-left: 8px solid #888888;
   }
   #fan , #light , #alarm {
     display: block;
     width: 100%;
     height: 50px;
     padding: 10px;
     color: #FFFFFF;
     position: relative;
     font-size: 18px;
     background-color: #FF9900;
     cursor: pointer;
     text-align: center;
   }
  .onoff label {
    font-size: 18px;
     width: 100%;
     height: 50px;
     padding: 8px;
  }
  .lighton {
    color: #F0DF0F;
    text-shadow: 0px 0px 20px #FFFF00;

  }
  .alarmon {
    color: #FF0000;
    text-shadow: 0px 0px 10px #CC0000;

  }
  .adminlist {
    position: relative;
    list-style: none;
    display: block;
    width:100%;
    padding: 0px;
    border-bottom: 2px red solid
  }
  .adminlist li {
    display: block;
    height: 50px;
    width:100%;

  }

  .adminlist li a {
    color: #fff;
    display: block;
    height: 100%;
    font-size: 20px;
    padding: 10px;
    text-decoration: none;
  }
  .adminlist li a:hover {
    color: #123;
  }

canvas {
  width: 100%;
  height: 200px;
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 0;
  background:transparent;
}
.led {
  width: 20px;
  height:20px;
  border-radius: 10px;
  position: relative;
  margin: auto;
  background-color: #4F6366;
}

  </style>
  </head>

<body>
<?php include("header.php"); ?>
<div class="col-md-12">
  <div class="row">
  <div class="col-md-3">
  <div class="leftlist">
   <div class="col-md-12 dev">
     <div class="form-group">
       <label class="col-sm-4"> Meters </label>
       <select class="form-control selectpicker" onchange="changeReads($(this).val());getMeterInfo();" data-live-search="true" id="devices">
          <option>-- select Meter --</option>
       </select>
       <input type="checkbox" id="active" value="Active Random Reads"/> Active Random Reads
     </div>
   </div>
   <div class="col-md-12">
   <hr class="hr"/>
   </div>
     <br />
   <div class="col-md-12 dev">
     <?php
     echo "<h3 style='color:#000;'><b>".date("Y-d-m h:i")."</b></h3>";
     ?>
   </div>
  </div>
  </div>
  <div class="col-md-9">
    <div class="row">
        <div class="col-sm-3">
            <label class="h5" id="meter_no">Meter No : </label>
        </div>
        <div class="col-sm-3">
            <label class="h5" id="name">Name: </label>
        </div>
        <div class="col-sm-12"><hr /></div>
    </div>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-6"><h3>Last Merter Read</h3>
          <div id="meter"></div>
        </div>
    </div>
<!--    <hr />
    <div class="row">
        <div class="col-sm-6">
          <h3>Blood Prasure: 113/78</h3>
        </div>
        <div class="col-sm-6">
           <h3>Glucose: 130</h3>
        </div>
    </div>-->
    <hr />

  </div>
  </div>
  <div class="row">
      <div class="col-sm-12"><h1>Meter Reads Track</h1>
          <div id="ecg"></div>
      </div>
  </div>
</div>
<?php include("footer.php"); ?>
 <!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
 <script type="text/javascript" src="bootstrap-4.3.1-dist/js/charts.js"></script>
 <script type="text/javascript">

      google.charts.load('current', {'packages':['gauge']});
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(meter);
      var gaugeOptions2 = {
          height: 250,redColor:"#FF3333",
          redFrom: 50, redTo: 100,
          yellowFrom:15, yellowTo: 50,
          greenFrom:0,greenTo:15,
          minorTicks: 5 , max :100
        };
      var gaugeData2;
      function meter() {
      gaugeData2 = new google.visualization.DataTable();
      gaugeData2.addColumn('number', 'Kwh');
      gaugeData2.addRows(10);
      gaugeData2.setCell(0, 0,12);

      gauge2 = new google.visualization.Gauge(document.getElementById('meter'));
      gauge2.draw(gaugeData2, gaugeOptions2);

      }


      function changeReads(d) {
        getMeterInfo();
        $.ajax({
          url:"script/_getCurrentReads.php",
          data:{id:d},
          success:function(res){
           //console.log(res);
           $.each(res.data,function(){
            gaugeData2.setValue(0, 0, this.kwh);
            gauge2.draw(gaugeData2, gaugeOptions2);
           });
          },
          error:function(e){
          console.log(e);
          }
        });
     }
     google.charts.setOnLoadCallback(lineecg);

      function lineecg(d) {
        var jsonData = $.ajax({
            url: "script/_getecg.php",
            dataType: "json",
            data:{id:d},
            async: false,
            success:function(res){},
            error:function(res){}
            }).responseText;

        // Create our data table out of JSON data loaded from server.
        var data = new google.visualization.DataTable(jsonData);
         var ECGoptions = {
         title:'Latest Meter Reads',

         curveType: 'function',
          series: {
            0: {pointSize: 3,curveType: 'function'}
          },
         lineWidth:1,
         legend:{position:'bottom'},
         chartArea:{width:'80%'},
          explorer: { axis: 'horizontal',maxZoomIn: 1, maxZoomOut: 8,
          actions: ['dragToZoom', 'rightClickToReset'],zoomDelta:1.5  },
          hAxis: {
            title:"Time",
            gridlines: {count: 12},title:"Time"
          },
          vAxis: {
            gridlines: {count: 12},title:"Kwh"
          }
         };        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.LineChart(document.getElementById('ecg'));
        chart.draw(data,ECGoptions);
      }
      function getDevices(){
        $.ajax({
          url:"script/_getDevicesPatient.php",
          type:"POST",
          success:function(res){
            
           $.each(res.data,function(){
             $("#devices").append(
             '<option value="'+this.meter_no+'">'+this.meter_no+'-'+this.name+'</option>'
             );
           });
           if($("#userperiv").val() == 2){
             $("#devices").val($("#d_id").val());
             $("#devices").addClass('disabled');
             $("#devices").attr('disabled','disabled');
             changeReads($("#devices").val());
             lineecg($("#devices").val());
           }
          },
          error:function(e){
           console.log(e);
          }
        });
      }
      getDevices();
      $("#devices").change(function(){
        changeReads($("#devices").val());
        lineecg($("#devices").val());
        });
      setInterval(function() {
        //randomreads();
        changeReads($("#devices").val());
        lineecg($("#devices").val());
        if($('input#active').is(':checked')){
         randomreads();
        }

      }, 5000);
      changeReads();
      function randomreads(){ ///------testing function adds random reads
        $.ajax({
          url:"script/randomreads.php",
          success:function(res){
            console.log("rand",res)
          },
          error:function(e){
            console.log("rand",e)
          }
        });
      }
      function getMeterInfo(){
        $.ajax({
          url:"script/_getMeterInfo.php",
          data:{id:$("#devices").val()},
          success:function(res){
            console.log(res);
            $.each(res.data,function(){
               $("#meter_no").text('Meter NO: '+this.meter_no);
               $("#name").text('Name: '+this.name);
            });
          },
          error:function(e){
           console.log(e);
          }
        })
      }
   </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/dat-gui/0.5/dat.gui.min.js"></script>
      <script>
      // Check that service workers are supported
      if ('serviceWorker' in navigator) {
         window.addEventListener('load', () => {
          navigator.serviceWorker.register('sw.js')
        });
      }
      </script>
</body>

</html>
