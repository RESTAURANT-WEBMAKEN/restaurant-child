//Multiple Popup
$(".open_popup").click(function () {
    $(this).parent(".popup_main").children(".popup_body").addClass("popup_body_show");
});
$(".popup_close").click(function () {
    $(".popup_body").removeClass("popup_body_show");
});
$(".popup_back").click(function () {
    $(".popup_body").removeClass("popup_body_show");
});


//Copy
function copyToClipboardFF(text) {
    window.prompt("Copy to clipboard: Ctrl C, Enter", text);
}
var copied_message = document.getElementsByClassName("copied_message_css");
function copyToClipboard(inputId) {
var input = $(inputId);
    var success = true,
            range = document.createRange(),
            selection;
    // For IE.
    if (window.clipboardData) {
        window.clipboardData.setData("Text", input.val());
    } else {
        // Create a temporary element off screen.
        var tmpElem = $('<div>');
        tmpElem.css({
            position: "absolute",
            left: "-1000px",
            top: "-1000px",
        });
        // Add the input value to the temp element.
        tmpElem.text(input.val());
        $("body").append(tmpElem);
        // Select temp element.
        range.selectNodeContents(tmpElem.get(0));
        selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
        // Lets copy.
        try {
            success = document.execCommand("copy", false, null);
        }
        catch (e) {
            copyToClipboardFF(input.val());
        }
        if (success) {
            $('#linkcopied').show();
            setTimeout(function() { $('#linkcopied').hide(); }, 2000);
            // remove temp element.
            tmpElem.remove();
        }
    }
}

//Clipboard Copy
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

//menu
jQuery('#main-nav').stellarNav();
jQuery('#main-nav').stellarNav({
  theme     : 'plain', 
  breakpoint: 768, 
  menuLabel: 'MENU', 
  phoneBtn: false, 
  locationBtn: false,
  sticky     : false, 
  openingSpeed: 250,
  closingDelay: 250,
  position: 'static',
  showArrows: true,
  closeBtn     : false,
  scrollbarFix: false,
  mobileMode: false
});