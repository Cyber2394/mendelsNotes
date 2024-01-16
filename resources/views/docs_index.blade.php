@extends('layouts.app')
@extends('index_styles')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Docs</title>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Add your custom styles here */
        .card-link {
            text-decoration: none;
            color: black;
        }

        .text-box {
            background-color: #dee2e6;
        }

        .card {
            width: 150px;
        }

        .card .fw-bolder {
            max-height: 100px;
            /* Set the initial height */
            overflow: hidden;
            /* Hide overflow content */
            transition: max-height 0.3s;
            /* Add smooth transition effect */
        }

        .card:hover .fw-bolder {
            max-height: 200px;
            /* Expand the height on hover */
        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
        }

        .top-50 {
            top: 50%;
        }

        .start-50 {
            left: 50%;
        }

        .translate-middle {
            transform: translate(-50%, -50%);
        }

        .black-square-wide {
            position: absolute;
            width: 40px;
            height: 5px;
            background-color: grey;
        }

        .black-square-long {
            position: absolute;
            width: 5px;
            height: 40px;
            background-color: grey;
        }

        .top-left {
            top: 3px;
            left: 3px;
        }

        .top-left-side {
            top: 3px;
            left: 3px;
        }

        .top-right {
            top: 3px;
            right: 3px;
        }

        .top-right-side {
            top: 3px;
            right: 3px;
        }

        .bottom-right {
            bottom: 3px;
            right: 3px;
        }

        .bottom-right-side {
            bottom: 3px;
            right: 3px;
        }

        .bottom-left {
            bottom: 3px;
            left: 3px;
        }

        .bottom-left-side {
            bottom: 3px;
            left: 3px;
        }

        #invalidUrl {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            /* Adjust the z-index to ensure it's on top of everything */
        }
    </style>
</head>

<body>

    <div class="container">
        <button onclick="openForm()" class="btn btn-primary">Add Document</button>
    </div>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($data as $doc)
                <div class="col mb-5" id="{{$doc->id}}">
                    <a style="color: red;" onclick="deleteDoc('{{$doc->id}}')" data-id="{{$doc->id}}">Delete</a>
                    <a href="/google-docs/{{$doc->document_id}}" class="text-decoration-none" style="color: black;">
                        <div class="card h-100 text-box">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$doc->name}}</h5>
                                    <br>
                                    <br>
                                    <span class="user-text">By: {{$doc->user}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                <div id="addedDoc">

                </div>
                <!-- this is the plus icon to open the form -->
                <!-- <div class="col mb-5" style="margin-top: 50;">
                    <a onclick="openForm()" class="text-decoration-none" style="color: black;">
                        <div class="card h-100 text-box position-relative">
                            <div class="card-body p-4">
                            </div>
                            
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <h1 style="color: white;">+</h1>
                            </div>

                            <div class="black-square-wide top-left"></div>
                            <div class="black-square-long top-left-side"></div>
                            <div class="black-square-wide top-right"></div>
                            <div class="black-square-long top-right-side"></div>
                            <div class="black-square-wide bottom-left"></div>
                            <div class="black-square-long bottom-left-side"></div>
                            <div class="black-square-wide bottom-right"></div>
                            <div class="black-square-long bottom-right-side"></div>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>

        <div class="modal fade" id="docAddForm" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- invaling Url alert  -->
                        <div hidden class="alert alert-danger alert-dismissible fade show" role="alert" id="invalidUrl">
                            <span id="invalidUrlText"></span>
                        </div>
                        <!--  -->
                        <h5 class="modal-title" id="documentModalLabel">Add Google Doc</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="$('#docAddForm').modal('hide');">X</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="linkInput" class="form-label">Doc Share Link</label>
                                <input type="text" class="form-control" id="linkInput" placeholder="https://docs.google.com/document/d/doc_id/edit?usp=sharing">
                                <a href="/explain-add-doc">Need Help?</a>
                            </div>
                            <button type="submit" class="btn btn-primary" id="docFormSubmit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>

<script>
    function openForm() {
        $('#docAddForm').modal('show');
    }

    function closeForm() {
        $('#docAddForm').modal('hide');
    }

    function deleteDoc(docId) {
        console.log(docId)

        $.ajax({
            type: 'GET',
            url: '/google-docs/delete/' + docId,
            success: function(response) {
                // console.log(response);

                $('#' + docId).empty();

            },
            error: function(error) {
                // Handle error response
                console.error(error);
            }
        });
    }
    $(document).ready(function() {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#docFormSubmit').click(function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            var input = $('#linkInput').val();

            $.ajax({
                type: 'GET',
                url: '/google/docs/submit',
                data: {
                    input: input
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    if (response.error) {
                        $('#invalidUrlText').text(response.error);
                        // document.getElementById("invalidUrl").element.removeAttribute('hidden');
                        // showElementById('invalidUrl');
                        document.getElementById("invalidUrl").removeAttribute('hidden');
                        setTimeout(function() {
                            // Code to set the 'hidden' attribute after the delay
                            document.getElementById('invalidUrl').setAttribute('hidden', 'true');
                        }, 2000);
                    }
                    if (!response.error) {
                        $('#addedDoc').html(`
                            <div class="col mb-5" id="${response.id}">
                                <a style="color: red;" onclick="deleteDoc('${response.id}')" data-id="${response.id}">Delete</a>
                                <a href="/google-docs/${response.document_id}" class="text-decoration-none" style="color: black;">
                                    <div class="card h-100 text-box">
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <!-- Product name-->
                                                <h5 class="fw-bolder">${response.name}</h5>
                                                <br>
                                                <br>
                                                <span class="user-text">By: ${response.user}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        `);
                    }
                },
                error: function(error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection