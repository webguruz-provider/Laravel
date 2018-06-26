<template>
	<div>
		<div class="debate-argument__form" id="closedargu">
			<textarea class="form-control resp-text-box" name="comment" placeholder="What do you think?" required autofocus v-model="body"></textarea>
			<button type="submit" class="text-submit" @click="addArgument"><i aria-hidden="true" class="fa fa-paper-plane-o"></i></button>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['initialArgument', 'initialFirstUser'],
		data() {
			return {
				body: '',
			}
		},
		methods: {
			addArgument() {
				axios.post(location.pathname + '/arguments', {message: this.body})
					.then(response => {
						console.log(response);
						this.body = '';
						this.$emit('argument', response.data);
					})
					.catch(function (error) {
						console.log(error);
					});
			}
		}
	}
</script>