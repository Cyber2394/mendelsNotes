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
    </style>
</head>

<body>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach($data as $doc)
                <div class="col mb-5">
                    <a href="/google-docs/{{$doc->document_id}}" class="text-decoration-none" style="color: black;">
                        <div class="card h-100 text-box">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$doc->name}}</h5>
                                    <br>
                                    <br>
                                    <span class="user-text">{{$doc->user}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach


                <div class="col mb-5">
                    <a onclick="openForm()" class="text-decoration-none" style="color: black;">
                        <div class="card h-100 text-box position-relative">
                            <div class="card-body p-4">
                            </div>
                            <!-- Plus icon in the center -->
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <h1 style="color: white;">+</h1>
                            </div>
                            <!-- Black square angles in each corner -->
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
                </div>
            </div>
        </div>

        <div class="col mb-5">
            <button class="btn btn-primary" onclick="openForm()">
                Open Document
            </button>
        </div>

        <div class="modal fade" id="docAddForm" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentModalLabel">Add Google Doc</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="closeform()">X</button>
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
    <!-- Bootstrap JS and dependencies (add them at the end of the body for faster page loading) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>

<script>
    function openForm() {
        $('#docAddForm').modal('show');
    }

    function closeForm() {
        $('#docAddForm').modal('hide');
    }
    $(document).ready(function() {
        // Ensure jQuery is loaded before executing the script
        console.log('jQuery version:', $.fn.jquery);

        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Define functions inside the document.ready scope

        $('#docFormSubmit').click(function() {
            var input = $('#linkInput').val();

            $.ajax({
                type: 'POST',
                url: '/google/docs/submit',
                data: {
                    input: input
                },
                success: function(response) {
                    // Handle success response
                    console.log(response);
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