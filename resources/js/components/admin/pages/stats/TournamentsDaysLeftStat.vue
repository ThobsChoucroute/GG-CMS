<template>
    <div class="col-lg-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jour(s) restant(s) avant tournoi(s)</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-info" @click="getPercentage(1)">
                        <i class="fas fa-sync" :class="{ 'fa-spin': loading }"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <apexchart height="280" type="radialBar" :options="options" :series="series"></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            options: {
                chart: {
                    id: 'tournamentsDaysLeft'
                },
                labels: [],
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            value: {
                                formatter: function (value) {
                                    return value + ' days left'
                                }
                            },
                        }
                    }
                },
                legend: {
                    show: true,
                    labels: {
                        useSeriesColors: true
                    }
                }
            },
            series: [0,0],
        }
    },
    
    methods: {
        getPercentage(isRefresh) {
            this.loading = true
            axios.get('/api/tournaments/daysleft')
            .then(response => {
                this.options = {
                    ...this.options.chart,
                    labels: response.data.labels
                }
                this.series = response.data.values

                if (isRefresh) {
                    this.flashMessage.success({
                        title: "Data updated",
                    })
                }

                this.loading = false
            })
            .catch(() => {
                this.loading = false
            })
        }
    },

    mounted() {
        this.getPercentage()
    }
}
</script>
