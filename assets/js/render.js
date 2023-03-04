

$(document).on("click",".add_answer",function(){
	if($(".add_answer_container").find('.ans_div').length < 5){
		$(".add_answer_container").append(`<span class="ans_div">
                          <input class="form-control answer_input" id="answer" placeholder="Answer"><span class="mdi mdi-minus-circle-outline del_answer"></span>
                        </span>`);
	}else{
		// alertify.success( message ); // same as alertify.log( message, "success" );
		alertify.error( 'Maximum Limit Reached!' ); 
	}
	
})

$(document).on("click",".del_btn",function(){
	let v_id = $(this).data("v_id");
	let el = $(this);
	$.ajax({
        url : base_url+"render/del_votes",
        type: "POST",
        data : {'v_id':v_id},
        success: function(data, textStatus, jqXHR)
        {
        	el.closest("tr").remove();
        }
        });
});
$(document).on("click",".edit_btn",function(){
	let v_id = $(this).data("v_id");
	window.location.href = base_url+"render/add_vote/"+v_id;
});
$(document).on("click",".view_btn",function(){
	let v_id = $(this).data("v_id");
	window.location.href = base_url+"render/view_vote/"+v_id;
});
$(document).on("click",".del_answer",function(){
	if($(".add_answer_container").find('.ans_div').length > 2){
		$(this).closest('.ans_div').remove();
	}else{
		// alertify.success( message ); // same as alertify.log( message, "success" );
		alertify.error( 'Minimum Limit Reached!' ); 
	}
})

function load_vote_detil(v_id){
	if(v_id){
		$.ajax({
	        url : base_url+"render/load_vote_row",
	        type: "POST",
	        data : {"v_id":v_id},
	        success: function(data, textStatus, jqXHR)
	        {
	         	let vote = JSON.parse(data);
	         	$('#question').val(vote.result[0].question);
	         	$('#expiry_date').datepicker('setDate', vote.result[0].expiry);
	         	$(".add_answer_container").find(".ans_div").remove();
	         	let ans = JSON.parse(vote.result[0].ans);
	         	$(".add_answer_btn").data("v_id",vote.result[0].v_id);
	         	ans.map(vote_ans =>{
	         		$(".add_answer_container").append(`<span class="ans_div">
			                          <input class="form-control answer_input" id="answer" placeholder="Answer" value="${vote_ans}"><span class="mdi mdi-minus-circle-outline del_answer"></span>
			                        </span>`);
	         	});
	            //data - response from server
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	     
	        }
	    });
	}
}
$(document).off("click",".add_answer_btn");
$(document).on("click",".add_answer_btn",function(e){
  let btn = $(this);
  btn.attr("disabled",true);
  e.preventDefault();
  let question = $("#question").val();
  let expiry_date = $("#expiry_date").val();
  let ans = [];
  $(".add_answer_container").find('.ans_div').each(function(){
    let answer = $(this).find(".answer_input").val();
    ans.push(answer);
  });
  	let v_id = $(this).data('v_id');
    let action = (v_id) ? 'update_qun' : 'add_qun';
  $.ajax({
      url :  base_url+"render/"+action,
      type: "POST",
      data : {'question':question,
        'expiry_date':expiry_date,
        'v_id':v_id,
        'ans':ans},
      success: function(data, textStatus, jqXHR)
      {
        btn.attr("disabled",false);
        if(action == 'add_qun'){
        	alertify.success( "Vote addded successfully" ); // same as alertify.log( message, "success" );
        }else{
        	alertify.success( "Vote updated successfully" ); // same as alertify.log( message, "success" );
        }
        
          //data - response from server
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
   
      }
  });
})
function load_votes(){
	$.ajax({
        url : base_url+"render/load_votes",
        type: "POST",
        data : {},
        success: function(data, textStatus, jqXHR)
        {
         	let vote_list = JSON.parse(data);
         	vote_list.result.map(votes => {
         		let ans = JSON.parse(votes.ans);
         		let del_btn = (user_id == votes.user_id) ? `<span class="mdi mdi-delete action_icons text-danger del_btn" data-v_id="${votes.v_id}"></span>` : "";
         		let action = `<span class="mdi mdi-grease-pencil action_icons text-primary edit_btn" data-v_id="${votes.v_id}"></span><span class="mdi mdi-eye-outline action_icons text-success view_btn" data-v_id="${votes.v_id}"></span>${del_btn}`;
         		$(".vote_list_data").append(`<tr>
                          	<td>${votes.user_name}</td><td>${votes.question}</td><td>${ans}</td><td>${votes.expiry}</td><td>${action}</td>
                        </tr>`);
         	})
            //data - response from server
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
     
        }
    });
}
function load_dashboard_votes(start_date=null,end_date=null){
	$(".dashboard_date").show();
	let dateRangeString = $(".dashboard_date").val();
	let [startDateString, endDateString] = dateRangeString.split(' - ');

	let startDateString_d = (start_date) ? start_date : startDateString;
	let endDateString_d = (end_date) ? end_date : endDateString;
	// Convert the start and end date strings to Date objects
	let startDate = new Date(startDateString_d);
	let endDate = new Date(endDateString_d);

	let startDate_timestamp = startDate.getTime();
	let endDate_timestamp = endDate.getTime();
// console.log(startDateString_d,endDateString_d);
	$.ajax({
        url : base_url+"render/load_dashboard_votes",
        type: "POST",
        data : {'startDate_timestamp':startDate_timestamp,'endDate_timestamp':endDate_timestamp},
        success: function(data, textStatus, jqXHR)
        {
         	// if ($("#marketingOverview").length) {
		      // var marketingOverviewChart = document.getElementById("marketingOverview").getContext('2d');
		      let labels_data = [];
		      let chart_data = [];
		      data = JSON.parse(data);
		      let dashboarddata = data.dashboard_data;
		      for (var key in dashboarddata) {
		      	labels_data.push(key);
		      }
		      let dash_data = [];
		      // dash_data['data'] = [];
		      labels_data.map(function(data,index) {
		      	let totat_daily_count = 0;
		      	for (var key in dashboarddata[data]) {
			    	totat_daily_count += dashboarddata[data][key];
			    }
			    dash_data.push(totat_daily_count);
			     // console.log(chart_data);
			     
		      });
		       
		      
		     var options = {
		          scales: {
		            yAxes: [{
		              ticks: {
		                beginAtZero: true
		              }
		            }]
		          },
		          legend: {
		            display: false
		          },
		          elements: {
		            point: {
		              radius: 0
		            }
		          }

		        };
		        var data = {
		          labels: labels_data,
		          datasets: [{
		            label: '# of Votes',
		            data: dash_data,
		            backgroundColor: [
		              'rgba(255, 99, 132, 0.2)',
		              'rgba(54, 162, 235, 0.2)',
		              'rgba(255, 206, 86, 0.2)',
		              'rgba(75, 192, 192, 0.2)',
		              'rgba(153, 102, 255, 0.2)',
		              'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		              'rgba(255,99,132,1)',
		              'rgba(54, 162, 235, 1)',
		              'rgba(255, 206, 86, 1)',
		              'rgba(75, 192, 192, 1)',
		              'rgba(153, 102, 255, 1)',
		              'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1,
		            fill: false
		          }]
		        };
		         if ($("#barChart").length) {
		          var barChartCanvas = $("#barChart").get(0).getContext("2d");
		          // This will get the first returned node in the jQuery collection.
		          var barChart = new Chart(barChartCanvas, {
		            type: 'bar',
		            data: data,
		            options: options
		          });
		        }
		    // }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
     
        }
    });
}
window.addEventListener('scroll', function() {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            view_votes();
           // Here goes your code.
     }
});
function view_votes(v_id=null){
	
	let final_data = $(".volte_list_data").data("final_data");
	// console.log(final_data);
	if(final_data == 1){
		return false;
	}
	let loader = $(".loader");
	let loader_html = loader.clone();
	$(".loader").hide();
	$(".volte_list_data").append(loader_html).show();
	let page = $(".volte_list_data").data("page");
	// return false;
	$.ajax({
        url : base_url+"render/load_votes_with_pagination",
        type: "POST",
        data : {'v_id':v_id,'page':page},
        success: function(data, textStatus, jqXHR)
        {
        	$(".volte_list_data").data("final_data",1);
        	$(".volte_list_data").find(".loader").remove();
        	
        	$(".volte_list_data").data("page",page+1);
         	let vote_list = JSON.parse(data);
         	if(vote_list.result.length > 0){
         		vote_list.result.map(votes => {
	         		let ans = JSON.parse(votes.ans);
	         		let voted_users = (votes.voted_users) ? JSON.parse(votes.voted_users) : {};
	         		let answer = '';
	         		let have_val = have_poll = false;
	         		let ansarr = [];
	         		let total_ans = 0;
	         		ans.map(ans_val =>{
	         			ansarr[ans_val] = (voted_users[ans_val]) ? voted_users[ans_val].length : 0;
	         			total_ans += ansarr[ans_val];
	         		});

	         		ans.map(ans_val =>{
	         			// console.log(ansarr[ans_val]);
	         			let persentage = (ansarr[ans_val]/total_ans)*100;
	         			persentage = (persentage) ? parseFloat(persentage.toFixed(2)) : 0;
	         			if(have_val == false){
	         				have_val = (voted_users[ans_val] && voted_users[ans_val].includes(user_id)) ? true : false;
	         			}
	         			have_poll = (voted_users[ans_val] && voted_users[ans_val].includes(user_id)) ? true : false;
	         			// let 
	         			let selected_poll = (have_poll) ? 'selected' : '';
	         			ans_id = ans_val.split(' ').join('_');
	         			// ansarr[ans_val] = (ansarr[ans_val]) ? ansarr[ans_val] : 0;

	         			
	         			
	         			answer += `<span><input type="checkbox" name="poll" id="${ans_id}">
	         						<label class="vote_poll ${selected_poll}" data-ans_val="${ans_val}" for="opt-1" class="${ans_id}">
				                        <div class="row">
				                          <div class="column">
				                            <span class="circle"></span>
				                            <span class="text">${ans_val}</span>
				                          </div>
				                          <span class="percent"><span class="percent_val">${persentage}</span>%</span>
				                        </div>
				                        <div class="progress" style='--w:${persentage};'></div>
				                      </label></span>`;
	         		});
	         		// console.log(ansarr);
	         		let answer_data = $(answer);
	         		// console.log(answer_data.find('.vote_poll'));
	         		let expiry = `Will expire on ${votes.expiry}`;
	         		if(have_val || (vote_list.now > votes.expiry_date)){
	         			answer_data.find('.vote_poll').addClass("selectall disable_element");
	         		}
	         		if(vote_list.now > votes.expiry_date){
	         			expiry = `Expired on ${votes.expiry}`;
	         		}
	         		let vote_qn = $(`<div class="col-lg-12 grid-margin stretch-card vote_poll_data" data-v_id="${votes.v_id}" data-total="${total_ans}">
							              <div class="card">
							                <div class="card-body">
							                    <h4 class="card-title">${votes.question} (${expiry})</h4>
							                    <div class="poll-area">
							                    </div>
							                </div>
							              </div>
							            </div>`);
	         		vote_qn.find('.poll-area').append(answer_data);
	         		$(".volte_list_data").append(vote_qn);
	         	})
         	}
         	// console.log(vote_list.final_data);
        	$(".volte_list_data").data("final_data",vote_list.final_data);
            //data - response from server
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
     
        }
    });
}



$(document).on("click",".vote_poll",function(){
	let vote_poll_data = $(this).closest(".vote_poll_data").find(".vote_poll");
// console.log($(this).closest("vote_poll_data").find(".vote_poll"));
	$(this).addClass("selected");
	let total = $(this).closest(".vote_poll_data").data('total');
	let new_total = $(this).closest(".vote_poll_data").data('total') + 1;
	let ans_val = $(this).data("ans_val");
	vote_poll_data.each((i,votepoll) => {
		// console.log(votepoll);
		let ans_valuse = $(votepoll).data('ans_val');
		let ans_perc = parseFloat($(votepoll).find(".percent_val").text());
		let value = (ans_perc / 100) * total;
		let perc = (ans_valuse == ans_val) ? value+1 : value;
		let persentage = (perc/new_total)*100;
		// console.log(persentage);
		persentage = parseFloat(persentage.toFixed(2))
		$(votepoll).addClass("selectall disable_element");
		$(votepoll).find(".percent_val").html(persentage);
		$(votepoll).find(".progress").css('--w',persentage);
	})
	let v_id = $(this).closest(".vote_poll_data").data('v_id');

	
	$.ajax({
        url : base_url+"render/set_vote",
        type: "POST",
        data : {'v_id':v_id,
    			'ans_val':ans_val},
        success: function(data, textStatus, jqXHR)
        {
        },
    });
})
