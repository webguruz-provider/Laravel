<template>
	<div class="dashboard-chart" ref="canvas" style="width:100%"></div>
</template>

<script>
	import Highcharts from 'highcharts';

	export default{

		props: ['dates', 'impressions', 'clicks', 'engagement', 'ads'],

		data: function() {
			return{
				legend: '',
				canvas: '',
			};
		},

		mounted: function () {
			var ctx = this.$refs.canvas;
			new Highcharts.chart(ctx, {
				    title: {
				        text: null
				    },
				    subtitle: {
				        text: null
				    },
					xAxis: {
						className: 'highcharts-color-0',
					    tickWidth: 0,
					    gridLineWidth: 1,
					    labels: {
					        align: 'middle'
					    },
					    categories: ['Sun', 'Mon', 'Tues', 'Weds', 'Thurs', 'Fri', 'Sat', 'Sun']
					},
				    yAxis: {
				        title: {
				            text: null
				        }
				    },
				    legend: {
			            align: 'left',
			            verticalAlign: 'top',
			            y: -5,
			            floating: false,
			            borderWidth: 0
			        },
			        tooltip: {
			        	backgroundColor: 'rgba(0,0,0,0.95)',
			        	borderColor: 'rgba(0,0,0,1)',
			        	style: {
			        		"color": "#ffffff"
			        	},
			        	padding: 15,
			        	formatter: function () {
			                var s = '<b>' + this.x + '</b>';
			                this.points.forEach(function (point) {
			                    s += '<br/>' + point.series.name + ': ' + point.y;
			                });
			                return s;
			            },
			            crosshairs: true,
			            shared: true
			            //split: true
			        },
				    series: [{
				        name: 'Impressions',
				        data: this.impressions,
				        color: "#61DD50",
			            marker:
		            	{
		            		symbol: 'circle',
		            		radius: '3',
		            		symbol: 'circle',
		            		states: {
		                        hover: {
		                            radius: '5',
		                        }
		                    }
		            	}
				    }, {
				        name: 'Clicks',
				        data: this.clicks,
				        color: "#2DCEF7",
			            marker:
		            	{
		            		symbol: 'circle',
		            		radius: '3',
		            		symbol: 'circle',
		            		states: {
		                        hover: {
		                            radius: '5',
		                        }
		                    }
		            	}
				    }, {
				        name: 'Engagement',
				        data: this.engagement,
				        color: "#8E8E93",
			            marker:
		            	{
		            		symbol: 'circle',
		            		radius: '3',
		            		symbol: 'circle',
		            		states: {
		                        hover: {
		                            radius: '5',
		                        }
		                    }
		            	}
				    }, {
				        name: 'Ad Clicks',
				        data: this.ads,
				        color: "#323232",
			            marker:
		            	{
		            		symbol: 'circle',
		            		radius: '3',
		            		symbol: 'circle',
		            		states: {
		                        hover: {
		                            radius: '5',
		                        }
		                    }
		            	}
				    }]

			});
		}
	}
</script>