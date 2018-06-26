<template>
   	<main class="game-wrapper">
		<div class="game-main debate-single">
			
			<debate-header :data="debate"></debate-header>
			<div class="debate-arguments">
				<div class="debate-argument__stream" id="argument-stream">
					<div v-for="argument in debate.arguments">
						<debate-argument :initialArgument="argument" :initialFirstUser="firstUser.id"></debate-argument>
					</div>
				</div>
				<div v-if="checkAds.hasAds == 1" class="debate-ads">
					<div id="argument-ads" class="debate-ads__stream">
						<a href="#" target="_blank">
							<img data-original="#" class="debate-preview__player-avatar lazy" :src="'/img-dist/ads/'+checkAds.ad_img">
						</a>
					</div>
				</div>
				<aside class="game-sidebar game-sidebar__right">
					<div class="game-header view-comment" v-text="commentCount" onClick="showAllComment()"></div>
				</aside>

				<div  v-if="canArgue" class="debate-arguments__form blockcomment">
				    <debate-comments :data="debate.comments"></debate-comments>
					<new-debate-argument @argument="addArgument"></new-debate-argument>
				</div>
				<div v-else>
					<debate-comments :data="debate.comments" @created="add"></debate-comments>
				</div>
			</div>
			
	   	</div>
	</main>
</template>

<script>
	import DebateHeader from './DebateHeader.vue';
	import DebateArgument from './DebateArgument.vue';
	import NewDebateArgument from './NewDebateArgument.vue';
	import DebateComments from './DebateComments.vue';
	import Vote from './Vote.vue';
	export default {
		props: ['debate'],
		components: { DebateHeader, DebateArgument, DebateComments, NewDebateArgument, Vote},
		data() {
			return {
				item: this.debate,
				firstUser: this.debate.users[0],
			};
		},
		computed: {
			commentCount() {


			if(_.size(this.item.comments)==0)
			{
				return "There are no Side comments.";
			}
			if(_.size(this.item.comments)<=5)
			{
				return "Showing all " + _.size(this.item.comments) + " comments.";
			}
			if(_.size(this.item.comments)>=6)
			{
				return "View all " + _.size(this.item.comments) + " comments.";
			}
				//return "Comments (" + _.size(this.item.comments) + ")";
				
			},
            canArgue() {
                if (!window.Laravel.user) { return false; }
                return this.debate.users.some(function (el) {
				    if (el.id == window.Laravel.user.id) {
				    return true;
				    }
				   	
				});

            },
			checkAds(){
				if(this.debate.question.ads_id == 0){
					if(this.debate.question.category.ads_id == 0 || this.debate.question.category.ads_id == null){
						return {
							hasAds: 0,
							ad_img: 'No Image'
						}
					}else{
						if(this.debate.question.category.ads == null){
							return {
								hasAds: 0,
								ad_img: 'No Image'
							}
						}else{
							return {
								hasAds: 1,
								ad_img: this.debate.question.category.ads.image_url
							}
						}
					}
				}else{
					if(this.debate.question.ads == null){
						return {
							hasAds: 0,
							ad_img: 'No Image'
						}
					}else{
						return {
							hasAds: 1,
							ad_img: this.debate.question.ads.image_url
						}
					}
				}
			}
		},
		methods: {
			add(reply) {
				document.getElementById('comment-stream').scrollTop = 0;
				this.item.comments.push(reply);
			},
			addArgument(argument) {
				this.item.arguments.push(argument);
				var stream = document.getElementById("argument-stream");
				stream.scrollTop = stream.scrollHeight;
			}
		}
	}
</script>