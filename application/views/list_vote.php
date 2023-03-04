      <style type="text/css">
        .action_icons{
          margin:10px;
          cursor: pointer;
        }
        .action_icons:hover{
          color: grey !important;
        }
      </style>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Votes</h4>
                  <div class="table-responsive">
                    <table class="table table-striped vote_list_data">
                      <thead>
                        <tr>
                          <th>
                            User Name
                          </th>
                          <th>
                            Question
                          </th>
                          <th>
                            Answers
                          </th>
                          <th>
                            Date of Expiry 
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          window.onload = function() {
            load_votes();
          };
        </script>