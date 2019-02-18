<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>TEST CSRF</title>
    <meta name="csrf_token" content="<?= $this->security->get_csrf_hash(); ?>">
</head>
<body>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-lg-4">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">GET</h5></div>
                        <div class="modal-body">
                            <form id="get">
                                <div class="form-group row">
                                    <label for="inputGetName" class="col-sm-2 col-form-label">NAME</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputGetName" name="name" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="inputGetResult" class="col-sm-2 col-form-label">RESULT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputGetResult" name="result" value="" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="getSubmit();">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">POST</h5></div>
                        <div class="modal-body">
                            <form id="post">
                                <div class="form-group row">
                                    <label for="inputPostName" class="col-sm-2 col-form-label">NAME</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPostName" name="name" value="">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="inputPostResult" class="col-sm-2 col-form-label">RESULT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPostResult" name="result" value="" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="postSubmit();">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">POST MULTIPART</h5></div>
                        <div class="modal-body">
                            <form id="post-multipart">
                                <div class="form-group row">
                                    <label for="inputPostMultipartName" class="col-sm-2 col-form-label">NAME</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPostMultipartName" name="name" value="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPostMultipartFile" class="col-sm-2 col-form-label">FILE<small>(IMAGE)</small></label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control-file" id="inputPostMultipartFile" name="file">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="inputPostResult" class="col-sm-2 col-form-label">RESULT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPostResult" name="result" value="" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="postMultipartSubmit();">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
    $(document).ready(function(){
        // set csrf
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            if (!options.processData && !options.contentType) {
                options.data.append('csrf_token', getCookie('csrf_cookie'))
            } else if (options.type.toLowerCase() === 'post') {
                options.data = $.param($.extend({}, originalOptions.data, {
                    csrf_token: getCookie('csrf_cookie')
                }))
            }
        })

        // set ajax error
        $(document).on('ajaxError', function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR)
            console.log(textStatus)
            console.log(errorThrown)
        })
    })

    // test get
    function getSubmit ()
    {
        var targetForm = $('form#get')
        var data = {
            name: $('input[name=name]', targetForm).val()
        }

        $.ajax({
            type: 'get',
            url: '/_ajax/test/method_get',
            data: data,
            dataType: 'json',
            success: function (response) {
                $('input[name=result]', targetForm).val(response.message)

                if (!response.status && typeof response.field !== 'undefined') {
                    $('[name=' + response.field + ']', targetForm).focus()
                }
            }
        })
    }

    // test post
    function postSubmit ()
    {
        var targetForm = $('form#post')
        var data = {
            name: $('input[name=name]', targetForm).val()
        }

        $.ajax({
            type: 'post',
            url: '/_ajax/test/method_post',
            data: data,
            dataType: 'json',
            success: function (response) {
                $('input[name=result]', targetForm).val(response.message)

                if (!response.status && typeof response.field !== 'undefined') {
                    $('[name=' + response.field + ']', targetForm).focus()
                }
            }
        })
    }

    // test post multipart
    function postMultipartSubmit ()
    {
        var targetForm = $('form#post-multipart')
        var data = new FormData()
        data.append('name', $('input[name=name]', targetForm).val())
        data.append('file', $('input[name=file]', targetForm)[0].files[0])

        $.ajax({
            type: 'post',
            url: '/_ajax/test/method_post_multipart',
            processData: false,
            contentType: false,
            data: data,
            dataType: 'json',
            success: function (response) {
                $('input[name=result]', targetForm).val(response.message)

                if (!response.status && typeof response.field !== 'undefined') {
                    $('[name=' + response.field + ']', targetForm).focus()
                }
            }
        })
    }

    // helper getCookie
    function getCookie(cname) {
        var name = cname + '='
        var decodedCookie = decodeURIComponent(document.cookie)
        var ca = decodedCookie.split(';')
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i]
            while (c.charAt(0) == ' ') {
                c = c.substring(1)
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length)
            }
        }
        return ''
    }
    </script>
</body>
</html>