@extends('layouts.app')
@extends('index_styles')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lab</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="background-color: #28343c;">

</body>
<div class="container" style="max-width: 80%;">
    <div class="row justify-content-center">
        <div class="col-md-12 pl-5 pr-5">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div style="background-color:#f7f7f7; border: 1px solid #c9cbcb" class="card-body pb-0">
                    <form id="asyncForm" name="asyncForm" onsubmit="return false">
                        <div class="form-group">
                            <div class="col-12 m-0">
                                <div class="input-group mb-3">
                                    <input id='dataInput' value="https://docs.google.com/document/d/1qdVixV5PyxyPaunfIwEgaetT4VYbcvDYIhS6j8yc1ew/edit?usp=sharing" name="member" type="text" class="form-control mr-3" placeholder="Enter username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <select id="inputState" class="form-control">
                                            <option>Search User By UserName (API)</option>
                                            <option>Search User By Email (API)</option>
                                            <option>Search User By Id (API)</option>
                                            <option>Search for Image</option>
                                            <option>Search Song From Spotify</option>
                                            <option selected>Add Document</option>
                                            <option>Search User By Email</option>
                                            <option>Search User By Id</option>
                                            <option>Create Fake User</option>
                                        </select>
                                    </div>
                                    <div class="input-group-append">
                                        <button id="asyncBtn" class="btn btn-primary" id="search-addon">
                                            <i class="fas fa-arrow-alt-circle-right"></i>&nbsp Submit
                                        </button>
                                    </div>
                                    &nbsp&nbsp
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="response">
                        <div class="loading-icon" id="loading-icon" hidden></div>
                    </div>
                    <button style="display: none; margin-bottom: 10px" id="download" onclick="window.location=''" class="btn btn-info btn-sm">
                        <i class="fas fa-download"></i>&nbsp Download
                    </button>
                </div>

                <div id="scroller" class="table-wrapper">
                    <div class="d-flex justify-content-center align-items-center">
                        <ul id="spotify-search-result" class="list-group ">
                        </ul>
                    </div>
                    <div id="imageContainer" class="image-container"></div>
                    <table id="displayTable" class="table table-bordered data-table table-striped">
                        <thead id="tableHead" style="position: sticky;">
                        </thead>
                        <tbody id="tableBody">
                        </tbody>
                    </table>
                </div>
                <table id="dynamicTable" class="table table-striped">
                    <thead></thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

</html>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });



    $('#asyncBtn').click(function(event) {

        $('#loading-icon').show();

        var inputState = $('#inputState').val()
        var dataInput = $('#dataInput').val()

        console.log("async Btn has been clicked")
        console.log(inputState, dataInput)

        if (inputState == "Add Document") {


            $.ajax({
                url: '/google/docs/submit',
                type: 'get',
                data: {
                    input: dataInput,
                },
                success: function(response) {
                    $('#loading-icon').show();
                    console.log(response)
                },
                error: function(xhr) {
                    console.log(xhr.responseText);

                }
            });


        }
    });
</script>
@endsection