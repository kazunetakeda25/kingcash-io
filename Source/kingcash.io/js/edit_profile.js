$("#phone").intlTelInput({
    allowDropdown: true,
    autoHideDialCode: false,
    autoPlaceholder: "off",
    dropdownContainer: "body",
    formatOnDisplay: false,
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    hiddenInput: "full_number",
    initialCountry: "us",
    nationalMode: false,
    placeholderNumberType: "MOBILE",
    separateDialCode: true,
    utilsScript: "assets/plugin/phone/build/js/utils.js"
}); 
$("#edit_profile_form").submit(function(e) {
    var intlNumber = $("#phone").intlTelInput("getNumber");
    var countryData = $("#phone").intlTelInput("getSelectedCountryData");
    var country = countryData['name'];
    $('[name=intlNumber]').val(intlNumber);
    $('[name=country]').val(country);
}); 