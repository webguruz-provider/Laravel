<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">    
      
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>          
        </div>
        <div class="modal-body">
          <h4 class="modal-title">Debate a Friend</h4>
          <p>Send this debate to a friend who might have something to say.</p>
        </div>
        <div class="modal-footer">
          <button type="button" data-toggle="modal" data-target="#myModal12">Send to a Friend</button>
          <p>or Cancel</p>
        </div>
      </div>

    </div>
</div>



  <!--select-apponnent-modal-->
  <div id="myModal12" role="dialog" class="modal fade in">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="http://127.0.0.1:8000/debates/challengeForDebate" id="challengeForDebate">
          
          <div class="modal-header">
            <button type="button" data-dismiss="modal" class="btn-default"><i aria-hidden="true" class="fa fa-times"></i></button>
          </div>
          
          <div class="modal-body">
            <h4 class="modal-title">Select Opponent</h4>
            <p>Select oppontents from your network or challenge out to your friends via email.</p>
		        <p>Invite as many as you like. First one in gets to debate.</p>			
          </div>
          

          <div class="tab-section">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#fav">Favorites</a></li>
              <li><a data-toggle="tab" href="#network">My Sided Network</a></li>
              <li><a data-toggle="tab" href="#invite-others">Invite Others</a></li>
            </ul>

            <div class="tab-content">
              <!-- .fav -->
              <div id="fav" class="tab-pane fade in active">

                <div class="dashboard-item">
                  <div class="debate-preview u-background-white">
                    <div class="follow-player-sec">


                      <div class="debate-preview__players follow-players">
                        <div class="debate-select-img"><img width="128" height="128" alt="" src="http://127.0.0.1:8000/images/1508755261.jpg">
					                
                          <a class="fav-add">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24.125px" height="21.125px" viewBox="0 0 24.125 21.125" enable-background="new 0 0 24.125 21.125" xml:space="preserve">
                              <g>
                                <g id="favorite">
                              		<path stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" d="M12.063,18.578l-1.422-1.262
                              			C5.36,13.172,1.907,10.379,1.907,6.955C1.907,4.162,4.345,2,7.493,2c1.727,0,3.453,0.722,4.57,1.894
                              			C13.181,2.722,14.907,2,16.634,2c3.146,0,5.584,2.162,5.584,4.955c0,3.424-3.453,6.218-8.732,10.361L12.063,18.578z"/>
                              	</g>
                              </g>
                            </svg>
						              </a>
                        </div>
                        <div class="debate-select-name">
                          <h4 class="debate-preview__player-name"><a href="#" class="u-link-black"> mhaley</a></h4>
                          <small> Mr. Clifton Erdman Sr. </small>
                        </div>
                        <div class="debate-tick">
                            <input type="checkbox" id="1" name="invite[]" value="1">
                            <label for="1"><span></span></label>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
              <!-- /.fav -->


              <!-- #network -->
              <div id="network" class="tab-pane fade">
			          <div class="sided-net-content">
                  <h4 class="modal-title">Invite by Email</h4>
                  <p>Add the email addresses of up to three friends you want to debate. We’ll invite them into the ring.</p>
                  <div class="email-address-form">
                    <form>
                      <input type="email" value="Your friends email address…">
                			<input type="email" value="Your friends email address…">
                			<input type="email" value="Your friends email address…">
                		</form>
                	</div>
                </div>
			        </div>
              <!-- /close #network -->
              






              <div id="invite-others" class="tab-pane fade">
			        </div>
            </div>
            <!-- /.tab content -->
          </div>
          <!-- /.tab section -->

          <!-- .modal-footer -->
          <div class="modal-footer">
            <input type="hidden" name="debate_id" value="20">
            <input type="submit" value="Send Challenge " class="green-btn">
      		  <button type="button" data-dismiss="modal" class="cancel-btn">or Cancel</button>
          </div>
          <!-- /.modal-footer -->
        </form>
      </div>
    </div>
  </div>