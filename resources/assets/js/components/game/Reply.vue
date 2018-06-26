<template>
	<div>
		<div v-for="reply in items">
			{{ reply.comment }}
		</div>
	<input type="text" class="form-control resp-text-box" name="comment" placeholder="Enter response here" required autofocus v-model="body">
		<button type="submit"
			class="hide"
			@click="addComment"
			@created="add">Post</button>
	</div>
</template>

<script>
	export default {
		props: ['replies'],
		data() {
			return {
				body: "",
				items: this.replies,
				endpoint: location.pathname + '/comments'
			}
		},
		methods: {
			addComment() {
				var self = this;
				axios.post(self.endpoint, {
						message: self.body
					})
					.then(function (response) {
						self.body =  ''
						self.$emit('created', response);
					})
					.catch(function (error) {
						console.log(error);
					});
			},
			add(response) {
				this.items.push(response);
			},

		}
	}
</script>