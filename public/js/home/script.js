$(document).ready(function(){

$("#wallet").change(function(){
		$("#bitaddress,#showmessage,#showerrormessage").hide();
		$('#bitaddress').attr({
			required: false,
		})
	});

$("#Account").change(function(){
		$("#bitaddress").show();
		$('#bitaddress').attr({
			required: true,
		})
		$("#showmessage").show();
		$("#bitaddress").val('');
	});


$('#cryptocoin').change(function(){

	$("#buyCoins").attr('data-coin',$(this).val());
	$("#buy_inr").attr('data-coin',$(this).val());
	$("#totalid").attr('data-coin',$(this).val());
	$("#buyCoins").keyup();
});
$("#inrwallet,#paymentgetwaycharge").click(function () {
	$("#buyCoins").keyup();
	
});
	var buyoption = 0;
	var buyrate;
	$("#buyCoins,#buy_inr,#totalid").keyup(function(){
		console.log('payment geteway');
		var answerid = $(this).attr('id');
		var coinId = $(this).attr('data-coin');
		if($("#"+answerid).val() == '' || isNaN($("#"+answerid).val()) ||(($("#"+answerid).val() < 100 || $("#"+answerid).val().indexOf(".") != -1) && answerid == 'buy_inr' ) ||(($("#"+answerid).val() < 100 || $("#"+answerid).val().indexOf(".") != -1) && answerid == 'totalid' && $("#minvoicetokenid").length == 0 ) || (($("#"+answerid).val() < 1 || $("#"+answerid).val().indexOf(".") != -1) && answerid == 'totalid' && $("#minvoicetokenid").length != 0 )){
			//alert('here');
			if($("#"+answerid).val() == '' || isNaN($("#"+answerid).val()) || ($("#"+answerid).val().indexOf(".") != -1 && answerid != 'buyCoins')){
				$("#buy_inr").val('');//#inrvalueid
			}
			if(answerid == 'totalid') $("#buy_inr").val('');
			$("#buyCoins").val('');//btcvalueid
			$('#feeid').val('0.00');
			$('#taxid').val('0.00');
			//var maths = 0+Number($('#feeid').val())+ Number($('#taxid').val());
			if($("#"+answerid).val() == '' || isNaN($("#"+answerid).val()) || ($("#"+answerid).val().indexOf(".") != -1 && answerid != 'buyCoins')) $("#totalid").val('');
			else if(answerid != 'totalid' )$("#totalid").val('');
			$('#baidonationid').val('0.00');
		}
		else{
			var requeststing ="/requested?coin="+coinId+"&buycurrencyrate=0";
			$.ajax({
				url:requeststing,success:function(result){
					buyoption = $.now();
					if(result.search("timed out") != -1){
						var string = result.split("*");
						$("#buyheader").html(string[0]);
						$("#buybody").html(string[1]);
						$("#buyyes").html('Ok');
						$("#buyyes").show();
						$("#buyno,#buyloadingimgid").hide();
						$('#buy').modal();
					}
					else{
						buyrate = result.split(',');
						var feefromdata = buyrate[2];
						if($("#inrwallet").is(":checked"))feefromdata =buyrate[6];
						else feefromdata = buyrate[2];
						//if($('#buysellrates').val() == 'buypage' && $("#netbanking").is(":checked")) feefromdata = Number(feefromdata)+Number(buyrate[7]);
						if($("#paymentgetwaycharge").is(":checked")) feefromdata = Number(feefromdata)+Number(buyrate[8]);

						if(answerid == 'totalid'){

							/*var feefactor =(feefromdata/100);
							var taxfactor 
							if($('#buysellrates').val() == 'indexpage')	taxfactor =(feefactor*buyrate[3]/100)+1+feefactor;
							else taxfactor = (feefactor*buyrate[3]/100)+1+feefactor+(buyrate[4]/100);
								//alert(taxfactor);
							var inrvalue = Math.round(Number($('#totalid').val())/taxfactor);
							var fee = Math.round(inrvalue*feefromdata/100);
							var tax = Math.round(fee*buyrate[3]/100);*/



							var feefactor =(feefromdata/100);
							var taxfactor;
							taxfactor =(buyrate[3]/100)+1+feefactor;
			
							var inrvalue = Math.round(Number($('#totalid').val())/taxfactor);
							var fee = Math.round(inrvalue*feefromdata/100);
							var tax = Math.round(inrvalue*buyrate[3]/100);



							$("#buy_inr").val(inrvalue);
							$("#taxid").val(tax);
							
							var bai = Math.round(inrvalue*buyrate[4]/100);
								$('#baidonationid').val(bai);

							var btcval = (inrvalue /Math.round(buyrate[1]*buyrate[0]))*100000000;
								btcval = Math.round(btcval);
								btcval = btcval/100000000;
								$("#buyCoins").val(btcval);

							var finalfee=0 ;
							if($('#buysellrates').val() == 'indexpage'){
								finalfee = Math.round (Number($('#totalid').val())-(inrvalue+tax));
							}
							else{
								finalfee = Math.round (Number($('#totalid').val())-(inrvalue+tax+bai));
							}
							$("#feeid").val(finalfee);
							var eachval = (buyrate[0]*buyrate[1]);
							eachval = Math.round(eachval);
							$("#unixtimeid").val(buyrate[5]);
							$("#buy_price").html(eachval);

						}
						else{
							if(answerid == 'buyCoins'){
								var inrval = Math.round(buyrate[0]*buyrate[1])*$("#"+answerid).val();
								inrval = Math.round(inrval);
								$("#buy_inr").val(inrval);
							}
							else{
								var btcval = ($("#"+answerid).val() /Math.round(buyrate[1]*buyrate[0]))*100000000;
								btcval = Math.round(btcval);
								btcval = btcval/100000000;
								$("#buyCoins").val(btcval);
							}
							var eachval = (buyrate[0]*buyrate[1]);
								eachval = Math.round(eachval);
								//eachval = eachval/100000000;
								//$("#buy_price").val(eachval);At Rs: 12,000 per BTC
								$("#buy_price").html(eachval);
								var finalbai = Math.round(((Number($('#buy_inr').val())*buyrate[4])/100));
									//finalbai = finalbai/100;
									$('#baidonationid').val(finalbai);
								var finalfee = Math.round((Number($('#buy_inr').val())*feefromdata)/100);

								//tax calculate on fees
								//var finaltax = Math.round((finalfee*buyrate[3])/100);
								///tax calculate on total price updated by prosenjit
								var finaltax = Math.round((Number($('#buy_inr').val())*buyrate[3])/100);
								$('#feeid').val(finalfee);
								$('#taxid').val(finaltax);
								var maths = Math.round(Number($('#buy_inr').val())+finalfee+finaltax+finalbai);
								$("#totalid").val(maths);
								//var utime = Math.round(new Date().getTime()/1000);
								$("#unixtimeid").val(buyrate[5]);
						}
					}
			}});
		}
		
	});

////////////////////////////////////////////////////sell////////////////////////////////////
$('#cryptocoin_sell').change(function(){

	$("#sellCoins").attr('data-coin',$(this).val());
	$("#sell_inr").attr('data-coin',$(this).val());
	$("#tatalid1").attr('data-coin',$(this).val());
	$("#sellCoins").keyup();
});
var selloption = 0;
	var sellrate;
	$("#sellCoins,#sell_inr,#tatalid1").keyup(function(){
		var answerid = $(this).attr('id');
		var coinId = $(this).attr('data-coin');
		if($("#"+answerid).val() == '' ||isNaN($("#"+answerid).val()) ||(($("#"+answerid).val() < 100 || $("#"+answerid).val().indexOf(".") != -1) && answerid == 'sell_inr' )||(($("#"+answerid).val() < 100 || $("#"+answerid).val().indexOf(".") != -1) && answerid == 'tatalid1' )){
			if($("#"+answerid).val() == '' || isNaN($("#"+answerid).val())|| ($("#"+answerid).val().indexOf(".") != -1 && answerid != 'sellCoins')){
				$("#sell_inr").val('');//#inrvalueid
			}
			if(answerid == 'tatalid1') $("#sell_inr").val('');
			$("#sellCoins").val('');//btcvalueid
			$('#feeid1').val('0.00');
			$('#taxid1').val('0.00');
			//var maths = 0+Number($('#feeid').val())+ Number($('#taxid').val());
			if($("#"+answerid).val() == '' || isNaN($("#"+answerid).val()) || ($("#"+answerid).val().indexOf(".") != -1 && answerid != 'sellCoins')) $("#tatalid1").val('');
			else if(answerid != 'tatalid1' )$("#tatalid1").val('');
			$('#baidonationid1').val('0.00');
		}
		else{
			var requeststing ="/sellcurrencyrate?coin="+coinId+"&sellcurrencyrate=0";
			$.ajax({
				url:requeststing,success:function(result){
					selloption = $.now();
					if(result.search("timed out") != -1){
						var string = result.split("*");
						$("#sellheader").html(string[0]);
						$("#sellbody").html(string[1]);
						$("#sellyes").html('Ok');
						$("#sellyes").show();
						$("#sellno,#sellloadingimgid").hide();
						$('#sell').modal();
					}
					else{
						sellrate = result.split(',');
						if(answerid == 'tatalid1'){

							/*var feefactor =(sellrate[2]/100);
							var taxfactor;
							if($('#buysellrates').val() == 'indexpage')	taxfactor = 1-(feefactor*sellrate[3]/100)-feefactor;
							else taxfactor = 1-(feefactor*sellrate[3]/100)-feefactor-(sellrate[4]/100);

							var inrvalue = Math.round(Number($('#tatalid1').val())/taxfactor);
							var fee = Math.round(inrvalue*sellrate[2]/100);
							var tax = Math.round(fee*sellrate[3]/100);*/

							var feefromdata = sellrate[2];
							var feefactor =(feefromdata/100);
							var taxfactor;
							taxfactor = 1-(sellrate[3]/100)-feefactor;
			
							var inrvalue = Math.round(Number($('#tatalid1').val())/taxfactor);
							var fee = Math.round(inrvalue*feefromdata/100);
							var tax = Math.round(inrvalue*sellrate[3]/100);

							$("#sell_inr").val(inrvalue);
							//$("#feeid1").val(fee);
							$("#taxid1").val(tax);
							
							var bai = Math.round(inrvalue*sellrate[4]/100);
								$('#baidonationid1').val(bai);

							var btcval = (inrvalue /Math.round(sellrate[1]*sellrate[0]))*100000000;
								btcval = Math.round(btcval);
								btcval = btcval/100000000;
								$("#sellCoins").val(btcval);

							var finalfee ;
							if($('#buysellrates').val() == 'indexpage'){
								finalfee = Math.round (fee + ((inrvalue-fee-tax) -Number($('#tatalid1').val())));
							}
							else{
								finalfee = Math.round (fee + ((inrvalue-fee-tax-bai)-Number($('#tatalid1').val())));
							}
							$("#feeid1").val(finalfee);

							var eachval = (sellrate[0]*sellrate[1]);
								eachval = Math.round(eachval);
								$("#sell_price").html(eachval);
								$("#unixtimeid").val(sellrate[5]);

						}
						else{
							if(answerid == 'sellCoins'){
								var inrval = Math.round(sellrate[0]*sellrate[1])*$("#"+answerid).val();
								inrval = Math.round(inrval);
								//inrval = inrval/100000000;
								$("#sell_inr").val(inrval);
							}
							else{
								var btcval = ($("#"+answerid).val() /Math.round(sellrate[1]*sellrate[0]))*100000000;
								btcval = Math.round(btcval);
								btcval = btcval/100000000;
								$("#sellCoins").val(btcval);
							}
							var eachval = sellrate[0]*sellrate[1];
								eachval = Math.round(eachval);
								//eachval = eachval/100000000;
								//$("#buy_price").val(eachval);At Rs: 12,000 per BTC
								$("#sell_price").html(eachval);
								var finalbai = Math.round(((Number($('#sell_inr').val())*sellrate[4])/100));
									//finalbai = finalbai/100;
									$('#baidonationid1').val(finalbai);
								var finalfee = Math.round((Number($('#sell_inr').val())*sellrate[2])/100);

								//tax calculate on fees
								//var finaltax = Math.round((finalfee*sellrate[3])/100);
								///tax calculate on total price updated by prosenjit
								var finaltax = Math.round((Number($('#sell_inr').val())*sellrate[3])/100);
								$('#feeid1').val(finalfee);
								$('#taxid1').val(finaltax);
								var maths = Math.round (Number($('#sell_inr').val())-finalfee-finaltax-finalbai);
								$("#tatalid1").val(maths);
								//var utime = Math.round($.now()/1000);
								$("#unixtimeid").val(sellrate[5]);
						}
					}
			}});
		}
		
	});

$(document).ready(function () {
$.getJSON('http://get2change.com/api/tricker/1', function (data) {

	
	 
		var ohlc=[] , data = data.product; 
			for (var i=0; i < data.length; i++) {
				ohlc.push([
					parseFloat(data[i].interval), // the date
					parseFloat(data[i].last_inr_price), // open
					// close
				]);
			}
        // create the master chart
		console.log(ohlc);
        function createMaster() {
            Highcharts.chart('master-container', {
                chart: {
                    reflow: false,
                    borderWidth: 0,
                    backgroundColor: null,
                    marginLeft: 50,
                    marginRight: 20,
                    zoomType: 'x',
       
                },
         
                title: {
                    text: 'BTC to INR'
                },
                subtitle: {
                    text: ''
                },
             
                xAxis: {
                    type: 'datetime',
                    showLastTickLabel: true,
                    maxZoom: 7 * 24 * 3600000, // fourteen days
					//tickInterval:300,
                    //~ plotBands: [{
                        //~ id: 'mask-before',
                        //~ from: data[0][0],
                        //~ to: data[data.length - 1][0],
                        //~ color: 'rgba(0, 0, 0, 0.2)'
                    //~ }],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    gridLineWidth: 0,
                    labels: {
                        //enabled: false
                    },
                    title: {
                        text: null
                    },
                    min: 0.6,
                    //showFirstLabel: false
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        fillColor: {
                            //linearGradient: [0, 0, 0, 70],
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, 'rgba(255,255,255,0)']
                            ]
                        },
                    
                        shadow: false,
                    
                    }
                },

                series: [{
                    type: 'area',
                    name: 'BTC to INR',
                    pointInterval: 3600*1000,
                    pointStart: ohlc[0][0],
                    data: ohlc
                }],

                exporting: {
                    enabled: false
                }

            }, 
            function (masterChart) {
                //createDetail(masterChart);
            }); // return chart instance
        }

        // make the container smaller and add a second container for the master chart
        var $container = $('#container')
            //.css('position', 'relative');


        $('<div id="master-container">').appendTo($container);

        // create master and in its callback, create the detail chart
        createMaster();
    });
});



});

$(document).ready(function () {

	$.getJSON('http://get2change.com/api/tricker/2', function (data) {

	
	 
		var ohlc=[] , data = data.product; 
			for (var i=0; i < data.length; i++) {
				ohlc.push([
					parseFloat(data[i].interval), // the date
					parseFloat(data[i].last_inr_price), // open
					// close
				]);
			}
        // create the master chart
		console.log(ohlc);
        function createMaster_wtc() {
            Highcharts.chart('master-container', {
                chart: {
                    reflow: false,
                    borderWidth: 0,
                    backgroundColor: null,
                    marginLeft: 50,
                    marginRight: 20,
                    zoomType: 'x',
       
                },
         
                title: {
                    text: 'WTC to INR'
                },
                subtitle: {
                    text: ''
                },
             
                xAxis: {
                    type: 'datetime',
                    showLastTickLabel: true,
                    maxZoom: 7 * 24 * 3600000, // fourteen days
					//tickInterval:300,
                    //~ plotBands: [{
                        //~ id: 'mask-before',
                        //~ from: data[0][0],
                        //~ to: data[data.length - 1][0],
                        //~ color: 'rgba(0, 0, 0, 0.2)'
                    //~ }],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    gridLineWidth: 0,
                    labels: {
                        //enabled: false
                    },
                    title: {
                        text: null
                    },
                    min: 0.6,
                    //showFirstLabel: false
                },
                legend: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        fillColor: {
                            //linearGradient: [0, 0, 0, 70],
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, 'rgba(255,255,255,0)']
                            ]
                        },
                    
                        shadow: false,
                    
                    }
                },

                series: [{
                    type: 'area',
                    name: 'WTC to INR',
                    pointInterval: 3600*1000,
                    pointStart: ohlc[0][0],
                    data: ohlc
                }],

                exporting: {
                    enabled: false
                }

            }, 
            function (masterChart) {
                //createDetail(masterChart);
            }); // return chart instance
        }

        // make the container smaller and add a second container for the master chart
        var $container = $('#container_wtc')
            //.css('position', 'relative');


        $('<div id="master-container">').appendTo($container);

        // create master and in its callback, create the detail chart
        createMaster_wtc();
    });
});
