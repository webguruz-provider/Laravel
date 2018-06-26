<template>
	<div>
		<div id="touch" style="background: blue; padding: 40px; width: 200px">
			Can't touch this.
		</div>
	  </div>
</template>

<script>
	import Hammer from 'hammerjs';

	export default {
		props: ['data'],
		components: {},
		data() {
			return {
				debate: this.data
			}
		},
		computed: {
			swipeL() {
				console.log('Left');
			},
			swipeRight() {
				console.log('Right');
			}
		},
		mounted() {
			var stage = document.getElementById('touch');
			var swipeOptions = {
				dragLockToAxis: true,
				dragBlockHorizontal: true
			};
			var hammertime = new Hammer(stage, swipeOptions);
			hammertime.on('panright', function(ev) {
				console.log(ev.type);
			});
		}
	}
</script>