      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Vote</h4>
                  <form class="forms-sample">
                    <div class="form-group">
                      <label for="question">Question</label>
                      <textarea class="form-control textarea_input" id="question" placeholder="Question"></textarea>
                    </div>
                    <div class="form-group">
                      <div class="form-group add_answer_container">
                        <label for="answer">Answers</label><i class="mdi mdi-gamepad-round add_answer"></i>
                        <span class="ans_div">
                          <input class="form-control answer_input" id="answer" placeholder="Answer"><span class="mdi mdi-minus-circle-outline del_answer"></span>
                        </span>
                        <span class="ans_div">
                          <input class="form-control answer_input" id="answer" placeholder="Answer"><span class="mdi mdi-minus-circle-outline del_answer"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="answer">Expiry Date</label>
                      <div id="expiry_datepicker-popup" class="input-group date datepicker navbar-date-picker form-group">
                        <span class="input-group-addon input-group-prepend border-right">
                          <span class="icon-calendar input-group-text calendar-icon"></span>
                        </span>
                        <input type="text" id="expiry_date" class="form-control">
                      </div>
                    </div>
                    <button class="btn btn-primary me-2 add_answer_btn">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          window.onload = function() {
            load_vote_detil("<?= $this->uri->segment(3); ?>");
          };
        </script>
<style type="text/css">
  .textarea_input{
    min-height:6rem !important;
  }
  .answer_input{
    margin-top: 10px;
    width: 95%;
  }
  .add_answer{
    margin: 10px;
    cursor: pointer;
    color: #168116;
  }
  .del_answer{
    margin-top: -25px;
    margin-left: -25px;
    cursor: pointer;
    color: #d50000;
    float: right;
  }
</style>