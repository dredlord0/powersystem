<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>New job</h2>
				<h5>Set the time on and off the connected devices.</h5>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<?php echo form_open('scheduler/simlpeadd'); ?>
		<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
		<input type="hidden" name="powersocket" id="powersocket" value="<?php echo $powersocket; ?>">
		<input type="hidden" name="name" id="name" value="<?php echo $name; ?>">
		<div class="row">
			<div class="col-md-3">
				<!-- Form Elements -->
				<div class="panel panel-default">
					<div class="panel-heading"> <i class="fa fa-plus-circle  "></i> <b>POWER SOCKET <?php echo $powersocket; ?> (<?php echo $name;?>)</b></div>
					<div class="panel-body">
						<div class="col-md-12">
								<div class="form-group">
									<?php echo validation_errors(); ?>
								</div>
							</div>
						<div class="row">
							<div class="col-md-12">
								<h3>PowerON</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Hours</label> <select class="form-control" name="hstart" id="hstart">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Minutes</label> <select class="form-control" name="mstart" id="mstart">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
										<option>24</option>
										<option>25</option>
										<option>26</option>
										<option>27</option>
										<option>28</option>
										<option>29</option>
										<option>30</option>
										<option>31</option>
										<option>32</option>
										<option>33</option>
										<option>34</option>
										<option>35</option>
										<option>36</option>
										<option>37</option>
										<option>38</option>
										<option>39</option>
										<option>40</option>
										<option>41</option>
										<option>42</option>
										<option>43</option>
										<option>44</option>
										<option>45</option>
										<option>46</option>
										<option>47</option>
										<option>48</option>
										<option>49</option>
										<option>50</option>
										<option>51</option>
										<option>52</option>
										<option>53</option>
										<option>54</option>
										<option>55</option>
										<option>56</option>
										<option>57</option>
										<option>58</option>
										<option>59</option>										
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h3>PowerOFF</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Hours</label> <select class="form-control" name="hstop" id="hstop">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Minutes</label> <select class="form-control" name="mstop" id="mstop">
										<option>00</option>
										<option>01</option>
										<option>02</option>
										<option>03</option>
										<option>04</option>
										<option>05</option>
										<option>06</option>
										<option>07</option>
										<option>08</option>
										<option>09</option>
										<option>10</option>
										<option>11</option>
										<option>12</option>
										<option>13</option>
										<option>14</option>
										<option>15</option>
										<option>16</option>
										<option>17</option>
										<option>18</option>
										<option>19</option>
										<option>20</option>
										<option>21</option>
										<option>22</option>
										<option>23</option>
										<option>24</option>
										<option>25</option>
										<option>26</option>
										<option>27</option>
										<option>28</option>
										<option>29</option>
										<option>30</option>
										<option>31</option>
										<option>32</option>
										<option>33</option>
										<option>34</option>
										<option>35</option>
										<option>36</option>
										<option>37</option>
										<option>38</option>
										<option>39</option>
										<option>40</option>
										<option>41</option>
										<option>42</option>
										<option>43</option>
										<option>44</option>
										<option>45</option>
										<option>46</option>
										<option>47</option>
										<option>48</option>
										<option>49</option>
										<option>50</option>
										<option>51</option>
										<option>52</option>
										<option>53</option>
										<option>54</option>
										<option>55</option>
										<option>56</option>
										<option>57</option>
										<option>58</option>
										<option>59</option>		
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-success"><i class="fa fa-plus-square"></i> Save</button>
							</div>
						</div>
					</div>
				</div>
				<!-- End Form Elements -->
			</div>
			</form>
		</div>
		<!-- /. ROW  -->
		<hr />
	</div>
	<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->