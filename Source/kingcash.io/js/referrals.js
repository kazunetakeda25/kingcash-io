$("#phone").intlTelInput({
    allowDropdown: false,
    autoHideDialCode: false,
    autoPlaceholder: "off",
    dropdownContainer: "body",
    excludeCountries: ["us"],
    formatOnDisplay: false,
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    hiddenInput: "full_number",
    initialCountry: "auto",
    nationalMode: false,
    placeholderNumberType: "MOBILE",
    separateDialCode: true,
    utilsScript: "assets/plugin/phone/build/js/utils.js"
});
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
$(document).ready(function() {  

});
