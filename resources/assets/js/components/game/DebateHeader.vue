<template>
	<div class="debate-preview u-background-white">
	    <div class="debate-preview__header">
			<div class="debate-haeder-top">
				<h4 class="debate-preview__category">
					Submitted In <strong class="u-text-black">{{ debate.question_category }}</strong>
					<span v-if="debate.status!='closed'"><strong id="demo"></strong></span>
					<span class="debate-closed" v-else>Closed</span>
				</h4>

				<h5 class="debate-preview__category restricted-for-vote">
					Submitted By <strong class="u-text-black"><a :href="'/players/' + debate.get_debatequestion.getquestion_auther.handle">{{ debate.get_debatequestion.getquestion_auther.name }}</a></strong>

				</h5>
				
				<span v-if="debate.status !='active'" data-toggle="modal" data-target="#myModal3" class="send-debate">
					<img src="/img/dot.svg">
				</span>
				<span v-else data-toggle="modal" data-target="#inviteToVote" class="send-debate">
					<img src="/img/dot.svg">
				</span>
	        </div>
			<p class="debate-preview__question-text">
	            {{ debate.question_text }}
	        </p>
	        <small class="debate-preview__question-source">
	            {{ debate.question_medium }} from <strong class="u-text-black">{{ debate.question_source }}</strong>
	        </small>
	    </div>
		
		<div v-if="debate.status == 'needs_opponent'" class="new-join-debate-button">
		<a href="#" data-target="#mychallengeModal" data-toggle="model" onclick="openpopup()" style="cursor:pointer" id="hideForFirstUser" class="debate-preview__player-info">Join debate
		</a>
		</div>
	    <div class="debate-preview__players u-flex">
            <div v-for="user in debate.users" :class="'debate-preview__player u-flex-center '+user.pivot.side.toLowerCase()">
                <div class="debate-preview__player-img">
                    <a :href="'../players/'+user.handle">
                        <img class="debate-preview__player-avatar" :src="'/images/'+user.avatar_url" :alt="user.name">
                    </a>
                </div>
                <div class="debate-preview__player-info">
                    <h4 class="debate-preview__player-name">
                    <a class="u-link-black" :href="'/players/' + user.handle" target="_blank">
                            {{ user.handle }}
                        </a>
                    </h4>
                    <small>
                        {{ user.rank }}
                    </small>
                </div><!-- /player-info-->
				
				<ul v-if="user.pivot.votes > 0" :class="'voter-sec full-dark vote-count-'+user.pivot.votes+'-my-debate my-debate'">
					<li v-if="debate.users[0].id == user.id">
						<span v-if="user.pivot.votes > 0">{{ user.pivot.votes }}</span>
						<a v-if="getVoteStatus.debate_users_count == 2 && getVoteStatus.is_debate_user == 0 && getVoteStatus.is_voted == 0" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-not-given-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else-if="debate.users.id == user.id" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'my-debate-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-my-debate-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
					</li>
					<li v-else>
						<a v-if="getVoteStatus.debate_users_count == 2 && getVoteStatus.is_debate_user == 0 && getVoteStatus.is_voted == 0" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-not-given-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else-if="debate.users.id == user.id" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'my-debate-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-my-debate-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<span v-if="user.pivot.votes > 0">{{ user.pivot.votes }}</span>
					</li>
				</ul><!-- vote info -->
				<ul v-else :class="'voter-sec full-dark vote-count-'+user.pivot.votes+'-my-debate-disabled my-debate-disabled'">
					
					<li v-if="debate.users[0].id == user.id">
						<span v-if="user.pivot.votes > 0">{{ user.pivot.votes }}</span>
						<span v-if="getVoteStatus.vote_count >= 1 && getVoteStatus.is_debate_user >=1">{{ user.pivot.votes }}</span>
						<a v-if="getVoteStatus.debate_users_count == 2 && getVoteStatus.is_debate_user == 0 && getVoteStatus.is_voted == 0" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-not-given-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else-if="debate.users.id == user.id" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'my-debate-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						
						<a v-else-if="getVoteStatus.vote_count >= 1 && getVoteStatus.is_debate_user" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-my-debate-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-mine-'+user.pivot.side.toLowerCase()+'-1'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
					</li>
					<li v-else>
						<a v-if="getVoteStatus.debate_users_count == 2 && getVoteStatus.is_debate_user == 0 && getVoteStatus.is_voted == 0" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-not-given-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else-if="debate.users.id == user.id" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'my-debate-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else-if="getVoteStatus.vote_count >= 1 && getVoteStatus.is_debate_user >= 1" href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-my-debate-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						<a v-else href="javascript:void(0)" :data-debate-id="debate.id" :data-user-id="user.id" :data-debate-status="debate.status" :id="voteForDebate" :title="'Click to Vote for '+user.name" :style="debate.status =='active' ? 'cursor:pointer' : 'cursor:default'" :class="'not-mine-'+user.pivot.side.toLowerCase()+'-2'">
							<img src="/img/left-vote-btn.svg" alt="Jitendra">
						</a>
						
						<span v-if="user.pivot.votes > 0">{{ user.pivot.votes }}</span>
						<span v-if="getVoteStatus.vote_count >= 1 && getVoteStatus.is_debate_user >=1">{{ user.pivot.votes }}</span>
					</li>
				</ul><!-- vote info -->
            </div>

			<div v-if="debate.status == 'needs_opponent'" class="debate-preview__player u-flex-center">
				<div class="debate-preview__player-img disagree">
					<a href="#" data-target="#mychallengeModal" data-toggle="model" onclick="openpopup()">
						<img src="/images/user_icon.png" class="debate-preview__player-avatar">
					</a>
				</div>
				<div href="#" data-target="#mychallengeModal" data-toggle="model" onclick="openpopup()" style="cursor:pointer" class="debate-preview__player-info">
					<h4 class="debate-preview__player-name">
						<span class="u-link-black non-active">Waiting for</span>
					</h4>
					<span class="u-link-black non-active">Opponent</span>
				</div>
				<ul class="voter-sec">
					<li>
						<a class="disable-vote-icon">
							<img src="/img/right-vote-btn.svg" class="debate-preview__player-avatar">
						</a>
					</li>
				</ul>
			</div>
			
	    </div><!-- debate-preview__players-->
	</div><!-- /debate-preview-->
</template>


<script>
	export default {
		props: ['data'],
		data() {
			return {
				debate: this.data,
				debate_status: ""
			}
		},
		computed: {
			voteForDebate() {
				if(this.debate.status == 'active'){
					return this.debate_status = "vote_for_debate";
				}else{
					return this.debate_status = "";
				}
			},
			getVoteStatus(){
				console.log('debate',this.debate);
				if(this.debate.users[0].id == window.Laravel.user.id){
					var vote_side = 1;
				}else{
					var vote_side = 2;
				}
				if(this.debate.votes.length == 0){
					var vCount = 0;
				}else{
					var vCount = 1;
				}
				return {
					vote_side: vote_side,
					user: window.Laravel.user,
					debate_users_count: window.Laravel.debate_users_count,
					is_debate_user: window.Laravel.is_debate_user,
					is_voted: window.Laravel.is_voted,
					vote_count: vCount
				}
				//console.log('vote_side', vote_side);
				
				//console.log('user', window.Laravel.user);
				//if(this.debate.users.length == 2){
				//	console.log('2');
				//}else{
				//	console.log('1');
				//}
			}
		}
	}
	
</script>
