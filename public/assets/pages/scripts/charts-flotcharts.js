var ChartsFlotcharts = function() {

    return {
        //main function to initiate the module

        init: function() {

            App.addResizeHandler(function() {
                Charts.initPieCharts();
            });

        },

        initCharts: function() {

            if (!jQuery.plot) {
                return;
            }

            function chart1(feesCollected) {
                if ($('#chart_1').size() != 1) {
                    return;
                }

                var plot = $.plot($("#chart_1"), [{
                    data: feesCollected,
                    label: "Fees Collection",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0

                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2,
                            fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }]
                            }
                        },
                        points: {
                            show: true,
                            radius: 3,
                            lineWidth: 1
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    },
                    colors: ["#d12610", "#37b7f3", "#52e136"],
                    xaxis: {
                        mode:"time",
                        timeformat: "%d %b"
                    },
                    yaxis: {
                        ticks: 11,
                        tickDecimals: 0,
                        tickColor: "#eee",
                    }
                });


                function showTooltip(x, y, contents) {
                    $('<div id="tooltip">' + contents + '</div>').css({
                        position: 'absolute',
                        display: 'none',
                        top: y + 5,
                        left: x + 15,
                        border: '1px solid #333',
                        padding: '4px',
                        color: '#fff',
                        'border-radius': '3px',
                        'background-color': '#333',
                        opacity: 0.80
                    }).appendTo("body").fadeIn(200);
                }

                var previousPoint = null;
                $("#chart_1").bind("plothover", function(event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));

                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0];//.toFixed(2),
                                y = item.datapoint[1].toFixed(2);

                            showTooltip(item.pageX, item.pageY, item.series.label + " of " + new Date(x).toDateString() + " is " + y);
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });
            }

            function chart2(usd, csm) {
                if ($('#chart_2').size() != 1) {
                    return;
                }

                var plot = $.plot($("#chart_2"), [{
                    data: usd,
                    label: "USD",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0

                }, {
                    data: csm,
                    label: "CSM",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2,
                            fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }]
                            }
                        },
                        points: {
                            show: true,
                            radius: 3,
                            lineWidth: 1
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    },
                    colors: ["#d12610", "#37b7f3", "#52e136"],
                    xaxis: {
                        mode:"time",
                        timeformat: "%d %b"
                    },
                    yaxis: {
                        ticks: 11,
                        tickDecimals: 0,
                        tickColor: "#eee",
                    }
                });


                function showTooltip(x, y, contents) {
                    $('<div id="tooltip">' + contents + '</div>').css({
                        position: 'absolute',
                        display: 'none',
                        top: y + 5,
                        left: x + 15,
                        border: '1px solid #333',
                        padding: '4px',
                        color: '#fff',
                        'border-radius': '3px',
                        'background-color': '#333',
                        opacity: 0.80
                    }).appendTo("body").fadeIn(200);
                }

                var previousPoint = null;
                $("#chart_2").bind("plothover", function(event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));

                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0],
                                y = item.datapoint[1];

                            showTooltip(item.pageX, item.pageY, item.series.label + " transaction on " + new Date(x).toDateString() + " is " + y);
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });
            }

            // $.ajax({
            //     type:'get',
            //     url:window.location.origin+'/jpcwallet/admin/revenue-chart',
            //     dataType:'json',
            //     success:function(result){
            //         var items = [];
            //         $.each( result, function( key, val ) {
            //             items.push([new Date(val.y, val.m, val.d), val.fees]);
            //         });
            //         chart1(items);
            //     }
            // });

            $.ajax({
                type:'get',
                url:window.location.origin+'/en/admin/transaction-chart',
                dataType:'json',
                success:function(result){
                    var usd = [];
                    $.each( result.usd, function( key, val ) {
                        usd.push([new Date(val.y, val.m, val.d), val.buy]);
                    });
                    var csm = [];
                    $.each( result.csm, function( key, val ) {
                        csm.push([new Date(val.y, val.m, val.d), val.buy]);
                    });
                    chart2(usd, csm);
                }
            });
        }
    };
}();

jQuery(document).ready(function() { 
    ChartsFlotcharts.init();
    ChartsFlotcharts.initCharts();
});
