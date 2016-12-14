<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>Login Page</h2>
				<h5>Welcome in PowerSystem</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-3">
				<!-- Form Elements -->
				<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-user "></i> Log in to your account</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
							<?php echo validation_errors(); ?>
								<?php echo form_open('verifylogin'); ?>
									<div class="form-group">
										<label>Username</label> <input class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>"/>
										<p class="help-block">Enter your username.</p>
									</div>
									<div class="form-group">
										<label>Password</label> <input class="form-control" id="passowrd" name="password" type="password"/>
										<p class="help-block">Enter your password.</p>
									</div>


									<button type="submit" class="btn btn-default">OK</button>
									<button type="reset" class="btn btn-primary">RESET</button>

								</form>

							</div>

						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
		</div>
		<!-- /. ROW  -->
	</div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->