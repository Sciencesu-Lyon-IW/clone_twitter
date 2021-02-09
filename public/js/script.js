$(document).ready(function(){
    console.log("document chargé");


    /*
    * -----------------------------------
    *          Like AJAX
    * ----------------------------------
    */

    let haslike = false;
    let iconLike = $('.iconLike');
    /*console.log("hasLike = " + haslike);*/
    iconLike.click(function (e){
        e.preventDefault(); // annule l'action du lien
      /*  console.log("icon comment cliqué");*/
        haslike = true
   /*     console.log("hasLike = " + haslike);
        console.log("id du post : " +this.getAttribute('id'));*/
        let isAuthenticated = iconLike.data('isAuthenticated');
        let isPost = iconLike.data('isLike');
        console.log("id du post : " + this.getAttribute('id'));


        $.ajax({
            url: '/like/tweet',
            type: "POST",
            dataType: "json",
            data: {
                'hasLike': haslike,
                'whoLike':isAuthenticated,
                'post': this.getAttribute('id'),
            },
            async: true,
            success: function (data) {
                let datas = data.output;
                console.log(datas);
                $('#likes').css({"color": "rgb(227, 57, 109)"});
                haslike = true
                console.log("poste + 1 like " + haslike);

            },
            error: function (data)
            {
                console.log("aucune data : ");
                $('#likes').css({"color": "rgb(227, 57, 109)"});
                haslike = false

                console.log("post n'a pas pris de like " + haslike);

            }
        })

    })
    let hasRetweet = false;
    let iconRetweet = $('.iconRetweet');
    iconRetweet.click(function (e){
        e.preventDefault(); // annule l'action du lien
        console.log("icon retweet cliqué");
        hasRetweet = true
        console.log("hasRetweet = " + hasRetweet);
        let whoRetweet = iconRetweet.data('isAuthenticated');
        console.log("id du post : " + this.getAttribute('id'));

        $.ajax({
            url: '/retweet/tweet',
            type: "POST",
            dataType: "json",
            data: {
                'whoRetweet': whoRetweet,
                'post': this.getAttribute('id'),
            },
            async: true,
            success: function (data) {
                let datas = data.output;
                console.log(datas);
                $('#likes').css({"color": "rgb(227, 57, 109)"});

            },
            error: function (data)
            {
                console.log("aucune data : "  );
                $('#likes').css({"color": "rgb(227, 57, 109)"});

            }
        })

    })

    $('.modal-comment').css('display', 'none');

    $('.iconComment').click(function (e) {

        e.preventDefault();

        console.log('clicker none');
        $('.modal-comment').css('display', 'block');

    })


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

