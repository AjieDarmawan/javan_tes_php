<html>
<thead></thead>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
  .tabs {
}
.tabs input[type=radio] {
  display: none; 
}
.tabs label {
  transition: background 0.4s ease-in-out, height 0.2s linear;
  display: inline-block;
  cursor: pointer;
  color: #2EBEB9;
  width: 20%;
  height: 3em;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  background: #FCFCFC;
  text-align: center;
  line-height: 3em; 
}
.tabs label:last-of-type {
  border-bottom: none; 
}
.tabs label:hover {
  background: #259692;
  color:#ffffff;
}
@media screen and (max-width: 1600px) {
.tabs label {
  width: 15%; } 
}
@media screen and (max-width: 900px) {
.tabs label {
  width: 20%; 
  } 
}
@media screen and (max-width: 600px) {
.tabs label {
  width: 100%;
  display: block;
  border-bottom: 2px solid #C7C6C4;
  border-radius: 0; 
} 
}
@media screen and (max-width: 600px) {
.tabs {
  margin: 0; 
} 
}

#tab1:checked+label,
  #tab2:checked+label,
  #tab3:checked+label,
  #tab4:checked+label,
  #tab5:checked+label,
  #tab6:checked+label,

  #tab9:checked+label {
    background: #2EBEB9;
    color: #FFFFFF;
  }


.tab-content {
  position: absolute;
  top: -9999px;
  padding: 10px; 
}

.tab-content-wrapper{
  background: #FCFCFC;
  border-top: #2EBEB9 5px solid;
  border-bottom-right-radius: 3px;
  border-bottom-left-radius: 3px;
  border-top-right-radius: 3px;
  
}
@media screen and (max-width: 600px) {
.tab-content-wrapper, .tab1-content-wrapper {
  border: none;
  border-radius: 0; 
} 
}

 #tab1:checked~.tab-content-wrapper #tab-content-1,
  #tab2:checked~.tab-content-wrapper #tab-content-2,
  #tab3:checked~.tab-content-wrapper #tab-content-3,
  #tab4:checked~.tab-content-wrapper #tab-content-4,
  #tab5:checked~.tab-content-wrapper #tab-content-5,
  #tab6:checked~.tab-content-wrapper #tab-content-6,

  #tab9:checked~.tab-content-wrapper #tab-content-9 {
    position: relative;
    top: 0px;
  }
</style>

<style type="text/css">
  
.c-dashboardInfo .wrap {
  background: #ffffff;
  box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
  border-radius: 7px;
  text-align: center;
  position: relative;
  overflow: hidden;
  padding: 40px 25px 20px;
  height: 25%;
}
.c-dashboardInfo__title,
.c-dashboardInfo__subInfo {
  color: #6c6c6c;
  font-size: 1.18em;
}
.c-dashboardInfo span {
  display: block;
}
.c-dashboardInfo__count {
  font-weight: 600;
  font-size: 2.5em;
  line-height: 64px;
  color: #323c43;
}
.c-dashboardInfo .wrap:after {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 10px;
  content: "";
}

.c-dashboardInfo:nth-child(1) .wrap:after {
  background: linear-gradient(82.59deg, #00c48c 0%, #00a173 100%);
}
.c-dashboardInfo:nth-child(2) .wrap:after {
  background: linear-gradient(81.67deg, #0084f4 0%, #1a4da2 100%);
}
.c-dashboardInfo:nth-child(3) .wrap:after {
  background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
}
.c-dashboardInfo:nth-child(4) .wrap:after {
  background: linear-gradient(81.67deg, #ff647c 0%, #1f5dc5 100%);
}
.c-dashboardInfo__title svg {
  color: #d7d7d7;
  margin-left: 5px;
}
.MuiSvgIcon-root-19 {
  fill: currentColor;
  width: 1em;
  height: 1em;
  display: inline-block;
  font-size: 24px;
  transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
  user-select: none;
  flex-shrink: 0;
}

</style>

<body>

   <a>
    <i class="fa fa-calendar"></i>&nbsp;
    <script type="text/javascript">
      var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
      var date = new Date();
      var day = date.getDate();
      var month = date.getMonth();
      var thisDay = date.getDay(),
        thisDay = myDays[thisDay];
      var yy = date.getYear();
      var year = (yy < 1000) ? yy + 1900 : yy;
      document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
    </script>
  </a>



  <a>
    <i class="fa fa-clock-o"></i> <span id="jamweke"></span>
    <script type="text/javascript">
     
      function startTime() {
        var today = new Date(),
          curr_hour = today.getHours(),
          curr_min = today.getMinutes(),
          curr_sec = today.getSeconds();
        curr_hour = checkTime(curr_hour);
        curr_min = checkTime(curr_min);
        curr_sec = checkTime(curr_sec);
        document.getElementById('jamweke').innerHTML = curr_hour + ":" + curr_min + ":" + curr_sec;
      }

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
      setInterval(startTime, 500);
      //
     
    </script>
  </a>


    <br>

    <form>
  <label>Tgl Mulai</label>
    <input type="date"  name="mulai" value="<?php echo $tgl_awal;?>" >

    <label>Tgl Akhir</label>
    <input type="date"   name="selesai"  value="<?php echo $tgl_akhir;?>" >

    <button type="submit" class="btn btn-primary btn-sm">Cari ..</button>


    <a href="<?php echo base_url('monitoring/print/'.$tgl_awal.'/'.$tgl_akhir)?>" class="btn btn-success btn-sm">Print Excel ..</a>
  </form>

   <center><div id="root">
  <div class="container pt-5">
    <div class="row align-items-stretch">
      <div class="c-dashboardInfo col-lg-3 col-md-2">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Login Hari Ini<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($login);?> Orang</span>
        </div>
      </div>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Latihan Hari Ini<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"><?php echo $total_latihan->total;?> Orang</span><span
            class="hind-font caption-12 c-dashboardInfo__subInfo"></span>
        </div>
      </div>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Event Hari Ini<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo $total_event->total;?> Orang</span>
        </div>
      </div>
      

      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Register TO<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($to_nasional);?> Orang</span>
        </div>
      </div>
      
    </div>
  </div>
</div>
</center>

<br><br>


  
    


<div class="tabs">
       <input type="radio" onclick="myFunction(1)"  name="tab" value="1" id="tab1" checked="checked">
    <label for="tab1">Login</label>
    <input type="radio" onclick="myFunction(2)" name="tab" value="2" id="tab2">
    <label for="tab2">Latihan</label>
    <input type="radio" onclick="myFunction(3)" name="tab"value="3" id="tab3">
    <label for="tab3">Event</label>
     <input type="radio" onclick="myFunction(4)" name="tab" value="4" id="tab4">
    <label for="tab4">Register</label>

     <input type="radio" onclick="myFunction(5)" name="tab" value="5" id="tab5">
    <label for="tab5">Webinar</label>

    <input type="radio" onclick="myFunction(6)" name="tab" value="6" id="tab6">
    <label for="tab6">To Nasional</label>




   
  
    <div class="tab-content-wrapper">
      <div id="tab-content-1" class="tab-content">
        <?php echo $this->load->view('monitoring/m_login',$login)?>
    </div>
      <div id="tab-content-2" class="tab-content">
        
      <?php echo $this->load->view('monitoring/m_latihan',$latihan)?>
      </div>
      <div id="tab-content-3" class="tab-content">
        
      <?php echo $this->load->view('monitoring/m_event',$event)?>
      </div>

       <div id="tab-content-4" class="tab-content">
        
        <?php echo $this->load->view('monitoring/m_register',$event)?>
        </div>


        <div id="tab-content-5" class="tab-content">

        <?php echo $this->load->view('monitoring/m_webinar', $webinar) ?>
      </div>


      <div id="tab-content-6" class="tab-content">

        <?php echo $this->load->view('monitoring/m_to_nasional', $to_nasional) ?>
      </div>
      
    </div>
  </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>



<script>

function myFunction(id) {
 // alert(id);

  if(id==1){
          $(document).ready(function() {
          var table1 = $('#example').DataTable( {
              responsive: true,
              retrieve: true,
          } );

         new $.fn.dataTable.FixedHeader( table1 );

       

       

      });
   }

   else if(id==2){
          $(document).ready(function() {
          var table2 = $('#example1').DataTable( {
              responsive: true,
              retrieve: true,
          } );

         new $.fn.dataTable.FixedHeader( table2 );

         
      });
   }

   else if(id==3){
          $(document).ready(function() {
          var table3 = $('#example2').DataTable( {
              responsive: true,
              retrieve: true,
          } );

          new $.fn.dataTable.FixedHeader( table3);
      });
   }

   else if(id==4){
          $(document).ready(function() {
          var table4 = $('#example3').DataTable( {
              responsive: true,
              retrieve: true,
          } );

          new $.fn.dataTable.FixedHeader( table4 );
      });
   } else if (id == 5) {
      $(document).ready(function() {
        var table5 = $('#example4').DataTable({
          responsive: true,
          retrieve: true,
        });

        new $.fn.dataTable.FixedHeader(table5);
      });
    } else if (id == 6) {
      $(document).ready(function() {
        var table6 = $('#example5').DataTable({
          responsive: true,
          retrieve: true,
        });

        new $.fn.dataTable.FixedHeader(table6);
      });
    }














}
</script>


<script>
   var tabs = document.querySelector('input[name="tab"]:checked').value;

  

   if(tabs==1){
          $(document).ready(function() {
          var table1 = $('#example').DataTable( {
              responsive: true
          } );

          new $.fn.dataTable.FixedHeader( table1 );
      });
   }

   

  </script>



</html>