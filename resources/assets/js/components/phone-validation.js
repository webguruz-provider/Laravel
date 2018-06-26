jQuery(document).ready(function($) {

    var getKeyCode = function (str) {
        return str.charCodeAt(str.length - 1);
    }

    $("input[data-format='phone']").keydown(function(e) {
        var val = $(this).val();
        var numberLength = val.replace(/[^0-9]/g,"").length;
        var totalLength = this.value.length;

        var keyCode = e.keyCode;
        if (keyCode == 0 || keyCode == 229) { //for android chrome keycode fix
            keyCode = getKeyCode(this.value);
        }

        // If not number, delete, tab, or left/right arrow
        if ( (keyCode > 57 || keyCode < 48) && keyCode != 8 && keyCode != 9 && keyCode != 37 && keyCode != 39 ) {
           e.preventDefault();
           return;
        }

         // If not number, delete, tab, or left/right arrow
        if (keyCode != 8 && keyCode != 9 && keyCode != 37 && keyCode != 39){
            if (numberLength == 3){
                var strip = val.replace(/\D/g,'');
                $(this).val("(" + strip + ")" + " ");
                return;
            } else if (numberLength == 6 && totalLength == 9) {
                $(this).val(val + "-");
                return;
            }
            if (numberLength == 10) {
                e.preventDefault();
                return;
            }
        }
    });

    /** Format on blur */
    $("input[data-format='phone']").blur(function(e) {
        var val = $(this).val();
        var numberLength = val.replace(/[^0-9]/g,"").length;
        while (numberLength >= 10){
            var strip = val.replace(/\D/g,'');
            $(this).val('(' +  strip.substr(0, 3) + ') ' + strip.substr(3, 3) + '-' + strip.substr(6,4));
            $('span[data-message="phone"]').html('<span class="success">This phone number looks good to go!</span>');
            return;
        }
        $('span[data-message="phone"]').html('<span class="error">This phone number may be incorrect—please double-check before you submit!</span>');
    });
});