      <style type="text/css">
        .action_icons{
          margin:10px;
          cursor: pointer;
        }
        .action_icons:hover{
          color: grey !important;
        }
        .loader{
          display: none;
        }
      </style>
      <div class="col-lg-12 grid-margin stretch-card vote_poll_data loader">
        <div class="prod--wrapper">
          <div class="prod--col prod--img">
            <img id="productImage" class="prod--img-graphic skeleton-loader" />
          </div>
          <div class="prod--col prod--details">
            <div class="prod--row prod--name">
              <span id="productName" class="prod--name-text skeleton-loader"></span>
            </div>
            <div class="prod--row prod--description">
              <span
                id="productId"
                class="prod--description-text skeleton-loader"
                ></span>
            </div>
          </div>
        </div>
      </div>


      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row volte_list_data" data-page="1" data-final_data="0">
          </div>
        </div>
        <script type="text/javascript">
          window.onload = function() {
            view_votes("<?= $this->uri->segment(3); ?>");
          };
        </script>