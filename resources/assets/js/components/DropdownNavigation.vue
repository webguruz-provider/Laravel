<script>
    export default{
        data() {
            return {
                isVisible: false,
            }
        },
        methods: {
            toggleVisibility(){
                if (this.isVisible) {
                    this.isVisible = false;
                    return;
                }
                this.isVisible = true;
            }
        }
    }
</script>