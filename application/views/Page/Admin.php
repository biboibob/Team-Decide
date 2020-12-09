<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/Admin.css"/>
</head>
<body>
	<div class="container-fluid" style="height: 100%;position: absolute;">
		<div class="row" style="height: 100%;">
			<div class="col-3 menuTab" style="height: 100% !important;align-items: center;justify-content: center;">
				<img src="<?php echo base_url()?>assets/image/TDB.png" style="width: 150px;margin-left: 100px;margin-top: 30px;">
				<div class="separator">Admin Dashboard</div>

				<div style="margin-top: 30px;font-family: Mabry Pro" class="mangamentSideContent">
				<h5>Home</h5>
					<ul style="list-style: none;" class="listSubmenu">
					  <a href="#Analytics"><li>Statistics</li></a>
					</ul>

				<h5 style="margin-top: 20px;">Management</h5>
				
					<ul style="list-style: none;" class="listSubmenu">
					  <a href="#projectManagement"><li>Project Management</li></a>
					  <a href="#userManagement" class="userManage"><li>User Management</li></a>
					  <a href="#reportManagement"><li>Report Management</li></a>
					</ul>
				</div>

				<a href="<?php echo base_url('PilihProject_C/logout'); ?>" style="position: absolute;bottom: 0;" class="logout">
				
					<i class="fas fa-power-off" style="margin-right: 5px;"></i>Logout
				</a>
				
			</div>

			<div class="col-9 contentTab" style="height: 100% !important;">

				<!-- Analytics -->

				<div id="Analytics" class="contents" style="height: 100% !important;">
					<div class="row" style="display: flex;justify-content: flex-end;margin-right: 50px;"> 
						<p style="font-size: 3.5vw;line-height: 35px;color: white; font-family: Mabry Pro;">Statistics</p>
					</div>
 					
 					<h5 style="margin-left: 20px;color:white;">Report Data</h5>
					<div class="row" style="margin-left: 20px;">
						<div class="col-5" style="background-color: white;border-radius: 10px;display: flex;align-items: center;justify-content: center;margin-right: 20px;">
							<canvas id="totalReport" height="250" ></canvas>
						</div>
						<div class="col-2" style="background-color: white;border-top-left-radius: 10px;border-bottom-left-radius: 10px;display: flex;justify-content: center;">
							<canvas id="statisticUserReport"  width="300"></canvas>
						</div>
						<div class="col-2" style="background-color: white;display: flex;justify-content: center;">
							<canvas id="statisticBoardReport" width="300"></canvas>
						</div>
						<div class="col-2" style="background-color: white;border-top-right-radius: 10px;border-bottom-right-radius: 10px;display: flex;justify-content: center;">
							<canvas id="statisticActivtyReport" width="300"></canvas>
						</div>
					</div>

					<!-- Total  -->

					<div class="row" >
						<div class="col-6" style="margin-left: 20px;margin-top: 20px;">
							<div class="row">
								<div class="col">
									<p style="font-size: 4vw;line-height: 35px;color:#0079BF;text-align: center;background-color: white;padding:12px;border-radius: 10px;"><span class="count"><?php echo $total ?></span><br><span style="font-size: 1vw;font-weight: bold;">Total Project</span></p>
								</div>
								<div class="col">
									<p style="font-size: 4vw;line-height: 35px;color:#0079BF;text-align: center;background-color: white;padding:12px;border-radius: 10px;"><span class="count"><?php echo $totalUser ?></span><br><span style="font-size: 1vw;font-weight: bold;">Total User</span></p>
								</div>
								<div class="col">
									<p style="font-size: 4vw;line-height: 35px;color:#0079BF;text-align: center;background-color: white;padding:12px;border-radius: 10px;"><span class="count"><?php $totalReport = $userReport + $boardReport + $activityReport;
												 echo $totalReport ?></span><br><span style="font-size: 1vw;font-weight: bold;">Total Report</span></p>
								</div>
							</div>

							<h5 style="color:white;">User Increement</h5>
							<div class="row" style="margin-left: 0px;margin-right: 0px;">
								<div class="col" style="background-color: white;border-radius: 10px;">
									<canvas id="statisticUserIncreement" width="300" height="180"></canvas>
								</div>
							</div>
						</div>
						<div class="col-5">
							<h5 style="color:white;margin-left: -15px;margin-top: 20px;">Project Detail</h5>
							<div class="row">
								<div class="col" style="background-color: white;border-radius: 10px;display: flex;justify-content: center;">
									<canvas id="statisticProject" height="310" ></canvas>
								</div>
							</div>
								
								
						</div>
					</div>

					<script>

						/*Total Report*/

						var ctx = document.getElementById('totalReport');
						var myChart = new Chart(ctx, {
						    type: 'bar',
						    responsive :"true",
						    data: {
						        labels: ["User Report","Board Report","Activity Report"],
						        datasets: [{
						            label: 'Total Report',
						            data: [<?php echo $userReport?>,<?php echo $boardReport?>,<?php echo $activityReport?>],
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 2
						           
						        }]
						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						    	 	display:false,
						            labels: {
						                fontColor: '#0079BF',
						                fontSize: 14,

						            }
						        },
							    title: {
							      display: true,
							      text: 'Total Report',
							      fontColor: '#0079BF',
							      fontSize:"16",
							    },
						        scales: {


							      xAxes: [{
							        display: true,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Category',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: true,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Total Report',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                    userCallback: function(label, index, labels) {
						                     // when the floored value is the same as the value we have a whole number
						                     if (Math.floor(label) === label) {
						                         return label;
						                     }

						                 },
						                }
							      }]
							    }
						    }

						});

						/*End Total Report*/

						/*Start User Report Statistics*/

						var ctx = document.getElementById('statisticUserReport');
						var myChart = new Chart(ctx, {
						    type: 'doughnut',
						    responsive :"true",
						    data: {
						        labels: [<?php
            					  foreach ($statisticUserReport as $data) {
                					echo "'" .$data->reported_user ."',";
              					}
            
          						?>],
						        datasets: [{
						            label: '# Hide',
						            data: [<?php
                   						foreach ($statisticUserReport as $data) {
                    						echo $data->total . ", ";
                  						}
                
              						?>],
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 2
						           
						        }]
						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						    	 	display: false,
						            labels: {
						                fontColor: '#0079BF',
						                fontSize: 8,


						            }
						        },

							    title: {
							      display: true,
							      text: 'User Report',
							      fontColor: '#0079BF',
							      fontSize:"14",
							    },
						        scales: {


							      xAxes: [{
							        display: false,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Category',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: false,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Value',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                }
							      }]
							    }
						    }

						     
						});

						/*End User Statistic*/

						/*Start Board Statistic*/

						var ctx = document.getElementById('statisticBoardReport');
						var myChart = new Chart(ctx, {
						    type: 'doughnut',
						    responsive :"true",
						    data: {
						        labels: [<?php
            					  foreach ($statisticBoardReport as $data) {
                					echo "'" .$data->reported_board ."',";
              					}
            
          						?>],
						        datasets: [{
						            label: '# Hide',
						            data: [<?php
                   						foreach ($statisticBoardReport as $data) {
                    						echo $data->total . ", ";
                  						}
                
              						?>],
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 2
						           
						        }]
						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						            display: false
						        },
						        
							    title: {
							      display: true,
							      text: 'Board Report',
							      fontColor: '#0079BF',
							      fontSize:"14",
							    },
						        scales: {


							      xAxes: [{
							        display: false,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Category',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: false,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Value',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                }
							      }]
							    }
						    }

						     
						});

						/*End Board Report*/

						/*Star Activity Report*/

						var ctx = document.getElementById('statisticActivtyReport');
						var myChart = new Chart(ctx, {
						    type: 'doughnut',
						    responsive :"true",
						    data: {
						        labels: [<?php
            					  foreach ($statisticActivityReport as $data) {
                					echo "'" .$data->reported_board_activity ."',";
              					}
            
          						?>],
						        datasets: [{
						            label: '# Hide',
						            data: [<?php
                   						foreach ($statisticActivityReport as $data) {
                    						echo $data->total . ", ";
                  						}
                
              						?>],
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 2
						           
						        }]
						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						             display: false
						        },
						      
							    title: {
							      display: true,
							      text: 'Activity Report',
							      fontColor: '#0079BF',
							      fontSize:"14",
							    },
						        scales: {


							      xAxes: [{
							        display: false,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Category',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: false,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Value',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                }
							      }]
							    }
						    }

						     
						});

						/*End Activity Report*/


						/*Start User Increement*/

						var ctx = document.getElementById('statisticUserIncreement');
						var myChart = new Chart(ctx, {
							
						    type: 'line',
						    responsive :"true",
						    data: {
						        labels: [<?php
            					  foreach ($statisticUserIncreement as $data) {
                					echo "'" .$data->join_date ."',";
              					}
            
          						?>],
						        datasets: [{
						            label: 'User Register',
						            data: [<?php
                   						foreach ($statisticUserIncreement as $data) {
                    						echo $data->total . ", ";
                  						}
                
              						?>],
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 2
						           
						        }]
						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						    	 	display: false,
						            labels: {
						                fontColor: '#0079BF',
						                fontSize: 8,


						            }
						        },

							    title: {
							      display: true,
							      text: 'User Increement Per-Day',
							      fontColor: '#0079BF',
							      fontSize:"14",
							    },
						        scales: {


							      xAxes: [{
							        display: true,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Date',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: true,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'User Register',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                    userCallback: function(label, index, labels) {
						                     // when the floored value is the same as the value we have a whole number
						                     if (Math.floor(label) === label) {
						                         return label;
						                     }

						                 },
						                }
							      }]
							    }
						    }

						     
						});

						/*End User Increement*/

						/*Start Project Statistic*/

						
						var ctx = document.getElementById('statisticProject');
						var myChart = new Chart(ctx, {
							
						    type: 'bar',
						    responsive :"true",
						    data: {
						        labels: [<?php
            					  foreach ($statisticProject as $data) {
                					echo "'" .$data->project_title ."',";
              					}
            
          						?>],


						        datasets: [{

								    label: "Total Board",
								    data: [
								    <?php foreach ($statisticProject as $data) {
	                					echo "'" .$data->totalBoard ."',";
	              							}?>],
	              					backgroundColor: "#fff3cd",
							        borderColor: "#ffc38b",
							        borderWidth: 2

									  }, {

									    label: "Total Activity",
									    data: [
								    <?php foreach ($statisticProject as $data) {
	                					echo "'" .$data->totalActivity ."',";
	              							}?>],
	              						backgroundColor: "#def4f0",
								        borderColor: "#74d4c0",
								        borderWidth: 2
									  }]

						    },
						    options: {
						    	responsive: true,
						    	maintainAspectRatio: false,
						    	 legend: {
						    	 	display: true,
						            labels: {
						                fontColor: '#0079BF',
						                fontSize: 8,


						            }
						        },

							    title: {
							      display: true,
							      text: 'Project Details',
							      fontColor: '#0079BF',
							      fontSize:"14",
							    },
						        scales: {


							      xAxes: [{
							        display: true,
							        fontColor: '#0079BF',
							        gridLines: {
  									  display:true,
  									  color: "transparent",
  									  zeroLineColor: '#0079BF',
  									  zeroLineWidth : "2",
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Project Title',
							          fontColor: '#0079BF',
							        },
							         ticks: {
					                    beginAtZero:true,
					                    fontColor: '#0079BF',
					                },
							      }],


							      yAxes: [{
							        display: true,
							        fontColor: "white",
							        gridLines: {
							          display :true,
							          color: "transparent",
							          zeroLineColor: '#0079BF',
							          zeroLineWidth : "2", 
							        },
							        scaleLabel: {
							          display: true,
							          labelString: 'Value',
							          fontColor: '#0079BF',
							        },
							        ticks: {
						                    beginAtZero: true,
						                    fontColor: '#0079BF',
						                    userCallback: function(label, index, labels) {
						                     // when the floored value is the same as the value we have a whole number
						                     if (Math.floor(label) === label) {
						                         return label;
						                     }

						                 },
						                }
							      }]
							    }
						    }

						     
						});


						

						
			

						/*End User Increement*/

						
						
						    
						</script>
				</div>

				<!-- End Of Analytics -->

				<!-- Project Management -->

				<div id="projectManagement" class="contents">
				<div class="row" style="padding-right: 20px;padding-left: 20px;">
					<div class="col-8">
						<div class="row" style="border:2px solid white;height: 180px;">
							<div class="col-8" style="background-color: white;color:#0079BF;">
								<h5>Project</h5>
									<div style="width: 100%;height: 130px;overflow: auto;">
										<table class="tableProject">
											<?php foreach ($all_project as $value) { ?>
												<tr class="detailProject" data-id="<?php echo $value->id_project ?>" style="cursor: pointer;">
													<td><?php echo $value->project_title ?></td>
													<td><i class="fas fa-eye" style="margin-right: 5px;"></i>
														</td>
												</tr>
											<?php } ?>
										</table>
									</div>
							</div>
							<div class="col-4" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
								<p style="font-size: 7vw;line-height: 35px;color: white;text-align: center;"><span class="count"><?php echo $total ?></span><br><span style="font-size: 2vw;">Total Project</span></p>
							</div>
						</div>
					</div>
					<div class="col-4" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
						<p style="font-size: 2vw;line-height: 30px; ;color: white;">Project<br><span style="font-size: 3vw">Management</span></p>
					</div>	
				</div>
					<div class="separator" style="margin-bottom: 30px;font-size: 25px;">Project User Experience</div>
				<div class="row" style="width: 100%;">
					<div class="col-6">
						<h5 style="color:white">Board</h5>
							<table class="fixed_header">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Project</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="boardTable">
			
							  </tbody>
							</table>
					</div>
					<div class="col-6">
						<h5 style="color:white">Project Member</h5>
							<table class="fixed_header">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Username</th>
							      <th>Authority</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="projectMemberTable">
							 
							  </tbody>
							</table>
					</div>
					
				</div>

				<!-- ROW SECTION 2 -->

				<div class="row" style="width: 100%;margin-top: 30px;">
					<div class="col-6">
						<h5 style="color:white">Board Activity</h5>
							<table class="fixed_header">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Activity Title</th>
							      <th>From Board</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="boardActivity">
							    
							  </tbody>
							</table>
					</div>
					<div class="col-6">
						<h5 style="color:white">Document</h5>
							<table class="fixed_header">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Document Name</th>
							      <th>From Board</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="Document">
							    
							  </tbody>
							</table>
					</div>
				</div>
				</div>

				<!-- End Project Management -->

				<!-- User Management Start -->

				<div id="userManagement" class="contents"> 
					<div class="row">
						<div class="col" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
						<p style="font-size: 2vw;line-height: 30px; ;color: white;">User<br><span style="font-size: 3vw">Management</span></p>
					</div>	
						<div class="col" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
								<p style="font-size: 7vw;line-height: 35px;color: white;text-align: center;"><span class="count"><?php echo $totalUser ?></span><br><span style="font-size: 2vw;">Total User</span></p>
						</div>
					</div>

					<div class="row" style="margin-top: 30px;padding-right: 20px;padding-left: 20px;" >
						<table class="fixed_header" id="tableUserManagement" >
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Username</th>
							      <th>Password</th>
							      <th>Email</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="userData" style="height: 450px !important;">
							    
							  </tbody>
							</table>
					</div>
				</div>

				<!-- End User Management -->

				<!-- Start Report Management -->

				<div id="reportManagement" class="contents">
					<div class="row" style="padding-right: 20px;padding-left: 20px;" >
						<div class="col-6">
							<div class="row" style="border:2px solid white;height: 180px;">
								<div class="col-5" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
									<p style="font-size: 6vw;line-height: 35px;color: white;text-align: center;">
										<?php $totalReport = $userReport + $boardReport + $activityReport;

										 echo $totalReport ?>
										<br><span style="font-size: 1.5vw;">Total Report</span></p>
								</div>
								<div class="col-7" style="background-color: white;color:#0079BF;text-align: center;padding-top: 30px;">
									<div class="row" style="font-size: 1.2vw;font-weight: bold;margin-bottom: 10px;">
										<div class="col-4" style="text-align: right;">
											<?php echo $userReport?>
										</div>
										<div class="col-8" style="text-align: left;">
											User Report
										</div>
									</div>
									<div class="row" style="font-size: 1.2vw;font-weight: bold;margin-bottom: 10px;">
										<div class="col-4" style="text-align: right;">
											<?php echo $boardReport?>
										</div>
										<div class="col-8" style="text-align: left;">
											Board Report
										</div>
									</div>
									<div class="row" style="font-size: 1.2vw;font-weight: bold;">
										<div class="col-4" style="text-align: right;">
											<?php echo $activityReport?>
										</div>
										<div class="col-8" style="text-align: left;">
											Activity Report
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<div class="col-6" style="display: flex;align-items: center;justify-content: center;margin-top: 20px;font-family: Mabry Pro;">
							<p style="font-size: 2vw;line-height: 30px; ;color: white;">Report<br><span style="font-size: 3vw">Management</span></p>
						</div>	
					</div>

					<div class="row" style="margin-top: 10px;padding-right: 20px;padding-left: 20px;">

						<h5 style="color:white;">User Report</h5>
						<table class="fixed_header" id="tableUserManagement">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Reported User</th>
							      <th>Total Report</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="tableUserReport">
							    
							  </tbody>
							</table>
					</div>

					<div class="row" style="margin-top: 10px;padding-right: 20px;padding-left: 20px;">

						<h5 style="color:white;">Board Report</h5>
						<table class="fixed_header" id="tableUserManagement">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Reported Board</th>
							      <th>Total Report</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="tableBoardReport">
							    
							  </tbody>
							</table>
					</div>

					<div class="row" style="margin-top: 10px;padding-right: 20px;padding-left: 20px;">

						<h5 style="color:white;">Board Activity Report</h5>
						<table class="fixed_header" id="tableUserManagement">
							  <thead>
							    <tr>
							      <th>No</th>
							      <th>Reported Board Activity</th>
							      <th>Total Report</th>
							      <th>Action</th>
							     
							    </tr>
							  </thead>
							  <tbody class="tableActivityReport">
							  
							    
							  </tbody>
							</table>
					</div>

					
					</div>
				</div>

				<!-- End Report Management -->

			</div>
		</div>

	


	<!-- Modal Board Project Management -->

		<div class="modal fade" id="projectMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">

		  	<form id="formTest" method="post" action="<?php echo base_url()?>Admin_C/changeAuthUser">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Project Member Change</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body" style="padding-right: 20px;padding-left: 20px;margin-top: 10px;margin-bottom: 30px;">
		        <p style="font-weight: 600;margin: 0px;">Username</p>
		        	<input  style="width: 100%;margin-bottom: 10px;" class="form-control labelUsernameMember">
		        	<input  type="hidden" name="idUname" style="width: 100%;margin-bottom: 10px;" id="labelUsernameMember">
		        <p style="font-weight: 600;margin:0px;">Authority</p>
		        <select name="selectAuth" class="form-control">
		        	<option selected value=""></option>
		        	<option value="Chairman">Chairman</option>
		        	<option value="member">member</option>
		        </select>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="submit" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
			</form>

		  </div>
		</div>

	<!-- Modal Detail Report -->

		<div class="modal fade" id="modalDetailReport" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">

		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Detail Report</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body detailReport" style="padding-right: 20px;padding-left: 20px;margin-top: 10px;margin-bottom: 30px;">
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		

		  </div>
		</div>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function () {
		 		/*$('.listSubmenu a :first').addClass('active');*/
		 		$('.contents:not(:first)').hide();

		 		$('.listSubmenu a').click(function (event) {
		 			event.preventDefault();

		 			var content = $(this).attr('href');

		 			/*$(this).siblings().removeClass('active');
		 			$(this).addClass('active');*/
		 			
		 			$(content).show();
		 			$(content).siblings('.contents').hide();
		 		});

	});

	/*animation count*/
	$('.count').each(function () {
	    $(this).prop('Counter',0).animate({
	        Counter: $(this).text()
	    }, {
	        duration: 3000,
	        easing: 'swing',
	        step: function (now) {
	            $(this).text(Math.ceil(now));
	        }
	    });
	});


	$(".detailProject").click(function () {
		var id_project = $(this).data("id");
		
		$.ajax({
			url: "<?php echo base_url() ?>Admin_C/showSelectedProject",
			method: "POST",
			data: {id_project:id_project},
			dataType : 'json',

			success: function(response){

				 var numberFirst = 1;
				 console.log(response);

				 //Board Section//

				 var board_data = "";

				 $.each(response.boardData,function(key,value) {
				 	board_data += '<tr>';
				 	board_data += '<td>'+numberFirst+'</td>';
				 	board_data += '<td>'+value.board_title+'</td>';
				 	board_data += '<td><i class="fas fa-trash-alt deleteBoard" data-id="'+value.id_board+'" style="cursor:pointer;"></i></td>';
				 	board_data += '</tr>';

				 	numberFirst++;
				 });
 				
 				$(".boardTable").html(board_data);

 				$(".deleteBoard").click(function() {
 					var id = $(this).data("id");

					Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					  	$.ajax({
				        url: "<?php echo base_url() ?>Admin_C/deleteBoard",
				        type: "POST",
				        data : {id:id},

				        success:function(data) {
				        	Swal.fire(
								 'Deleted!',
								 'Your file has been deleted.',
								 'success'
							 )

							 setTimeout(function() {
								location.reload();
							 },3000);
				        	}
						});
						 	
					  }
					});
					 
				});





 				//Project Member Section //
 				var numberSec = 1;
 				var projectMemberTable = "";

 				$.each(response.projectMember ,function(key,value) {
				 	projectMemberTable += '<tr>';
				 	projectMemberTable += '<td>'+numberSec+'</td>';
				 	projectMemberTable += '<td>'+value.username+'</td>';
				 	projectMemberTable += '<td>'+value.authority+'</td>';
				 	projectMemberTable += '<td><i data-toggle="modal" data-target="#projectMember" data-uname="'+value.username+'" data-id="'+value.id_user+'" class="fas fa-edit editMember" style="margin-right: 5px;cursor:pointer;"></i><i class="fas fa-trash-alt deleteUserProject" data-id="'+value.id_user+'" style="cursor:pointer;"></i></td>';
				 	projectMemberTable += '</tr>';

				 	numberSec++;
				 });
 				
 				$(".projectMemberTable").html(projectMemberTable);

 				$(".editMember").click(function() {
 					var username = $(this).data("uname");
 					var id = $(this).data("id");

 					$(".labelUsernameMember").val(username);
 					$("#labelUsernameMember").val(id);
				});

				$(".deleteUserProject").click(function() {
					var id = $(this).data("id");

					Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					  	$.ajax({
				        url: "<?php echo base_url() ?>Admin_C/deleteUserProject",
				        type: "POST",
				        data : {id:id},

				        success:function(data) {
				        	Swal.fire(
								 'Deleted!',
								 'Your file has been deleted.',
								 'success'
							 )

							 setTimeout(function() {
								location.reload();
							 },3000);
				        	}
						});
						 	
					  }
					});

			
				});


 				//Board Activty//
 				var numberThird = 1;
 				var boardActivity = "";

 				$.each(response.boardActivity ,function(key,value) {
				 	boardActivity += '<tr>';
				 	boardActivity += '<td>'+numberThird+'</td>';
				 	boardActivity += '<td>'+value.activity_title+'</td>';
				 	boardActivity += '<td>'+value.board_title+'</td>';
				 	boardActivity += '<td><i class="fas fa-trash-alt deleteActivity" data-id="'+value.id_activity+'" style="cursor:pointer;"></i></td>';
				 	boardActivity += '</tr>';

				 	numberThird++;
				 });
 				
 				$(".boardActivity").html(boardActivity);

 				$(".deleteActivity").click(function() {
					var id = $(this).data("id");

					Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					  	$.ajax({
				        url: "<?php echo base_url()?>Admin_C/deleteActivity",
				        type: "POST",
				        data : {id:id},

				        success:function(data) {
				        	Swal.fire(
								 'Deleted!',
								 'Your file has been deleted.',
								 'success'
							 )

							 setTimeout(function() {
								location.reload();
							 },3000);
				        	}
						});
						 	
					  }
					});

				});


 				//Document//
 				var numberFourth = 1;
 				var Document = "";

 				$.each(response.boardDocument ,function(key,value) {
				 	Document += '<tr>';
				 	Document += '<td>'+numberFourth+'</td>';
				 	Document += '<td>'+value.judul_dokumen+'</td>';
				 	Document += '<td>'+value.board_title+'</td>';
				 	Document += '<td><i class="fas fa-trash-alt deleteDocument" data-id="'+value.id_document+'" style="cursor:pointer;"></i></td>';
				 	Document += '</tr>';

				 	numberFourth++;
				 });
 				
 				$(".Document").html(Document);

 				$(".deleteDocument").click(function() {
					var id = $(this).data("id");

					Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					  	$.ajax({
				        url: "<?php echo base_url()?>Admin_C/deleteDocument",
				        type: "POST",
				        data : {id:id},

				        success:function(data) {
				        	Swal.fire(
								 'Deleted!',
								 'Your file has been deleted.',
								 'success'
							 )

							 setTimeout(function() {
								location.reload();
							 },3000);
				        	}
						});
						 	
					  }
					});
				});

			}
		});
	});


/*Fetch All User*/

$(document).ready(function () {

	/*Show All User*/

	 $.ajax({
        url: "<?php echo base_url() ?>Admin_C/showAllUser",
        type: "GET",
        dataType: "JSON",

        success:function (data) {
				
				 var numberFirst = 1;
				 var userData = "";

				 $.each(data ,function(key,value) {
				 	userData += '<tr>';
				 	userData += '<td>'+numberFirst+'</td>';
				 	userData += '<td>'+value.username+'</td>';
				 	userData += '<td>'+value.password+'</td>';
				 	userData += '<td>'+value.email+'</td>';
				 	userData += '<td><i class="fas fa-trash-alt deleteUser" data-id="'+value.id_user+'" style="cursor:pointer;"></i></td>';
				 	userData += '</tr>';

				 	numberFirst++;
				 });
 				
 				$(".userData").html(userData);

 				$(".deleteUser").click(function() {
					var id = $(this).data("id");
					console.log(id);
					Swal.fire({
								  title: 'Are you sure?',
								  text: "You won't be able to revert this!",
								  icon: 'warning',
								  showCancelButton: true,
								  confirmButtonColor: '#3085d6',
								  cancelButtonColor: '#d33',
								  confirmButtonText: 'Yes, delete it!'
								}).then((result) => {
								  if (result.value) {
								  	$.ajax({
							        url: "<?php echo base_url()?>Admin_C/deleteUser",
							        type: "POST",
							        data : {id:id},

							        success:function(data) {
							        	Swal.fire(
											 'Deleted!',
											 'Your file has been deleted.',
											 'success'
										 )

										 setTimeout(function() {
											location.reload();
										 },3000);
							        	}
									});
									 	
						 }
					});

				});
			
			}
		});

	 /*End All User*/

	});


	$(document).ready(function () {

	/*Show All Reported User*/
		 $.ajax({
	        url: "<?php echo base_url() ?>Admin_C/showAllReportUser",
	        type: "GET",
	        dataType: "JSON",

	        success:function (data) {
	        	 var numberFirst = 1;
				 var userReport = "";

				 $.each(data ,function(key,value) {
				 	userReport += '<tr>';
				 	userReport += '<td>'+numberFirst+'</td>';
				 	userReport += '<td>'+value.reported_user+'</td>';
				 	userReport += '<td>'+value.total+'</td>';
				 	userReport += '<td><i class="fas fa-info-circle detailUserReport" style="margin-right: 5px;cursor:pointer;" data-toggle="modal" data-target="#modalDetailReport" data-name="'+value.reported_user+'"></i><i class="fas fa-trash-alt deleteUserReport" data-user="'+value.reported_user+'" style="cursor:pointer;"></i></td>';
				 	userReport += '</tr>';

				 	numberFirst++;
				 });
 				
 				$(".tableUserReport").html(userReport);

	 				$(".detailUserReport").click(function() {
				     	 var user = $(this).data("name");
				     	 console.log(user);

				     	 $.ajax({
					        url: "<?php echo base_url()?>Admin_C/showDetailReportUser",
					        type: "POST",
					        data: {user:user},
					        dataType: "JSON",

					        success:function (data) {
					        	 var userReport = '<table style="width:100%;text-align:center;border:2px solid #0079BF;">';
					        	 	userReport += '<thead style="background-color:#0079BF;color:white;">';
								 	userReport += '<tr>';
								 	userReport += '<th>reported by</th>';
								 	userReport += '<th>description</th>';
								 	userReport += '<th>date report</th>';
								 	userReport += '</tr>';
								 	userReport += '</thead>';
								 	userReport += '<tbody class="detailDataReport">';

								 $.each(data ,function(key,value) {
								 	userReport += '<tr>';
								 	userReport += '<td>'+value.username+'</td>';;
								 	userReport += '<td>'+value.description+'</td>';
								 	userReport += '<td>'+value.date+'</td>';
								 	userReport += '</tr>';
								 });
								 	userReport += '</tbody>';
								 	userReport += '</table>';
				 				
				 				$(".detailReport").html(userReport);
					        }
					     });
				  });


	 			$(".deleteUserReport").click(function() {
	 				var user = $(this).data("user");

	 				Swal.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, delete it!'
					}).then((result) => {
					  if (result.value) {
					  	$.ajax({
				        url: "<?php echo base_url()?>Admin_C/deleteUserReport",
				        type: "POST",
				        data : {user:user},

				        success:function(data) {
				        	Swal.fire(
								 'Deleted!',
								 'Your file has been deleted.',
								 'success'
							 )

							 setTimeout(function() {
								location.reload();
							 },3000);
				        	}
						});
						 	
					  }
					});
	 			});
	        }
	     });


	   /*End All Reported User*/

	   /*Show All Reported Board*/
		 $.ajax({
	        url: "<?php echo base_url() ?>Admin_C/showAllReportBoard",
	        type: "GET",
	        dataType: "JSON",

	        success:function (data) {
	        	 var numberSec = 1;
				 var boardReport = "";

				 $.each(data ,function(key,value) {
				 	boardReport += '<tr>';
				 	boardReport += '<td>'+numberSec+'</td>';
				 	boardReport += '<td>'+value.reported_board+'</td>';
				 	boardReport += '<td>'+value.total+'</td>';
				 	boardReport += '<td><i class="fas fa-info-circle detailBoardReport" style="margin-right: 5px;cursor:pointer;" data-toggle="modal" data-target="#modalDetailReport" data-name="'+value.reported_board+'"></i><i class="fas fa-trash-alt deleteBoardReport" data-board="'+value.reported_board+'" style="cursor:pointer;"></i></td>';
				 	boardReport += '</tr>';

				 	numberSec++;
				 });
 				
 				$(".tableBoardReport").html(boardReport);

	 				$(".detailBoardReport").click(function() {
				     	 var board = $(this).data("name");
				     	 console.log(board);

				     	 $.ajax({
					        url: "<?php echo base_url()?>Admin_C/showDetailReportBoard",
					        type: "POST",
					        data: {board:board},
					        dataType: "JSON",

					        success:function (data) {
					        	 var boardReport = '<table style="width:100%;text-align:center;border:2px solid #0079BF;">';
					        	 	boardReport += '<thead style="background-color:#0079BF;color:white;">';
								 	boardReport += '<tr>';
								 	boardReport += '<th>reported by</th>';
								 	boardReport += '<th>description</th>';
								 	boardReport += '<th>date report</th>';
								 	boardReport += '</tr>';
								 	boardReport += '</thead>';
								 	boardReport += '<tbody class="detailDataReport">';

								 $.each(data ,function(key,value) {
								 	boardReport += '<tr>';
								 	boardReport += '<td>'+value.username+'</td>';
								 	boardReport += '<td>'+value.description+'</td>';
								 	boardReport += '<td>'+value.date+'</td>';
								 	boardReport += '</tr>';
								 });
								 	boardReport += '</tbody>';
								 	boardReport += '</table>';
				 				
				 				$(".detailReport").html(boardReport);
					        }
					     });
				  	});

	 				$(".deleteBoardReport").click(function() {
		 				var board = $(this).data("board");

		 				Swal.fire({
						  title: 'Are you sure?',
						  text: "You won't be able to revert this!",
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
						  if (result.value) {
						  	$.ajax({
					        url: "<?php echo base_url()?>Admin_C/deleteBoardReport",
					        type: "POST",
					        data : {board:board},

					        success:function(data) {
					        	Swal.fire(
									 'Deleted!',
									 'Your file has been deleted.',
									 'success'
								 )

								 setTimeout(function() {
									location.reload();
								 },3000);
					        	}
							});
							 	
						  }
						});
		 			});
	        }
	     });

	   /*End All Reported Board*/

	   /*Show All Reported Activity*/
		 $.ajax({
	        url: "<?php echo base_url() ?>Admin_C/showAllReportActivity",
	        type: "GET",
	        dataType: "JSON",

	        success:function (data) {
	        	 var numberThird = 1;
				 var activityReport = "";

				 $.each(data ,function(key,value) {
				 	activityReport += '<tr>';
				 	activityReport += '<td>'+numberThird+'</td>';
				 	activityReport += '<td>'+value.reported_board_activity+'</td>';
				 	activityReport += '<td>'+value.total+'</td>';
				 	activityReport += '<td><i class="fas fa-info-circle detailActivityReport" style="margin-right: 5px;cursor:pointer;" data-toggle="modal" data-target="#modalDetailReport" data-name="'+value.reported_board_activity+'"></i><i class="fas fa-trash-alt deleteActivityReport" data-activity="'+value.reported_board_activity+'" style="cursor:pointer;"></i></td>';
				 	activityReport += '</tr>';

				 	numberThird++;
				 });
 				
 				$(".tableActivityReport").html(activityReport);

	 				$(".detailActivityReport").click(function() {
					     	 var activity = $(this).data("name");
					     	

					     	 $.ajax({
						        url: "<?php echo base_url()?>Admin_C/showDetailReportActivity",
						        type: "POST",
						        data: {activity:activity},
						        dataType: "JSON",

						        success:function (data) {
						        	 var boardReport = '<table style="width:100%;text-align:center;border:2px solid #0079BF;">';
						        	 	boardReport += '<thead style="background-color:#0079BF;color:white;">';
									 	boardReport += '<tr>';
									 	boardReport += '<th>reported by</th>';
									 	boardReport += '<th>description</th>';
									 	boardReport += '<th>date report</th>';
									 	boardReport += '</tr>';
									 	boardReport += '</thead>';
									 	boardReport += '<tbody class="detailDataReport">';

									 $.each(data ,function(key,value) {
									 	boardReport += '<tr>';
									 	boardReport += '<td>'+value.username+'</td>';
									 	boardReport += '<td>'+value.description+'</td>';
									 	boardReport += '<td>'+value.date+'</td>';
									 	boardReport += '</tr>';
									 });
									 	boardReport += '</tbody>';
									 	boardReport += '</table>';
					 				
					 				$(".detailReport").html(boardReport);
						        }
						     });
					  });

	 			$(".deleteActivityReport").click(function() {
		 				var activity = $(this).data("activity");

		 				Swal.fire({
						  title: 'Are you sure?',
						  text: "You won't be able to revert this!",
						  icon: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Yes, delete it!'
						}).then((result) => {
						  if (result.value) {
						  	$.ajax({
					        url: "<?php echo base_url()?>Admin_C/deleteActivityReport",
					        type: "POST",
					        data : {activity:activity},

					        success:function(data) {
					        	Swal.fire(
									 'Deleted!',
									 'Your file has been deleted.',
									 'success'
								 )

								 setTimeout(function() {
									location.reload();
								 },3000);
					        	}
							});
							 	
						  }
						});
		 			});
	        }
	     });

	   /*End All Reported Board*/
	});

	

</script>

