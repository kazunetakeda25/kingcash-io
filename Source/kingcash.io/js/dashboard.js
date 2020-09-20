var token = $("#token").val();

// var chartData = [];
// $.ajax({
//     url: 'include/ajax_get_chart_data.php',
//     type: 'GET',
//     dataType: 'json',
//     success: function(data) {
//         $.each(data, function( key, value ) {
//             a = new Date(value['date']);
//             b = value['price'];
//             console.log(a+","+b+":");
//             chartData.push( {
//                 "date": a,
//                 "price": b
//             } );
//         });
//     }
// });

// var chart = AmCharts.makeChart("chartdiv",{
//     "type": "stock",
//     "theme": "light",
//     "categoryAxesSettings": {
//         "minPeriod": "3hh"
//     },
//     "dataSets": [{
//         "color": "#27a9e3",
//         "fieldMappings":[{
//             "fromField": "price",
//             "toField": "price"
//         }],
//         "dataProvider": chartData,
//         "categoryField": "date"
//     }],
//     "panels": [{
//         "showCategoryAxis": true,
//         "title": "Price",
//         "percentHeight": 100,
//         "stockGraphs": [{
//             "id": "g1",
//             "valueField": "price",
//             "type": "line",
//             "lineThickness": 1,
//             "bullet": "round"
//         }],
//         "stockLegend": {
//             "valueTextRegular": " ",
//             "markerType": "none"
//         }
//     }],
//     "chartScrollbarSettings": {
//         "graph": "g1",
//         "usePeriod": "3hh",
//         "position": "top"
//     },
//     "chartCursorSettings": {
//         "valueBalloonsEnabled": true
//     },
//     "panelsSettings": {"usePrefixes": false}
// });

// document.getElementById("ETH_address_copy").onclick = function() {
//     $("#ETH_address").select();
//     document.execCommand('copy');
//     $("#ETH_address_copy").val("Copied");
//     var count = 0;
//     setTimeout(function(){
//         $("#ETH_address_copy").val("Copy");
//     }, 2000);
// }
// var current_time = $("#current_server_time").val();
// var target_time = $("#target_server_time").val();
// setInterval(function(){ 
//     current_time++;
//     var time_remained = target_time - current_time;
//     var day = parseInt(time_remained/(24*3600));
//     var day_temp = time_remained%(24*3600);
//     var hours = parseInt(day_temp/3600);
//     var hours_temp = day_temp%3600;
//     var minutes = parseInt(hours_temp/60);
//     if(day<0||hours<0||hours_temp<0){
//         $("#remain_datetime").html("CROWD SALE IS LIVE");
//     }else{
//         $("#remain_days").html(day);
//         $("#remain_hours").html(hours);
//         $("#remain_minutes").html(minutes);
//         $.ajax({
//             url: 'include/ajax_total_tokens.php',
//             type: 'GET',
//             dataType: 'json',
//             success: function(data) {
//                 $("#total_tokens").html(data);
//                 $('#total_tokens').number( true, 0);
//             }
//         });
//     }
// }, 60000);
// current_time++;
// var time_remained = target_time - current_time;
// var day = parseInt(time_remained/(24*3600));
// var day_temp = time_remained%(24*3600);
// var hours = parseInt(day_temp/3600);
// var hours_temp = day_temp%3600;
// var minutes = parseInt(hours_temp/60);
// if(day<0||hours<0||minutes<0){
//     $("#remain_datetime").html("CROWD SALE IS LIVE")
// }else{
//     $("#remain_days").html(day);
//     $("#remain_hours").html(hours);
//     $("#remain_minutes").html(minutes);
// }
// $.ajax({
//     url: 'include/ajax_total_tokens.php',
//     type: 'GET',
//     dataType: 'json',
//     success: function(data) {
//         $("#total_tokens").html(data);
//         $('#total_tokens').number( true, 0);
//     }
// });
// $.ajax({
//     url: 'include/ajax_get_total_tokens.php',
//     type: 'GET',
//     dataType: 'json',
//     success: function(data) {
//         $("#total_tokens").html(data);
//         $('#total_tokens').number( true, 0);
//     }
// });

$.ajax({
    url: 'include/get_btc_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#btc_balance_text").html(data['btc_balance']);
    }
});
$.ajax({
    url: 'include/get_kcp_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#kcp_balance_text").html(data);
    }
});

var token_total_investment, token_active_investment, token_total_earned, usd_balance, today_interest_rate;

$.ajax({
    url: 'include/ajax_get_lending_total_info',
    type: 'POST',
    data: {
        token : token
    },
    dataType: 'json',
    success: function(data) {
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

