$(document).ready(function (qualifiedName){
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
    /*
        * MODAL  TWEET REPLY *
    */
    let openModal = $('.openmodal');
    let post = [];
    openModal.click(function (e) {
        e.preventDefault();

        $('.modal').addClass('opened');
        post = [$(this).attr('data-id')];
    });
    /*
           * AJAX TWEET REPLY *
        */


        let btnTweetReply = $('button#btn_tweet_reply');
        let textAreaTweetReply = $("input#textarea_tweet_reply");
        btnTweetReply.click(function (e){
            e.preventDefault(); // annule l'action du lien
            console.log("bouton tweet reply clické");
            // console.log(textAreaTweetReply[1].value);//or inputs[i].val() will also work
            $.ajax({
                url: '/comment/tweet',
                type: "POST",
                dataType: "json",
                data: {
                    'post': post.toString(),
                    'comment': textAreaTweetReply[1].value
                },
                async: true,
                success: function (data) {
                    e.preventDefault();

                    let datas = data.output;
                    console.log(datas);
                    $('#likes').css({"color": "rgb(227, 57, 109)"});

                },
                error: function (data)
                {
                    e.preventDefault();


                    console.log("aucune data : "  );
                    $('#likes').css({"color": "rgb(227, 57, 109)"});

                }
            })
        })


    $('.closemodal').click(function (e) {
        e.preventDefault();
        $('.modal').removeClass('opened');
            $('input').val('');

    });

    for (let i = 0; i < $('.comment > p').length; i++) {
        console.log($('.comment p').children().length);
    }



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

