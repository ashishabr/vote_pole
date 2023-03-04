      <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2022. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
     
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="<?php echo base_url(); ?>assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?php echo base_url(); ?>assets/vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php echo base_url(); ?>assets/js/off-canvas.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/template.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/settings.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url(); ?>assets/js/alertify.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashboard.js?v=<?= time(); ?>"></script>
  <script src="<?php echo base_url(); ?>assets/js/Chart.roundedBarCharts.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/render.js?v=<?= time(); ?>"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <!-- End custom js for this page-->
  <script type="text/javascript">
    
  $(document).on("click","#logout",function(e){
    e.preventDefault();
    // console.log("s");return false;
    $.ajax({
        url : "<?= base_url('login/logout'); ?>",
        type: "POST",
        data : {},
        success: function(data, textStatus, jqXHR)
        {
          window.location.href = "<?= base_url('login/index'); ?>";
            //data - response from server
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
     
        }
    });
  })

$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    
    load_dashboard_votes(start,end);
    // console.log("A new date selection was made: " + start.format('MM/DD/YYYY') + ' to ' + end.format('MM/DD/YYYY'));
  });
});
  </script>
  <style type="text/css">
    .dashboard_date{
      display: none;
    }
  </style>
</body>

</html>

