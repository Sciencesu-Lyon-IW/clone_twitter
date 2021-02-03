
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});


/*
    AJAX_TWEET
 */
/*

$("input[type=submit]").addEventListener('submit', function (e){
    $.ajax({
        url: "{{ path('ajax_create_tweet') }}",
        type: "POST",
        dataType: "json",
        data: {
            "whats_happening": $('input[name="whats_happening"]').val()
        },
        async: true,
        success: function (data) {
            let datas = data.output;
            console.log(datas);
        },
        error: function (data)
        {
            console.log("aucune data");
        }
    })
});*/
