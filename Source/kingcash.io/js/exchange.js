var is_clicked = 0;

$("#copy-text").click(function() {
    $("#referrer_url").select();
    document.execCommand('copy');
    $("#copy-text").val("Copied");
    setTimeout(function(){
        $("#copy-text").val("Copy");
    }, 2000);
});

var token = $("#token").val();
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
$.ajax({
    url: 'include/get_kcp_balance.php',
    type: 'POST',
    dataType: 'json',
    data: {
        token: token
    },
    success: function(data) {
        $("#kcp_balance_text").html(data);
        $("#select_all_kcp").html('(All : ' + data + ' KCP)');
        $("#kcp_balance").val(data);
        $("#form_kcp_balance").val(data);
        $("#createorder_kcp_balance").val(data);
    }
});

var chartData = [];
$.ajax({
    url: 'include/ajax_get_chart_data.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        //var chart_data = JSON.parse(data);
        $.each(data, function( key, value ) {
            a = new Date(value['date']);
            b = value['price'];
            chartData.push( {
                "date": a,
                "price": b
            } );
        });
    }
});

console.log(chartData);

var chart = AmCharts.makeChart("chartdiv",{
    "type": "stock",
    "theme": "light",
    "categoryAxesSettings": {
        "minPeriod": "hh"
    },
    "dataSets": [{
        "color": "#27a9e3",
        "fieldMappings":[{
            "fromField": "price",
            "toField": "price"
        }],
        "dataProvider": chartData,
        "categoryField": "date"
    }],
    "panels": [{
        "showCategoryAxis": true,
        "title": "Price",
        "percentHeight": 100,
        "stockGraphs": [{
            "id": "g1",
            "valueField": "price",
            "type": "line",
            "lineThickness": 1,
            "bullet": "round"
        }],
        "stockLegend": {
            "valueTextRegular": " ",
            "markerType": "none"
        }
    }],
    "chartScrollbarSettings": {
        "graph": "g1",
        "usePeriod": "hh",
        "position": "top"
    },
    "chartCursorSettings": {
        "valueBalloonsEnabled": true
    },
    "panelsSettings": {"usePrefixes": false}
});

// var chart = AmCharts.makeChart("chartdiv", {
//     "type": "serial",
//     "theme": "light",
//     "marginRight": 80,
//     "autoMarginOffset": 20,
//     "marginTop": 7,
//     "dataProvider": chartData,
//     "valueAxes": [{
//         "title": "BTC",
//         "axisAlpha": 0.2,
//         "dashLength": 1,
//         "position": "left"
//     }],
//     "mouseWheelZoomEnabled": true,
//     "graphs": [{
//         "id": "g1",
//         "balloonText": "[[value]]",
//         "bullet": "round",
//         "bulletBorderAlpha": 1,
//         "bulletColor": "#FFFFFF",
//         "hideBulletsCount": 50,
//         "title": "BTC",
//         "valueField": "price",
//         "useLineColorForBulletBorder": true,
//         "balloon":{
//             "drop":true
//         }
//     }],
//     "chartScrollbar": {
//         "autoGridCount": true,
//         "graph": "g1",
//         "scrollbarHeight": 40
//     },
//     "chartScrollbarSettings": {
//         "graph": "g1",
//         "usePeriod": "hh",
//         "position": "top"
//     },
//     "chartCursor": {
//        "limitToGraph":"g1"
//     },
//     "categoryField": "date",
//     "categoryAxis": {
//         "parseDates": true,
//         "axisColor": "#DADADA",
//         "dashLength": 1,
//         "minorGridEnabled": true
//     },
//     "categoryAxesSettings": {
//         "minPeriod": "hh",
//         "dateFormats": "YYYY-MM-DD JJ:NN"
//     }
// });

// chart.addListener("rendered", zoomChart);
// zoomChart();

// // this method is called when chart is first inited as we listen for "rendered" event
// function zoomChart() {
//     // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
//     chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
// }

$('#createbuyorder_btcvolume').number( true, 8);
$('#createbuyorder_btcpriceperkcp').number( true, 8);
$('#createbuyorder_kcpvolume').number( true, 8);
var exchange_buy_fee = $('#exchange_buy_fee').val();

$("#createbuyorder_btcvolume").keyup(function(){
	var createbuyorder_btcvolume = $("#createbuyorder_btcvolume").val();
	var createbuyorder_btcpriceperkcp = $("#createbuyorder_btcpriceperkcp").val();
	var createbuyorder_kcpvolume = createbuyorder_btcvolume/((1+exchange_buy_fee/100)*createbuyorder_btcpriceperkcp);
	$("#createbuyorder_kcpvolume").val(createbuyorder_kcpvolume);
	$("#create_buyorder_confirm_message").html('Buy '+createbuyorder_kcpvolume + ' KCP for ' + createbuyorder_btcvolume + ' BTC');
});

$("#createbuyorder_btcpriceperkcp").keyup(function(){
    var createbuyorder_kcpvolume = $("#createbuyorder_kcpvolume").val();
	var createbuyorder_btcpriceperkcp = $("#createbuyorder_btcpriceperkcp").val();
	var createbuyorder_btcvolume = createbuyorder_kcpvolume*(1+exchange_buy_fee/100)*createbuyorder_btcpriceperkcp;
	$("#createbuyorder_btcvolume").val(createbuyorder_btcvolume);
	$("#create_buyorder_confirm_message").html('Buy '+createbuyorder_kcpvolume + ' KCP for ' + createbuyorder_btcvolume + ' BTC');
});

$("#createbuyorder_kcpvolume").keyup(function(){
	var createbuyorder_kcpvolume = $("#createbuyorder_kcpvolume").val();
	var createbuyorder_btcpriceperkcp = $("#createbuyorder_btcpriceperkcp").val();
	var createbuyorder_btcvolume = createbuyorder_kcpvolume*(1+exchange_buy_fee/100)*createbuyorder_btcpriceperkcp;
	$("#createbuyorder_btcvolume").val(createbuyorder_btcvolume);
	$("#create_buyorder_confirm_message").html('Buy '+createbuyorder_kcpvolume + ' KCP for ' + createbuyorder_btcvolume + ' BTC');
});

$("#createbuyorder_confirmed").click(function(){
    if(is_clicked!=0){
        var token = $("#token").val();
        var createbuyorder_btcvolume = $("#createbuyorder_btcvolume").val();
        var createbuyorder_btcpriceperkcp = $("#createbuyorder_btcpriceperkcp").val();
        var createbuyorder_kcpvolume = $("#createbuyorder_kcpvolume").val();
        var createbuyorder_google2facode = $("#createbuyorder_google2facode").val();
        var btc_balance = $("#createorder_btc_balance").val();
        $.ajax({
            url: 'include/ajax_createbuyorder.php',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                createbuyorder_btcvolume: createbuyorder_btcvolume,
                createbuyorder_btcpriceperkcp: createbuyorder_btcpriceperkcp,
                createbuyorder_kcpvolume: createbuyorder_kcpvolume,
                createbuyorder_google2facode: createbuyorder_google2facode,
                btc_balance: btc_balance
            },
            success: function(data) {
                if(data['res']=="false"){
                    alert(data['msg']);
                }
                window.location.reload();
            }
        });
        is_clicked = 1;
    }
});
$('#createsellorder_btcvolume').number( true, 8);
$('#createsellorder_btcpriceperkcp').number( true, 8);
$('#createsellorder_kcpvolume').number( true, 8);
var exchange_sell_fee = $('#exchange_sell_fee').val();

$("#createsellorder_kcpvolume").keyup(function(){
    var createsellorder_kcpvolume = $("#createsellorder_kcpvolume").val();
    var createsellorder_btcpriceperkcp = $("#createsellorder_btcpriceperkcp").val();
    var createsellorder_btcvolume = createsellorder_kcpvolume*(1-exchange_sell_fee/100)*createsellorder_btcpriceperkcp;
    $("#createsellorder_btcvolume").val(createsellorder_btcvolume);
    $("#create_sellorder_confirm_message").html('sell '+createsellorder_kcpvolume + ' KCP for ' + createsellorder_btcvolume + ' BTC');
});

$("#createsellorder_btcpriceperkcp").keyup(function(){
    var createsellorder_kcpvolume = $("#createsellorder_kcpvolume").val();
    var createsellorder_btcpriceperkcp = $("#createsellorder_btcpriceperkcp").val();
    var createsellorder_btcvolume = createsellorder_kcpvolume*(1-exchange_sell_fee/100)*createsellorder_btcpriceperkcp;
    $("#createsellorder_btcvolume").val(createsellorder_btcvolume);
    $("#create_sellorder_confirm_message").html('sell '+createsellorder_kcpvolume + ' KCP for ' + createsellorder_btcvolume + ' BTC');
});

$("#createsellorder_btcvolume").keyup(function(){
    var createsellorder_btcvolume = $("#createsellorder_btcvolume").val();
    var createsellorder_btcpriceperkcp = $("#createsellorder_btcpriceperkcp").val();
    var createsellorder_kcpvolume = createsellorder_btcvolume/((1-exchange_sell_fee/100)*createsellorder_btcpriceperkcp);
    $("#createsellorder_kcpvolume").val(createsellorder_kcpvolume);
    $("#create_sellorder_confirm_message").html('sell '+createsellorder_kcpvolume + ' KCP for ' + createsellorder_btcvolume + ' BTC');
});

$("#createsellorder_confirmed").click(function(){
    if(is_clicked!=0){
        var token = $("#token").val();
        var createsellorder_kcpvolume = $("#createsellorder_kcpvolume").val();
        var createsellorder_btcpriceperkcp = $("#createsellorder_btcpriceperkcp").val();
        var createsellorder_btcvolume = $("#createsellorder_btcvolume").val();
        var createsellorder_google2facode = $("#createsellorder_google2facode").val();
        var kcp_balance = $("#createorder_kcp_balance").val();
        $.ajax({
            url: 'include/ajax_createsellorder.php',
            type: 'POST',
            dataType: 'json',
            data: {
                token: token,
                createsellorder_kcpvolume: createsellorder_kcpvolume,
                createsellorder_btcpriceperkcp: createsellorder_btcpriceperkcp,
                createsellorder_btcvolume: createsellorder_btcvolume,
                createsellorder_google2facode: createsellorder_google2facode,
                kcp_balance: kcp_balance
            },
            success: function(data) {
                if(data['res']=="false"){
                    alert(data['msg']);
                }
                window.location.reload();
            }
        });
        is_clicked = 1;
    }
});

var ajax_url_buying_orders =  'include/ajax_get_orders.php?ordertype=buy';
var datatable_buying_orders = $('#datatable_buying_orders').DataTable( {
    "ajax": ajax_url_buying_orders,
    "pageLength": 30,
    "columnDefs": [ {
        "targets": 0,
        "data": null,
        "defaultContent": '<i class="fa fa-arrow-right"></i>'
    } ]
});

datatable_buying_orders
    .order( [ 2, 'desc' ] )
    .draw();

var ajax_url_selling_orders =  'include/ajax_get_orders.php?ordertype=sell';
var datatable_selling_orders = $('#datatable_selling_orders').DataTable( {
    "ajax": ajax_url_selling_orders,
    "pageLength": 30,
    "columnDefs": [ {
        "targets": 0,
        "data": null,
        "defaultContent": '<i class="fa fa-arrow-right"></i>'
    } ]
});

datatable_selling_orders
    .order( [ 2, 'asc' ] )
    .draw();


var token = $("#token").val();
var my_open_order_id, my_open_order_btcvolume;

var ajax_url_my_open_buying_orders =  'include/ajax_get_my_open_orders.php?ordertype=buy&token=' + token;
var datatable_my_open_buying_orders = $('#datatable_my_open_buying_orders').DataTable( {
    "ajax": ajax_url_my_open_buying_orders,
    "pageLength": 30,
    "columnDefs": [ {
        "targets": 5,
        "data": null,
        "defaultContent": '<button type="button" class="btn btn-primary" id="my_order_cancel">Cancel Order</button>'
    } ]
});

datatable_my_open_buying_orders
    .order( [ 1, 'desc' ] )
    .draw();

$('#datatable_my_open_buying_orders tbody').on('click', 'tr', function () {
    var my_order_data = datatable_my_open_buying_orders.row( this ).data();
    if(my_order_data[0]!=""){
        $("#my_order_type").html('BUY');
        $("#my_order_kcpvolume").html(my_order_data[3]);
        $("#my_order_btckcprate").html(my_order_data[2]);
        $("#my_order_btcvolume").html(my_order_data[4]);
        my_open_order_id = my_order_data[6];
        my_open_order_btcvolume = my_order_data[4];
        $('#cancel_my_order_modal').modal('show');
    }
});

var ajax_url_my_open_selling_orders =  'include/ajax_get_my_open_orders.php?ordertype=sell&token=' + token;
var datatable_my_open_selling_orders = $('#datatable_my_open_selling_orders').DataTable( {
    "ajax": ajax_url_my_open_selling_orders,
    "pageLength": 30,
    "columnDefs": [ {
        "targets": 5,
        "data": null,
        "defaultContent": '<button type="button" class="btn btn-primary" id="my_order_cancel">Cancel Order</button>'
    } ]
});

datatable_my_open_selling_orders
    .order( [ 1, 'desc' ] )
    .draw();

$('#datatable_my_open_selling_orders tbody').on('click', 'tr', function () {
    var my_order_data = datatable_my_open_selling_orders.row( this ).data();
    if(my_order_data[0]!=""){
        $("#my_order_type").html('SELL');
        $("#my_order_kcpvolume").html(my_order_data[3]);
        $("#my_order_btckcprate").html(my_order_data[2]);
        $("#my_order_btcvolume").html(my_order_data[4]);
        my_open_order_id = my_order_data[6];
        my_open_order_btcvolume = my_order_data[4];
        $('#cancel_my_order_modal').modal('show');
    }
});

$("#my_order_cancel").click(function(){
    if(is_clicked!=0){
        $.ajax({
            url: 'include/ajax_cancel_my_open_order.php',
            type: 'POST',
            dataType: 'json',
            data: {
                my_open_order_id : my_open_order_id,
                token: token
            },
            success: function(data) {
                if(data['res']=="true"){
                    alert("Success");
                    window.location.reload();
                }else{
                    alert(data['msg']);
                    window.location.reload();
                }
            }
        });
        is_clicked = 1;
    }
});

$('#datatable_buying_orders tbody').on('click', 'tr', function () {
    var buy_order_data = datatable_buying_orders.row( this ).data();
    var kcpvolume = buy_order_data[4];
    var btcpriceperkcp = buy_order_data[2];
    var total_kcpvolume = buy_order_data[5];
    console.log(total_kcpvolume);
    var btcvolume = total_kcpvolume*btcpriceperkcp*(1-exchange_sell_fee/100);
    $("#createsellorder_kcpvolume").val(total_kcpvolume);
    $("#createsellorder_btcpriceperkcp").val(btcpriceperkcp);
    $("#createsellorder_btcvolume").val(btcvolume);
    $("#create_sellorder_confirm_message").html('sell '+kcpvolume + ' KCP for ' + btcvolume + ' BTC');
    $("#buy_order_tab").attr('class', '');
    $("#sell_order_tab").attr('class', 'active');
    $("#buyorder").attr('class', 'tab-pane fade');
    $("#sellorder").attr('class', 'tab-pane fade in active');
    $('html, body').animate({
        scrollTop: $("#create_order_part").offset().top
    }, 500);
});

$('#datatable_selling_orders tbody').on('click', 'tr', function () {
    var sell_order_data = datatable_selling_orders.row( this ).data();
    var kcpvolume = sell_order_data[4];    
    var btcpriceperkcp = sell_order_data[2];
    var total_kcpvolume = sell_order_data[5];
    console.log(total_kcpvolume);
    var btcvolume = total_kcpvolume*btcpriceperkcp*(1+exchange_sell_fee/100);
    $("#createbuyorder_btcvolume").val(btcvolume);
    $("#createbuyorder_btcpriceperkcp").val(btcpriceperkcp);
    $("#createbuyorder_kcpvolume").val(total_kcpvolume);
    $("#create_buyorder_confirm_message").html('sell '+kcpvolume + ' KCP for ' + btcvolume + ' BTC');
    $("#buy_order_tab").attr('class', 'active');
    $("#sell_order_tab").attr('class', '');
    $("#buyorder").attr('class', 'tab-pane fade in active');
    $("#sellorder").attr('class', 'tab-pane fade');
    $('html, body').animate({
        scrollTop: $("#create_order_part").offset().top
    }, 500);
});

var ajax_url_market_history =  'include/ajax_get_market_history.php';
var datatable_market_history = $('#datatable_market_history').DataTable( {
    "ajax": ajax_url_market_history,
    "pageLength": 10
});

datatable_market_history
    .order( [ 1, 'desc' ] )
    .draw();

setInterval(function(){
    datatable_buying_orders.ajax.reload(null, false);
    datatable_selling_orders.ajax.reload(null, false);
    datatable_my_open_buying_orders.ajax.reload(null, false);
    datatable_my_open_selling_orders.ajax.reload(null, false);
    datatable_market_history.ajax.reload(null, false);
    $.ajax({
        url: 'include/ajax_get_summary.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $("#span_last_price").html(data['last'] + " BTC");
            $("#span_last_price_usd").html(data['last_usd'] + " USD");
            $("#span_24h_volume").html(data['volume'] + " KCP ");
            $("#span_24h_volume_usd").html(data['volume_usd'] + " USD ");
            $("#span_24h_high_price").html(data['price_high'] + " BTC ");
            $("#span_24h_high_price_usd").html(data['price_high_usd'] + " USD ");
            $("#span_24h_low_price").html(data['price_low'] + " BTC ");
            $("#span_24h_low_price_usd").html(data['price_low_usd'] + " USD");
            // $("#span_last_price").number( true, 8);
            // $("#span_last_price_usd").number( true, 8);
            // $("#span_24h_volume").number( true, 8);
            // $("#span_24h_volume_usd").number( true, 8);
            // $("#span_24h_high_price").number( true, 8);
            // $("#span_24h_high_price_usd").number( true, 8);
            // $("#span_24h_low_price").number( true, 8);
            // $("#span_24h_low_price_usd").number( true, 8);
        }
    });
}, 3000);