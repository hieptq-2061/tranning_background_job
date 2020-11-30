new Vue({
    el: '#app',
    data() {
        return {
            data: null,
        }
    },
    async mounted() {
        do {
            await axios.get('/statistic_data')
                .then(response => (this.data = response.data))
                .then(() => setTimeout(() => {}, 1000))
                .catch(error => alert('Something went wrong!'));
        } while(!this.data.monthlyEmail.endedAt);
    }
});
