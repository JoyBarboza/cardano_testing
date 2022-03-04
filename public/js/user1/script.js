(function($) {

  $.fn.menumaker = function(options) {
      
      var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
        cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
        $(this).find("#menu-button").on('click', function(){
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) { 
            mainmenu.hide().removeClass('open');
          }
          else {
            mainmenu.show().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').show();
            }
          }
        });

        cssmenu.find('li ul').parent().addClass('has-sub');

        multiTg = function() {
          cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
          cssmenu.find('.submenu-button').on('click', function() {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').hide();
            }
            else {
              $(this).siblings('ul').addClass('open').show();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else cssmenu.addClass('dropdown');

        if (settings.sticky === true) cssmenu.css('position', 'fixed');

        resizeFix = function() {
          if ($( window ).width() > 768) {
            cssmenu.find('ul').show();
          }

          if ($(window).width() <= 768) {
            cssmenu.find('ul').hide().removeClass('open');
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
  };
})(jQuery);

(function($){
$(document).ready(function(){

$(document).ready(function() {
  $("#cssmenu").menumaker({
    title: "Menu",
    format: "multitoggle"
  });

  $("#cssmenu").prepend("<div id='menu-line'></div>");

var foundActive = false, activeElement, linePosition = 0, menuLine = $("#cssmenu #menu-line"), lineWidth, defaultPosition, defaultWidth;

$("#cssmenu > ul > li").each(function() {
  if ($(this).hasClass('active')) {
    activeElement = $(this);
    foundActive = true;
  }
});

if (foundActive === false) {
  activeElement = $("#cssmenu > ul > li").first();
}

defaultWidth = lineWidth = activeElement.width();

defaultPosition = linePosition = activeElement.position().left;

menuLine.css("width", lineWidth);
menuLine.css("left", linePosition);

$("#cssmenu > ul > li").hover(function() {
  activeElement = $(this);
  lineWidth = activeElement.width();
  linePosition = activeElement.position().left;
  menuLine.css("width", lineWidth);
  menuLine.css("left", linePosition);
}, 
function() {
  menuLine.css("left", defaultPosition);
  menuLine.css("width", defaultWidth);
});

});


});



var buyoption = 0;
	var buyrate;
	$("#buyCoins,#buy_inr,#totalid").keyup(function(){
		var answerid = $(this).attr('id');
		var payeecurrency = $('#buyCoins').attr('data-coin');
		var receivecurrency = $('#totalid').attr('data-coin');
		if(
		$("#"+answerid).val() == '' 
		|| isNaN($("#"+answerid).val()) 
		|| (payeecurrency==3 && $("#"+answerid).val().indexOf(".") != -1  && answerid == 'buyCoins')
		|| (receivecurrency==3 && $("#"+answerid).val().indexOf(".") != -1  && answerid == 'totalid')
		|| ($("#"+answerid).val() < 1 && payeecurrency==3 && answerid == 'buyCoins')
		|| ($("#"+answerid).val() < 1 && receivecurrency==3 && answerid == 'totalid')
	  ){
			
			$("#buy_inr").val('');
			$("#totalid").val('');
			$("#buyCoins").val('');//btcvalueid
			$('#feeid').val('0.00');
			$('#taxid').val('0.00');
			
		}else{
		//else if((buyoption+60000) < $.now()){
			var requeststing ="/jpcwallet/requested?payeecurrency="+payeecurrency+"&receivecurrency="+receivecurrency;
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
						if(answerid == 'totalid'){
							
							///////////////////////////////Coin exchnage ////////////////////////////
							if(buyrate[9] !='true'){

								var inputvalue = $('#totalid').val();
								var feefactor =(feefromdata/100);
								var finalfee = parseFloat(Number(inputvalue)*feefactor).toFixed(8);
								var totalreceivecurrency = parseFloat((Number(inputvalue)+Number(finalfee))).toFixed(8);
								$("#buy_inr").val(totalreceivecurrency);
								$("#taxid").val(0);
								$("#feeid").val(finalfee);
								$totalPaycurrency = parseFloat((totalreceivecurrency * buyrate[1] )/buyrate[0]).toFixed(8);
								$("#buyCoins").val($totalPaycurrency);

							}else{

								var inputvalue = $('#totalid').val();
								var feefactor =(feefromdata/100);
								var taxfactor =(buyrate[3]/100);
								var finalfee = parseFloat(Number(inputvalue)*feefactor).toFixed(8);
								var finaltax = parseFloat(Number(inputvalue)*taxfactor).toFixed(8);
								
								var totalreceivecurrency = parseFloat((Number(inputvalue)+Number(finalfee)+Number(finaltax))).toFixed(8);
								$("#buy_inr").val(totalreceivecurrency);
								$("#taxid").val(finaltax);
								$("#feeid").val(finalfee);
								$totalPaycurrency = parseFloat((totalreceivecurrency * buyrate[1] )/buyrate[0]).toFixed(8);
								$("#buyCoins").val($totalPaycurrency);

							}

							///////////////////////////////Coin exchnage ////////////////////////////
						//}

						}
						else{
							if(answerid == 'buyCoins'){
									///////////////////////////////Coin exchnage ////////////////////////////
									if(buyrate[9] != 'true'){
										var feefactor =(feefromdata/100);
										var totalpaycurrency = (buyrate[0]*$("#"+answerid).val());
										var totalreceivecurrency = (totalpaycurrency/buyrate[1]);
										var finalfee = Number(totalreceivecurrency)*feefactor;
										var finalreceivecurrency = (totalreceivecurrency-finalfee);
										$("#buy_inr").val(parseFloat(totalreceivecurrency).toFixed(8));
										$("#taxid").val(0);
										$("#feeid").val(parseFloat(finalfee).toFixed(8));
										$("#totalid").val(parseFloat(finalreceivecurrency).toFixed(8));
									}else{
										var feefactor =(feefromdata/100);
										var taxfactor =(buyrate[3]/100);
										var totalpaycurrency = (buyrate[0]*$("#"+answerid).val());
										var totalreceivecurrency = (totalpaycurrency/buyrate[1]);
										var finalfee = Number(totalreceivecurrency)*feefactor;
										var finaltax = Number(totalreceivecurrency)*taxfactor;
										var finalreceivecurrency = (totalreceivecurrency-(finalfee+finaltax));
										$("#buy_inr").val(parseFloat(totalreceivecurrency).toFixed(8));
										$("#taxid").val(finaltax);
										$("#feeid").val(parseFloat(finalfee).toFixed(8));
										$("#totalid").val(parseFloat(finalreceivecurrency).toFixed(8));
									}
			
									///////////////////////////////Coin exchnage ////////////////////////////
			
								
							}
							
						}
					}
			}});
		}
		
		
	});


	$('#payvalue').keyup(function(){

		var value = $(this).val();
		var datataken = $('#total_deduct_value').attr('data-taken');
                value = (parseFloat(value)*parseFloat(datataken));
		$('#total_deduct_value').html('Fees Will be taken- '+ value);
	});



})(jQuery);

window.onload = function(){
  crear_select();
}

var Navegador_ = (window.navigator.userAgent||window.navigator.vendor||window.opera),
		Firfx = /Firefox/i.test(Navegador_),
		Mobile_ = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(Navegador_),
	FirfoxMobile = (Firfx && Mobile_);

var li = new Array();
var optSelect = new Array();
function crear_select(){
	var div_cont_select = document.querySelectorAll("[data-mate-select='active']");
	var select_ = '';
	for (var e = 0; e < div_cont_select.length; e++) {
	div_cont_select[e].setAttribute('data-indx-select',e);
	div_cont_select[e].setAttribute('data-selec-open','false');
	var ul_cont = document.querySelectorAll("[data-indx-select='"+e+"'] > .cont_list_select_mate > ul");
	select_ = document.querySelectorAll("[data-indx-select='"+e+"'] >select")[0];
	if (Mobile_ || FirfoxMobile) { 
			select_.addEventListener('change', function () {
			_select_option(select_.selectedIndex,e);
			});
	}
	
		var select_optiones = select_.options;
		document.querySelectorAll("[data-indx-select='"+e+"']  > .selecionado_opcion ")[0].setAttribute('data-n-select',e);
		document.querySelectorAll("[data-indx-select='"+e+"']  > .icon_select_mate ")[0].setAttribute('data-n-select',e);
		console.log(select_optiones);
		
    
		for (var i = 0; i < select_optiones.length; i++) {
						li[i] = document.createElement('li');
							if (select_optiones[i].selected == true) {
							optSelect[e] = i;
							li[i].className = 'active';
							document.querySelector("[data-indx-select='"+e+"']  > .selecionado_opcion ").innerHTML = select_optiones[i].innerHTML;
							var str = select_optiones[i].innerHTML;
							str = str.split('-');
								if(e){
									document.getElementById("symbolRecevie").innerHTML=str[0];
									document.getElementById("ReceivecurrencyId").value = select_optiones[i].value;
								}else{
									 document.getElementById("symbolPayee").innerHTML=str[0];
									 document.getElementById("PaycurrencyId").value = select_optiones[i].value;
								}

								   if(!e)
								   document.getElementById("buyCoins").setAttribute('data-coin',select_optiones[i].value);
		   
								   if(e){	
									 
								   document.getElementById("buy_inr").setAttribute('data-coin',select_optiones[i].value);
								   document.getElementById("totalid").setAttribute('data-coin',select_optiones[i].value);
								   }
								
							};
						
						li[i].setAttribute('data-index',i);
						li[i].setAttribute('data-selec-index',e);
					// funcion click al selecionar 
						li[i].addEventListener( 'click', function(){  _select_option(this.getAttribute('data-index'),this.getAttribute('data-selec-index')); });

						li[i].innerHTML = select_optiones[i].innerHTML;
						ul_cont[0].appendChild(li[i]);
						
				}; // Fin For select_optiones
	}; // fin for divs_cont_select
	//selectedOptionDisable(optSelect);
} // Fin Function 


function selectedOptionDisable(optSelect){
  var li_s = document.querySelectorAll("[data-indx-select='0'] .cont_select_int > li");
	var select_optiones = document.querySelectorAll("[data-indx-select='0'] > select")[0];
	select_optiones = select_optiones.options;
	select_optiones.remove(optSelect[0]);
	for (var i = 0; i < li_s.length; i++) {
		if(i==optSelect[1])
		li_s[i].parentNode.removeChild(li_s[i]);

	};
	

};
			




var cont_slc = 0;
function open_select(idx){
var idx1 =  idx.getAttribute('data-n-select');
  var ul_cont_li = document.querySelectorAll("[data-indx-select='"+idx1+"'] .cont_select_int > li");
var hg = 0;
var slect_open = document.querySelectorAll("[data-indx-select='"+idx1+"']")[0].getAttribute('data-selec-open');
var slect_element_open = document.querySelectorAll("[data-indx-select='"+idx1+"'] select")[0];
 if (Mobile_ || FirfoxMobile) { 
  if (window.document.createEvent) { // All
			var evt = window.document.createEvent("MouseEvents");
			evt.initMouseEvent("mousedown", false, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
			slect_element_open.dispatchEvent(evt);
		} else if (slect_element_open.fireEvent) { // IE
			slect_element_open.fireEvent("onmousedown");
		}
}else {

  
  for (var i = 0; i < ul_cont_li.length; i++) {
	hg += ul_cont_li[i].offsetHeight;
	}; 
	if (slect_open == 'false') {  
	document.querySelectorAll("[data-indx-select='"+idx1+"']")[0].setAttribute('data-selec-open','true');
	document.querySelectorAll("[data-indx-select='"+idx1+"'] > .cont_list_select_mate > ul")[0].style.height = hg+"px";
	document.querySelectorAll("[data-indx-select='"+idx1+"'] > .icon_select_mate")[0].style.transform = 'rotate(180deg)';
	}else{
	document.querySelectorAll("[data-indx-select='"+idx1+"']")[0].setAttribute('data-selec-open','false');
	document.querySelectorAll("[data-indx-select='"+idx1+"'] > .icon_select_mate")[0].style.transform = 'rotate(0deg)';
	document.querySelectorAll("[data-indx-select='"+idx1+"'] > .cont_list_select_mate > ul")[0].style.height = "0px";
	}
}

} // fin function open_select

function salir_select(indx){
var select_ = document.querySelectorAll("[data-indx-select='"+indx+"'] > select")[0];
 document.querySelectorAll("[data-indx-select='"+indx+"'] > .cont_list_select_mate > ul")[0].style.height = "0px";
document.querySelector("[data-indx-select='"+indx+"'] > .icon_select_mate").style.transform = 'rotate(0deg)';
 document.querySelectorAll("[data-indx-select='"+indx+"']")[0].setAttribute('data-selec-open','false');
}


function _select_option(indx,selc){
		if (Mobile_ || FirfoxMobile) { 
		selc = selc -1;
		}
  var select_ = document.querySelectorAll("[data-indx-select='"+selc+"'] > select")[0];

  var li_s = document.querySelectorAll("[data-indx-select='"+selc+"'] .cont_select_int > li");
  var p_act = document.querySelectorAll("[data-indx-select='"+selc+"'] > .selecionado_opcion")[0].innerHTML = li_s[indx].innerHTML;
	var select_optiones = document.querySelectorAll("[data-indx-select='"+selc+"'] > select > option");
			for (var i = 0; i < li_s.length; i++) {
					if (li_s[i].className == 'active') {
					li_s[i].className = '';
				};
				li_s[indx].className = 'active';

		};
	var str = li_s[indx].innerHTML;
	str = str.split('-');
	console.log(selc);
	if(selc==1){
	 document.getElementById("symbolRecevie").innerHTML=str[0];
     document.getElementById("buy_inr").setAttribute('data-coin',select_optiones[indx].value);
	 document.getElementById("totalid").setAttribute('data-coin',select_optiones[indx].value);
	 document.getElementById("ReceivecurrencyId").value = select_optiones[indx].value;
	}else{
	 document.getElementById("symbolPayee").innerHTML=str[0];
	 document.getElementById("buyCoins").setAttribute('data-coin',select_optiones[indx].value);
	 document.getElementById("PaycurrencyId").value = select_optiones[indx].value;
	}

	select_optiones[indx].selected = true;
	select_.selectedIndex = indx;
	select_.onchange();
	salir_select(selc); 
	
	resetInputValue();
}

function resetInputValue(){
	
		$("#buy_inr").val('');
		$("#totalid").val('');
		$("#buyCoins").val('');//btcvalueid
		$('#feeid').val('0.00');
		$('#taxid').val('0.00');
	}
