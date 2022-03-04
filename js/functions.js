$(function(){
    var GET = $('GET').attr('GET');
    var BASE = $('BASE').attr('BASE')
    /*
    function redirectHttps(){
        url = location.href;
        penis = url
        url = url.split('/')
        http = url[0];
        if(http == 'http:'){
            location.href = penis.replace('http:','https:')
        }
    }
    window.onload = function() {
    redirectHttps();

    };
    */
    $(document).on('click','[link]', function(){
        window.location.replace(BASE+'crypto/'+$(this).attr('link'))
    })

    $(document).on({
        ajaxStart: function() { $('.ajaxLoading').removeClass('notdisplay');    },
        ajaxStop: function() { $('.ajaxLoading').toggleClass('notdisplay');  }    ,
        ajaxError: function() { $('.ajaxLoading').toggleClass('notdisplay');  }
    });

    $(document).on('click', '.selectcoin .inside', function(){
        if($(this).parent().find('.tabopen').hasClass('notdisplay')){
            $(this).parent().find('.tabopen').removeClass('notdisplay');
            $(this).parent().find('.material-icons').toggleClass('rot180deg')
       }else{
            $(this).parent().find('.tabopen').toggleClass('notdisplay');
            $(this).parent().find('.material-icons').removeClass('rot180deg')
       }
    })

    $(document).on('click', '.listopen.cripto', function(){
        obj = $(this)
        history.pushState('', '', '?convert='+$(this).attr('coinid')+'&amount='+$('#coinamount').val());
        $(this).find('.tabopen').toggleClass('notdisplay');
        var coinid = $(this).attr('coinid');
        var coinamount = $('#coinamount').val()

        $.ajax({
            url:BASE+'ajax/coinrequest.php',
            method: 'post',
            data: {'token':sessionStorage.getItem('token'),'request':'coinchange','coinid':coinid,'amount':coinamount}
        }).done(function(data){
            data = JSON.parse(data);
            if(data.sucesso){
                $('.card:nth-of-type(1)').empty().prepend(data.coinchange)
                $('.input-field.fiat').empty().prepend(data.response)
            }
        })
    })
    $(document).on('click', '.listopen.fiat', function(){
        var currency = $(this).attr('fiatid').toLowerCase()
        $.ajax({
            url:BASE+'ajax/coinrequest.php',
            method:'post',
            data:{
                'token' : sessionStorage.getItem('token'),
                'request' : 'changecurrency',
                'currency' : currency
            }
        }).done(function(data){
            data = JSON.parse(data);
            if(data.sucesso){
                location.reload()
            }
        })
    })

    $(document).on('keyup', '#coinamount', function(e){
        if($(this).val() > 0 || typeof($(this).val()) == 'number' || e.key == 'number' ){
            var coinid = $(this).parent().parent().find('.coininfo').attr('coinid')
            var coinamount = $(this).val();
            $.ajax({
                url:BASE+'ajax/coinrequest.php',
                method: 'post',
                data: {
                    'token':sessionStorage.getItem('token'),
                    'request':'changeamount',
                    'amount':coinamount, 
                    'coinid': coinid,
                    'iscrypto':true
                }
            }).done(function(data){
                data = JSON.parse(data);
                if(data.sucesso){
                    $('#fiatamount').val(data.result)
                }
            })
        }
        return;
    })
    $(document).on('keyup', '#fiatamount', function(e){
        e.preventDefaut();
        setInterval(function(){
            $(this).prop('disabled',true)
            if($(this).val() > 0 || typeof($(this).val()) == 'number' || e.key == 'number'){
                var coinid = $(this).parent().parent().parent().find('.coininfo').attr('coinid')
                var coinamount = $(this).val();
                $.ajax({
                    url:BASE+'ajax/coinrequest.php',
                    method: 'post',
                    data: {
                        'token':sessionStorage.getItem('token'),
                        'request':'changeamount',
                        'amount':coinamount, 
                        'coinid': coinid,
                        'iscrypto':false
                    }
                }).done(function(data){
                    data = JSON.parse(data);
                    if(data.sucesso){
                        $('#coinamount').val(data.result) 
                    }
                })
            }
        }, 2000)
        $(this).prop('disabled',false)

    })

    $(document).on('keypress', '[name="searchcrypto"]', function(){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            var search = $(this).val();
            $.ajax({
                url:BASE+'ajax/coinrequest.php',
                method:'post',
                data: {
                    'token':sessionStorage.getItem('token'),
                    'request':'searchcrypto',
                    'search':search
                }
            }).done(function(data){
                data = JSON.parse(data);
                $('.tabopen .list .listinside').empty()
                if(data.result){
                    $('.listinside').prepend(data.result)
                }else{
                    $('.listinside').prepend('<p style="padding: 5px 0;">Nada encontrado ;(</p>')
                }

            })
        }
    })

    $(document).on('change', '[name="currency"]', function(e){
        var currency = $(this).val().toLowerCase()
        $.ajax({
            url:BASE+'ajax/coinrequest.php',
            method:'post',
            data:{
                'token' : sessionStorage.getItem('token'),
                'request' : 'changecurrency',
                'currency' : currency
            }
        }).done(function(data){
            data = JSON.parse(data);
            if(data.sucesso){
                location.reload()
            }
        })
    })
})