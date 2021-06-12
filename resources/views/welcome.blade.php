<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <!-- Styles -->
        <style>
            body {
                background: #E5E5E5;
            }
            html {
                scroll-behavior: smooth;
            }
            a{
                color: #FFDE03;
            }
            a:hover{
                color: #1DE9B6;
                padding-left: 5px;
            }
            .contentDiv{
                background: #424250;
                color: #fff;
            }
            h3{
                color:#33C6B2;
            }
            h5{
                color: #e2f0fb;
                border-bottom: 2px dashed #fff;
                padding-bottom: 10px;
                margin-bottom: 10px;
            }
            code{
                padding: 5px;
            }

            #toTop {
                position: fixed;
                bottom: 20px;
                right: 30px;
                z-index: 99;
                font-size: 18px;
                border: none;
                outline: none;
                background-color: #03DAC5;
                color: #333;
                cursor: pointer;
                padding: 15px;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>

        <button id="toTop" title="Go to top"><i class="fa fa-arrow-up"></i></button>

        <div class="container p-5 contentDiv" id="attachments">
            <div class="row">
                <div class="text-center col-md-12">
                    <h1 style="color:#33C6B2;">Presentation for Development Consultancy Group</h1>
                    <h5 class="pt-3"><strong>Topic : </strong>Image/Attachment Management</h5>
                </div>
            </div>
        </div>

        <div class="container p-5 mt-3 contentDiv"  id="attachments">
            <div class="row">
                <div class="col-md-12">
                    <h3>Items to be discussed</h3>
                    <ul>
                        <li>Image Management
                            <ul>
                                <li><a href="#representation_types">Types of Image Representation Format</a></li>
                                <li><a href="#rawToBase64">Raw Image to Binary to Base64</a></li>
                                <li><a href="#base64ToRaw">Base64 to Binary to Raw Image</a></li>
                                <li><a href="#tokenBasedImage">Represent Image as URL with expire time</a></li>
                            </ul>
                        </li>
                        <li><a href="#exlToDB">Store Data to DB from Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mt-3 p-5 contentDiv" id="representation_types">
            <div class="row">
                <div class="col-md-12">
                    <h3>Types of Image Representation Format</h3>
                    <ul>
                        <li>Raw Images [Ex: JPG, JPEG, PNG]</li>
                        <li>Blob Images </li>
                        <li>Base64 Images </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container mt-3 p-5 contentDiv" id="rawToBase64">
            <div class="row">
                <div class="col-md-12">
                    <h3>Image Convertion : Raw->Blob->Base64</h3>
                    <div class="row">
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Code</h5>
                            <div>
                                <p> <strong>Step One : </strong> Fetch the file <br>
                                    <code>$file = Input::file('file');</code> </p>
                                <p> <strong>Step Two : </strong> Get the file data as blob <br>
                                    <code>$blobData = file_get_contents($file);</code> </p>
                                <p> <strong>Step Three : </strong> Convert the blob data to Base64 <br>
                                    <code>$base64Data = base64_encode($blobData);</code> </p>
                            </div>
                        </div>
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Test Code</h5>
                            <form method="post" id="toBase64" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="imageFile">Choose an Image </label>
                                    <input type="file" class="form-control form-control-sm" id="imageFile" aria-describedby="emailHelp">
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" id="convertToBase64">Convert</button>
                                <button type="button" class="btn btn-primary btn-sm" id="brwBase64">Prepare for browser view </button>
                                <button type="button" class="btn btn-default btn-sm" id="clrBase64">Clear</button>
                            </form>

                            <div id="base64ImageText"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3 p-5 contentDiv" id="base64ToRaw">
            <div class="row">
                <div class="col-md-12">
                    <h3>Image Convertion : Base64->Blob->Raw</h3>
                    <div class="row">
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Code</h5>
                            <div>
                                <p> <strong>Step One : </strong> Fetch the Base64 Data <br>
                                    <code>$base64_data = $request['base64Txt'];</code> </p>
                                <p> <strong>Step Two : </strong> Get the file data as blob <br>
                                    <code>$blob_data = base64_decode($base64_data);</code> </p>
                                <p> <strong>Step Three : </strong> Get the image mime type <br>
                                    <code>
                                        $f = finfo_open(); <br>
                                        &nbsp; $mime_type = finfo_buffer($f, $blob_data, FILEINFO_MIME_TYPE); <br>
                                        &nbsp; $split = explode( '/', $mime_type ); <br>
                                        &nbsp; $type = $split[1];
                                    </code>
                                </p>
                                <p> <strong>Step Four : </strong> Prepare a unique file name<br>
                                    <code>$fileName = time().'.'.$type;</code> </p>
                                <p> <strong>Step Five : </strong> Store the image to a location<br>
                                    <code>file_put_contents('images/'.$fileName,$blob_data);</code> </p>
                            </div>
                        </div>
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Test Code</h5>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <textarea name="base64" class="form-control" id="base64Txt" placeholder="Paste Base64 data here"></textarea>
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" id="convertToImg">Convert</button>
                                <button type="button" class="btn btn-default btn-sm" id="clrImg">Clear</button>
                            </form>

                            <div id="rawImg">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3 p-5 contentDiv" id="tokenBasedImage">
            <div class="row">
                <div class="col-md-12">
                    <h3>Represent image as url with expire time</h3>
                    <div class="row">
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Code</h5>
                            <div>
                                <h6><i><u>Create URL for Image</u></i></h6>
                                <p> <strong>Step One : </strong> Fetch the file and store that to a location <br>
                                    <code>
                                        $file = Input::file('file'); <br>
                                        $destinationPath = public_path('/images/'); <br> <br>
                                        $image = date('YmdHis') . "." . $file->getClientOriginalExtension(); <br><br>
                                        $file->move($destinationPath, $image);
                                    </code>
                                </p>
                                <p> <strong>Step Two : </strong> Set expire time for that url <br>
                                    <code>$exp_time = time() + 15;</code> </p>
                                <p> <strong>Step Three : </strong> Create an url with file data and expire time<br>
                                    <code>
                                        $data = [
                                            'file' => $destinationPath.$image,
                                            'exp' =>$exp_time,
                                        ]; <br>
                                        &nbsp; $data = Crypt::encryptString(json_encode($data)); <br>
                                        &nbsp; $imgUrl = url('image_url?data='.urlencode($data));
                                    </code>
                                </p>
                                <br>

                                <h6><i><u>Display Image From URL</u></i></h6>
                                <p> <strong>Step One : </strong> Fetch the file data and expire time from URL<br>
                                    <code>
                                        $data = $request['data'];<br>
                                        $decryptData = Crypt::decryptString($data);<br>
                                        $data = json_decode($decryptData);
                                    </code>
                                </p>
                                <p> <strong>Step Two : </strong> Check expire time for that url <br>
                                    <code>
                                        &nbsp; if($data->exp < time()){ <br>
                                        &nbsp; &nbsp; echo 'Image time expired'; <br>
                                        &nbsp; &nbsp; exit;<br>
                                        &nbsp; }
                                    </code> </p>
                                <p> <strong>Step Three : </strong> If expire time still valid then display the image<br>
                                    <code>
                                        &nbsp; $finfo = getimagesize($data->file); <br>
                                        &nbsp; $mime = $finfo['mime']; <br>
                                        &nbsp; header("Content-Type:$mime"); <br>
                                        &nbsp; echo file_get_contents($data->file); <br>
                                        &nbsp; exit;
                                    </code>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Test Code</h5>
                            <form method="post" id="urlBaseImg" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="imageFile">Choose an Image </label>
                                    <input type="file" class="form-control form-control-sm" id="imageFileForURl" aria-describedby="emailHelp">
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" id="url">Generate URL</button>
                                <button type="button" class="btn btn-default btn-sm" id="clr_img_url">Clear</button>
                            </form>

                            <a href="" target="_blank" id="img_url" style="margin-top: 10px; display: none; ">Click To view</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3 p-5 contentDiv" id="exlToDB">
            <div class="row">
                <div class="col-md-12">
                    <h3>Store Excel File Data to DB</h3>
                    <div class="row">
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Code</h5>
                            <div>
                                <p> <strong>Step One : </strong> Fetch the file and read the data<br>
                                    <code>
                                        $file = Input::file('file'); <br>
                                        $data= Excel::load($file, function($reader) {})->get()->toArray();
                                    </code>
                                </p>
                                <p> <strong>Step Two : </strong> Loop through the data and store to db <br>
                                    <code>
                                        foreach ($data as $value) { <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;$data=new User(); <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;$data->name=$value['name']; <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;$data->email=$value['email']; <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;$data->save(); <br>
                                        }
                                    </code> </p>
                            </div>
                        </div>
                        <div class="col-md-6 border border-1 p-3">
                            <h5 class="text-center">Test Code</h5>
                            <form method="post" id="exclFileFrm" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exclFile">Upload an excel file</label>
                                    <input type="file" class="form-control form-control-sm" id="exclFile">
                                </div>
                                <button type="submit" class="btn btn-info btn-sm" id="subExlFile">Submit</button>
                            </form>

                            <p id="storeExlMsg"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function(){

                $('#base64ImageText').css('color','');

                $('#clrBase64').click(function (e) {
                    $('#base64ImageText').html('');
                });

                $('#clrImg').click(function (e) {
                    $('#rawImg img').attr('src','');
                    $('#base64Txt').val('');
                });

                $('#clr_img_url').click(function (e) {
                    $('#img_url').attr('href','');
                    $('#base64Txt').hide();
;                });

                $('#brwBase64').click(function (e) {
                    var txt = $('#base64ImageText').html();
                    if(txt == ''){
                        $('#base64ImageText').html('Please select an image to convert');
                        $('#base64ImageText').css('color','red');
                    }else{
                        $('#base64ImageText').html('data:image/jpeg;base64,'+ txt);
                        $('#base64ImageText').css('color','');
                    }
                });

                /*
                    Convert to Base64====================================================
                */
                $('#convertToBase64').click(function (e) {
                    e.preventDefault();
                    var btn = $(this);
                    var btn_text = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;'+btn_text);

                    $('#base64ImageText').html('');

                    formdata = new FormData();
                    if ($('#imageFile').prop('files').length > 0) {
                        file = $('#imageFile').prop('files')[0];
                        formdata.append("file", file);
                    }

                    $.ajax({
                        url: "{{ url('/image/convertToBase64')}}",
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        dataType: 'JSON',
                        success: (data) => {
                            if(data.blobTxt != '' && data.base64Txt != ''){
                                $('#base64ImageText').html(data.base64Txt);
                                $('#base64ImageText').addClass('p-2');
                                $('#base64ImageText').css('word-break','break-all');
                                btn.html(btn_text);
                            }
                            btn.html(btn_text);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });

                /*
                    Convert to Raw Image=================================================
                */
                $('#convertToImg').click(function (e) {
                    e.preventDefault();
                    var btn = $(this);
                    var btn_text = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;'+btn_text);

                    $('#rawImg img').attr('src','');

                    $.ajax({
                        url: "{{ url('/image/convertToRawImg')}}",
                        type: 'POST',
                        data: {
                            'base64Txt':$('#base64Txt').val()
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: (data) => {
                            if(data.imgSrc != '' ){
                                $('#rawImg img').attr('src',data.imgSrc);
                                $('#rawImg').css('margin-top','10px');
                                btn.html(btn_text);
                            }
                            btn.html(btn_text);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });

                /*
                    Convert to Url based Image=================================================
                */
                $('#url').click(function (e) {
                    e.preventDefault();
                    var btn = $(this);
                    var btn_text = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;'+btn_text);

                    $('#img_url').attr('href','');

                    formdata = new FormData();
                    if ($('#imageFileForURl').prop('files').length > 0) {
                        file = $('#imageFileForURl').prop('files')[0];
                        formdata.append("file", file);
                    }

                    $.ajax({
                        url: "{{ url('/image/generateUrlForImg')}}",
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        dataType: 'JSON',
                        success: (data) => {
                            if(data.imgUrl != '' ){
                                $('#img_url').show();
                                $('#img_url').attr('href',data.imgUrl);
                                btn.html(btn_text);
                            }
                            btn.html(btn_text);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });

                /*
                    Store excel file data to DB=================================================
                */
                $('#subExlFile').click(function (e) {
                    e.preventDefault();
                    var btn = $(this);
                    var btn_text = btn.html();
                    btn.html('<i class="fa fa-spinner fa-spin"></i>&nbsp;'+btn_text);

                    formdata = new FormData();
                    if ($('#exclFile').prop('files').length > 0) {
                        file = $('#exclFile').prop('files')[0];
                        formdata.append("file", file);
                    }

                    $.ajax({
                        url: "{{ url('/exclToDB')}}",
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        dataType: 'JSON',
                        success: (data) => {
                            if(data.responseCode == 1 ){
                                $('#storeExlMsg').html(data.msg);
                            }else{
                                $('#storeExlMsg').html(data.msg);
                            }
                            btn.html(btn_text);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
                });



                $("#toTop").click(function () {
                    $("html, body").animate({scrollTop: 0}, 500);
                });

            });

        </script>
    </body>
</html>
