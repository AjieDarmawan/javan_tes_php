<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css" />

<style type="text/css">
  
.c-dashboardInfo .wrap {
  background: #ffffff;
  box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
  border-radius: 7px;
  text-align: center;
  position: relative;
  overflow: hidden;
  padding: 40px 25px 20px;
  height: 125%;
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
      <div class="c-dashboardInfo col-lg-3 col-md-2">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Event Hari Ini<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($event);?> Orang</span>
        </div>
      </div>


      <div class="c-dashboardInfo col-lg-3 col-md-2">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Webinar<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($webinar);?> Orang</span>
        </div>
      </div>


      

      <div class="c-dashboardInfo col-lg-3 col-md-2" style="margin-top: 100px;">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Register TO Nasional<svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($to_nasional);?> Orang</span>
        </div>
      </div>


      <div class="c-dashboardInfo col-lg-3 col-md-2" style="margin-top: 100px;">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Register <svg
              class="MuiSvgIcon-root-19" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation">
              <path fill="none" d="M0 0h24v24H0z"></path>
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z">
              </path>
            </svg></h4><span class="hind-font caption-12 c-dashboardInfo__count"> <?php echo count($register);?> Orang</span>
        </div>
      </div>
      
    </div>
  </div>
</div>
</center>

<br><br>

<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" onclick="myFunction(1)" data-toggle="tab" href="#tabs-1" role="tab">Login</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" onclick="myFunction(2)"  data-toggle="tab" href="#tabs-2" role="tab">Latihan</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" onclick="myFunction(3)" data-toggle="tab" href="#tabs-3" role="tab">Event</a>
  </li>

    <li class="nav-item">
    <a class="nav-link" onclick="myFunction(4)" data-toggle="tab" href="#tabs-4" role="tab">Register</a>
  </li>


    <li class="nav-item">
    <a class="nav-link"  onclick="myFunction(5)" data-toggle="tab" href="#tabs-5" role="tab">Webinar</a>
  </li>


    <li class="nav-item">
    <a class="nav-link" onclick="myFunction(6)" data-toggle="tab" href="#tabs-6" role="tab">TO Nasional</a>
  </li>
</ul><!-- Tab panes -->









<div class="tab-content">
  <div class="tab-pane active" id="tabs-1" role="tabpanel">
    <?php echo $this->load->view('monitoring/m_login',$login)?>
  </div>
  <div class="tab-pane" id="tabs-2" role="tabpanel">
  <?php echo $this->load->view('monitoring/m_latihan',$latihan)?>
  </div>
  <div class="tab-pane" id="tabs-3" role="tabpanel">
    <?php echo $this->load->view('monitoring/m_event',$event)?>
  </div>

    <div class="tab-pane" id="tabs-4" role="tabpanel">
     <?php echo $this->load->view('monitoring/m_register',$register)?>
  </div>


    <div class="tab-pane" id="tabs-5" role="tabpanel">
    <?php echo $this->load->view('monitoring/m_webinar', $webinar) ?>
  </div>


    <div class="tab-pane" id="tabs-6" role="tabpanel">
    <?php echo $this->load->view('monitoring/m_to_nasional', $to_nasional) ?>
  </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.8/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
