$(function () {
    $("#forma").validate({
        rules: {
            naslov: {
                required: true,
                minlength: 5,
                maxlength: 100,
            },
            sazetak: {
                required: true,
                minlength: 10,
                maxlength: 110,
            },
            tekst: {
                required: true,
            },
            kategorija: {
                required: true,
            },
            slika: {
                required: true,
            },

        },
        // Specify validation error messages
        messages: {
            naslov: {
                required: "Morate unijeti naslov.",
                minlength: "Naslov ne smije biti kraći od 5 znakova.",
                maxlength: "Naslov ne smije biti dulji od 100 znakova.",
            },
            sazetak: {
                required: "Morate unijeti sažetak.",
                minlength: "Sažetak ne smije biti kraći od 10 znakova.",
                maxlength: "Sažetak ne smije biti dulji od 110 znakova.",
            },
            tekst: {
                required: "Morate unijeti tekst.",
            },
            kategorija: {
                required: "Morate odabrati kategoriju.",
            },
            slika: {
                required: "Morate odabrati sliku.",
            },
        },

        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
            form.submit();
        }
    });
});