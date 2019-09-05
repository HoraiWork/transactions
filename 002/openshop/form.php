<!doctype html>
<html lang=" ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment form</title>

    <style>
        .container {
            height: auto;
            width: calc(100% - 40px);
            max-width: 500px;
            margin: 0 auto;
            margin-top: 8rem;
            background-color: #fff;
            box-shadow: 1px 2px 10px #607d8b30;
            padding: 20px;
        }

        #pspForm {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            text-align: left;
            font-family: sans-serif;
            font-size: 13px;
        }

        input {
            padding: 10px;
            width: calc(100% - 20px);
            margin: 0;
            margin-bottom: 10px;
            border: 1px solid #607d8b75;
            color: #597684;
            font-size: 16px;
            font-weight: 600;
            display: block;
        }

        label {
            text-align: left;
            padding: 10px 0;
            display: block;
            color: #607D8B;
        }


        #submit2 {
            padding: 20px 0px;
            margin: 40px 0;
            margin-bottom: 10px;
            width: 100%;
            background-color: #0b91d2;
            border: 1px solid #0b91d2;
            color: #fff;
            box-shadow: none;
            text-align: center;
            font-size: 20px;
            cursor: pointer;
        }

        #submit2:hover , #submit2:focus {
            background-color: #fff;
            box-shadow: 1px 2px 10px #607d8b30;
            color: #597684;
            outline: none;
        }

        #results {
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }

        #results a {
            text-decoration: none;
            color: #597684;
            font-family: sans-serif;
        }
        .text_link {
            display: block;
            margin: 10px 0;
        }
        .text_link span {
            overflow-wrap: break-word;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <form method="get" action="https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp" id='pspForm' name='form1'>
        <input type="hidden" name="PSPID" value="transdep">
        <label for="name">Order ID: </label>
        <input type="text" name="ORDERID" value="order_<?php echo rand(10000, 15000); ?>">
        <label for="name">Amount: </label>
        <input type="text" name="AMOUNT" value="<?php echo rand(5000, 15000); ?>">
        <!--    <input type="hidden" name="CURRENCY"  value="EUR">-->
        <label for="name">Currency: </label>
        <input type="text" name="CURRENCY" value="EUR">
        <input type="hidden" name="LANGUAGE" value="en_US">
        <input type="hidden" name="EXCLPMLIST" value="MasterCard;visa;Maestro">
<!--        <input type="text" name="PMLIST" value="VISA">-->

    </form>


    <input class="" name="submit2" id="submit2" value="Submit">
    <br>
    <div id="results"></div>

</div>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
    $(document).ready(function () {

        const pspForm = $('#pspForm');
        var el = document.getElementById('results');

        $('#submit2').on('click', function () {
            $.ajax({
                url: 'send.php',
                method: 'POST',
                dataType: 'json',
                //async: false,
                data: pspForm.serialize(),
                success: (response) => {

                    el.innerHTML = '';
                   // el.innerHTML += '<div class="text_link"><textarea rows="4" cols="60">'  + response['url'] +  '</textarea></div>';
                    el.innerHTML += '<div class="text_link"><span>'  + response['url'] +  '</span></div>';


                }
                ,
                error: (response) => {
                    let json = response.responseText;

                }
            });
        });
    });
</script>

</body>
</html>