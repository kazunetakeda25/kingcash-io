var is_clicked = 0;

document.getElementById("copy-text").onclick = function() {
    $("#referrer_url").select();
    document.execCommand('copy');
    $("#copy-text").val("Copied");
    var count = 0;
    setTimeout(function(){
        count++;
        console.log(count);
        $("#copy-text").val("Copy");
    }, 2000);
}

var token = $("#token").val();

var token_total_investment, token_active_investment, token_total_earned, usd_balance, today_interest_rate;

$.ajax({
    url: 'include/ajax_get_lending_total_info',
    type: 'POST',
    data: {
        token : token
    },
    dataType: 'json',
    success: function(data) {
        console.log(data);
        $("#token_total_investment").html(data['token_total_investment']);
        $("#token_active_investment").html(data['token_active_investment']);
        $("#token_total_earned").html(data['token_total_earned']);
        $("#usd_balance_text").html(data['usd_balance']);
        usd_balance = data['usd_balance'];
        $("#usd_balance").html(data['usd_balance']);
        $("#reinvest_usd_total_amount").val('<< ALL ($ '+data['usd_balance']+')');
        $("#earning_board_date_0").html(data['earning_board_date_0']);
        $("#earning_board_date_1").html(data['earning_board_date_1']);
        $("#earning_board_date_2").html(data['earning_board_date_2']);
        $("#earning_board_date_3").html(data['earning_board_date_3']);
        $("#earning_board_date_4").html(data['earning_board_date_4']);
        $("#earning_board_date_5").html(data['earning_board_date_5']);
        $("#earning_board_rate_0").html(data['earning_board_rate_0']);
        today_interest_rate = data['earning_board_rate_1'];
        $("#calc_rate_of_interest").val(today_interest_rate);
        $("#earning_board_rate_1").html(today_interest_rate);
        $("#earning_board_rate_2").html(data['earning_board_rate_2']);
        $("#earning_board_rate_3").html(data['earning_board_rate_3']);
        $("#earning_board_rate_4").html(data['earning_board_rate_4']);
        $("#earning_board_rate_5").html(data['earning_board_rate_5']);
        $("#earning_board_rate_earned_0").html(data['earning_board_rate_earned_0']);
        $("#earning_board_rate_earned_1").html(data['earning_board_rate_earned_1']);
        $("#earning_board_rate_earned_2").html(data['earning_board_rate_earned_2']);
        $("#earning_board_rate_earned_3").html(data['earning_board_rate_earned_3']);
        $("#earning_board_rate_earned_4").html(data['earning_board_rate_earned_4']);
        $("#earning_board_rate_earned_5").html(data['earning_board_rate_earned_5']);
    }
});

$.ajax({
    url: 'include/get_btc_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#btc_balance_text").html(data['btc_balance']);
        $("#select_all_btc").html('(All : ' + data['btc_balance'] + ' BTC)');
        $("#btc_balance").val(data['btc_balance']);
        $("#form_btc_balance").val(data['btc_balance']);
        $("#createorder_btc_balance").val(data['btc_balance']);
        $("#btcusd_balance").html('BTC | USD  ' + data['btcusd_balance']);
    }
});

var kcp_balance, kcpusd_rate, invest_total_usd, invest_usd_amount, invest_kcp_amount, reinvest_usd_amount, reinvest_kcp_amount;
$.ajax({
    url: 'include/get_kcp_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        kcp_balance = data;
        $("#kcp_balance_text").html(kcp_balance);
        $("#kcp_balance").val(kcp_balance);
        $("#invest_kcp_total_amount").val('KCP '+kcp_balance);
        $.ajax({
            url: 'include/ajax_get_summary.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                kcpusd_rate = data['lending_kcpusd_rate'];
                $("#invest_kcpusd_rate").html(kcpusd_rate);
                $("#reinvest_kcpusd_rate").html(kcpusd_rate);
                invest_total_usd = kcp_balance * kcpusd_rate;
                var invest_total_usd_string = invest_total_usd.toFixed(2);
                $("#invest_usd_total_amount").val('<< ALL ($ '+invest_total_usd_string+')');
            }
        });
    }
});


setInterval(function(){
    $.ajax({
        url: 'include/ajax_get_summary.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            kcpusd_rate = data['lending_kcpusd_rate'];
            $("#invest_kcpusd_rate").html(kcpusd_rate);
            invest_total_usd = kcpusd_rate*kcp_balance;
            var invest_total_usd_string = Math.round(invest_total_usd).toFixed(2);
            $("#invest_usd_total_amount").val('<< ALL ($ '+invest_total_usd_string+')');
        }
    });
}, 60000);

$('#invest_kcp_amount').number( true, 8);
$('#reinvest_kcp_amount').number( true, 8);
$('#invest_usd_total_amount').number( true, 2);
$('#invest_usd_amount').number( true, 2);
$('#reinvest_usd_amount').number( true, 2);

$("#invest_usd_amount").change(function(){
    invest_usd_amount = $("#invest_usd_amount").val();
    invest_kcp_amount = invest_usd_amount/kcpusd_rate;
    $("#invest_kcp_amount").val(invest_kcp_amount);
});
$("#invest_usd_amount").keyup(function(){
    invest_usd_amount = $("#invest_usd_amount").val();
    invest_kcp_amount = invest_usd_amount/kcpusd_rate;
    $("#invest_kcp_amount").val(invest_kcp_amount);
});

$("#invest_kcp_amount").change(function(){
    invest_kcp_amount = $("#invest_kcp_amount").val();
    invest_usd_amount = invest_kcp_amount*kcpusd_rate;
    $("#invest_usd_amount").val(invest_usd_amount);
});
$("#invest_kcp_amount").keyup(function(){
    invest_kcp_amount = $("#invest_kcp_amount").val();
    invest_usd_amount = invest_kcp_amount*kcpusd_rate;
    $("#invest_usd_amount").val(invest_usd_amount);
});

$("#invest_usd_total_amount").click(function(){
    $("#invest_usd_amount").val(invest_total_usd);
    $("#invest_kcp_amount").val(kcp_balance);
});

$("#reinvest_usd_total_amount").click(function(){
    $("#reinvest_usd_amount").val(usd_balance);
    reinvest_usd_amount = usd_balance;
    reinvest_kcp_amount = reinvest_usd_amount/kcpusd_rate;
    $("#reinvest_kcp_amount").val(reinvest_kcp_amount);
});

$("#reinvest_usd_amount").change(function(){
    reinvest_usd_amount = $("#reinvest_usd_amount").val();
    reinvest_kcp_amount = reinvest_usd_amount/kcpusd_rate;
    $("#reinvest_kcp_amount").val(reinvest_kcp_amount);
});
$("#reinvest_usd_amount").keyup(function(){
    reinvest_usd_amount = $("#reinvest_usd_amount").val();
    reinvest_kcp_amount = reinvest_usd_amount/kcpusd_rate;
    $("#reinvest_kcp_amount").val(reinvest_kcp_amount);
});

$("#cancel_invest_settings").click(function(){
    $('#invest_kcp_amount').val("");
    $('#invest_usd_amount').val("");
});

$("#cancel_reinvest_settings").click(function(){
    $('#reinvest_kcp_amount').val("");
    $('#reinvest_usd_amount').val("");
});

$("#pay_for_invest").click(function(){
    if(is_clicked!=0){
        invest_usd_amount = $("#invest_usd_amount").val();
        invest_kcp_amount = $("#invest_kcp_amount").val();
        if(invest_usd_amount<100){
            alert("Minimum: 100 USD");
            return false;
        }
        kcp_balance = parseFloat(kcp_balance);
        if(invest_kcp_amount>kcp_balance){
            alert("Amount of KCP is larger than balance");
            return false;
        }

        $.ajax({
            url: 'include/ajax_invest_usd.php',
            type: 'POST',
            data: {
                token : token,
                invest_usd_amount : invest_usd_amount,
                invest_kcp_amount : invest_kcp_amount
            },
            dataType: 'json',
            success: function(data) {
                if(data['res']=="true"){
                    alert("Success");
                    window.location.reload();
                }else{
                    alert(data['msg']);
                    return false;
                }
            }
        });
        is_clicked = 1;
    }
});

$("#pay_for_reinvest").click(function(){
    if(is_clicked!=0){
        reinvest_usd_amount = $("#reinvest_usd_amount").val();
        reinvest_kcp_amount = $("#reinvest_kcp_amount").val();
        usd_balance = parseFloat(usd_balance);
        if(reinvest_usd_amount>usd_balance){
            alert("Amount of USD is larger than balance");
            return false;
        }

        $.ajax({
            url: 'include/ajax_reinvest_usd.php',
            type: 'POST',
            data: {
                token : token,
                reinvest_usd_amount : reinvest_usd_amount,
                reinvest_kcp_amount : reinvest_kcp_amount
            },
            dataType: 'json',
            success: function(data) {
                if(data['res']=="true"){
                    alert("Success");
                    window.location.reload();
                }else{
                    alert(data['msg']);
                    return false;
                }
            }
        });
        is_clicked = 1;
    }
});
$('#calc_btc_usd_kcp_btc').number( true, 8);
$('#calc_btc_usd_kcp_usd').number( true, 2);
$('#calc_btc_usd_kcp_kcp').number( true, 8);
var calc_btc_usd_kcp_btc, calc_btc_usd_kcp_usd, calc_btc_usd_kcp_kcp, btcusd_rate, btckcp_rate;
btcusd_rate = $("#btcusd_rate").val();

$("#calc_btc_usd_kcp_btc").keyup(function(){
    calc_btc_usd_kcp_btc = $("#calc_btc_usd_kcp_btc").val();
    calc_btc_usd_kcp_usd = calc_btc_usd_kcp_btc * btcusd_rate;
    calc_btc_usd_kcp_kcp = calc_btc_usd_kcp_btc * btcusd_rate / kcpusd_rate;
    $("#calc_btc_usd_kcp_usd").val(calc_btc_usd_kcp_usd);
    $("#calc_btc_usd_kcp_kcp").val(calc_btc_usd_kcp_kcp);
});

$("#calc_btc_usd_kcp_usd").keyup(function(){
    calc_btc_usd_kcp_usd = $("#calc_btc_usd_kcp_usd").val();
    calc_btc_usd_kcp_btc = calc_btc_usd_kcp_usd / btcusd_rate;
    calc_btc_usd_kcp_kcp = calc_btc_usd_kcp_usd / kcpusd_rate;
    $("#calc_btc_usd_kcp_btc").val(calc_btc_usd_kcp_btc);
    $("#calc_btc_usd_kcp_kcp").val(calc_btc_usd_kcp_kcp);
});

$("#calc_btc_usd_kcp_kcp").keyup(function(){
    calc_btc_usd_kcp_kcp = $("#calc_btc_usd_kcp_kcp").val();
    calc_btc_usd_kcp_btc = calc_btc_usd_kcp_kcp / btcusd_rate * kcpusd_rate;
    calc_btc_usd_kcp_usd = calc_btc_usd_kcp_kcp * kcpusd_rate;
    $("#calc_btc_usd_kcp_btc").val(calc_btc_usd_kcp_btc);
    $("#calc_btc_usd_kcp_usd").val(calc_btc_usd_kcp_usd);
});

var calc_term_length, calc_total_usd, calc_profit, calc_profit_percent, calc_profit_with_principal;
$("#last_30_days").click(function(){
    $("#last_30_days").css('background-color', "#005580");
    $("#last_6_months").css('background-color', "grey");
    $("#last_7_days").css('background-color', "grey");
    $("#calc_term_length").val("30");
});
$("#last_6_months").click(function(){
    $("#last_30_days").css('background-color', "grey");
    $("#last_6_months").css('background-color', "#005580");
    $("#last_7_days").css('background-color', "grey");
    $("#calc_term_length").val("180");
});
$("#last_7_days").click(function(){
    $("#last_30_days").css('background-color', "grey");
    $("#last_6_months").css('background-color', "grey");
    $("#last_7_days").css('background-color', "#005580");
    $("#calc_term_length").val("7");
});

$("#calc_calculate").click(function(){
    calc_total_usd = $("#calc_total_usd").val();
    calc_term_length = $("#calc_term_length").val();
    calc_profit = calc_total_usd * today_interest_rate * calc_term_length/100;
    calc_profit_percent = today_interest_rate * calc_term_length;
    calc_profit_with_principal = parseFloat(calc_total_usd) + parseFloat(calc_profit);
    $("#calc_profit").html(calc_profit);
    $("#calc_profit_percent").html(calc_profit_percent);
    $("#calc_profit_with_principal").html(calc_profit_with_principal);
    $("#calc_profit").number( true, 2);
    $("#calc_profit_percent").number( true, 2);
    $("#calc_profit_with_principal").number( true, 2);
});
console.log(token);
var ajax_url_investment =  'include/ajax_get_investment?token=' + token;
var datatable_investment = $('#datatable_investment').DataTable( {
    "ajax": ajax_url_investment,
    "pageLength": 30
});

datatable_investment
    .order( [ 1, 'desc' ] )
    .draw();
