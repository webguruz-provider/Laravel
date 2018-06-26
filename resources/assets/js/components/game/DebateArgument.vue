<template>
	<div :class="authorIsFirst">
		<div class="debate-argument__author">
			<strong>
				{{ argument.user.handle }}
			</strong>
			<small>
				posted {{ argument.created_at | dateAgo }}
			</small>
		</div>
		<div class="debate-argument__content">
    		{{ argument.argument }}
		</div>
	</div>
</template>
<script>
	export default {
		props: ['initialArgument', 'initialFirstUser'],
		components: {},
		data() {
			return {
				argument: this.initialArgument,
				firstUser: this.initialFirstUser
			}
		},
		computed: {
			authorIsFirst() {
				return ['debate-argument', this.firstUser == this.argument.user_id ? 'debate-argument__first' : 'debate-argument__second'];
			}
		}
	}
</script>