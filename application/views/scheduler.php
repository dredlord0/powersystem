<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Scheduler</h2>
				<h5>Manage your power plan here.</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-12">
				<!--   Kitchen Sink -->
				<div class="panel panel-default">
					<div class="panel-heading">
                           <b><i class="fa fa-calendar"></i> Scheduler for POWER SOCKET <?php echo $powersocket; ?> (<?php echo $name;?>) is <?php echo $status; ?></b>
                        </div>                        
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>POWER ON</th>
										<th>POWER OFF</th>
										<!--<th>CRONTAB</th>-->
										<th>Power ON time</th>
										<th>Cretion date</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
                                    <?php echo $tr;?>                           
                                </tbody>
							</table>
							<form  style="display:inline;" action="/scheduler/newjob/<?php echo $id; ?>">
							 <button class="btn btn-success"><i class="fa fa-plus-square"></i> Add new</button>
							</form>
							<form  style="display:inline;" action="/scheduler/changeSchedulerStatus/<?php echo $id; ?>/<?php echo $scheduler_enabled; ?>">
							 <button class="btn btn-warning"><i class="fa fa-gear"></i> <?php echo $b_status; ?></button>
							</form>
						</div>
					</div>
				</div>
				<!-- End  Kitchen Sink -->


				<!-- /. ROW  -->
				<hr />
			</div>
			<!-- /. PAGE INNER  -->
		</div>
		<!-- /. PAGE WRAPPER  -->