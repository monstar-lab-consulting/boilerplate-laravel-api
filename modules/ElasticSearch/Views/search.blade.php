<html>

<head>
    <title>ELK-search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar {
            background: #000000
        }

        .nav-item::after {
            content: '';
            display: block;
            width: 0px;
            height: 2px;
            background: #fec400;
            transition: 0.4s
        }

        .nav-item:hover::after {
            width: 100%
        }

        .navbar-dark .navbar-nav .active>.nav-link,
        .navbar-dark .navbar-nav .nav-link.active,
        .navbar-dark .navbar-nav .nav-link.show,
        .navbar-dark .navbar-nav .show>.nav-link,
        .navbar-dark .navbar-nav .nav-link:focus,
        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fec400
        }

        .nav-link {
            padding: 25px 5px;
            transition: 0.2s
        }

        @import url('https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap');

        body {
            background-color: #E7E9F5;
            font-family: 'Heebo', sans-serif
        }

        .card {
            width: 700px;
            border: none;
            border-radius: 20px
        }

        .form-control {
            border-radius: 7px;
            border: 1.5px solid #E3E6ED
        }

        input.form-control:focus {
            box-shadow: none;
            border: 1.5px solid #E3E6ED;
            background-color: #F7F8FD;
            letter-spacing: 1px
        }

        .btn-primary {
            background-color: #5878FF !important;
            border-radius: 7px
        }

        .btn-primary:focus {
            box-shadow: none
        }

        .text {
            font-size: 13px;
            color: #9CA1A4
        }

        .price {
            background: #F5F8FD;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            width: 97px
        }

        .flex-row {
            border: 1px solid #F2F2F4;
            border-radius: 10px;
            margin: 0 1px 0
        }

        .flex-column p {
            font-size: 14px
        }

        span.mb-2 {
            font-size: 12px;
            color: #8896BD
        }

        h5 span {
            color: #869099
        }

        @media screen and (max-width: 450px) {
            .card {
                display: flex;
                justify-content: center;
                text-align: center
            }

            .price {
                border: none;
                margin: 0 auto
            }
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: black;
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark"> <button class="navbar-toggler" type="button" data-target="#navigation"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item active"> <a href="#" class="nav-link"> Books </a> </li>
            </ul>
        </div>
    </nav>
    <form>
        {{ csrf_field() }}
        <div class="container d-flex justify-content-center">
            <div class="card mt-5 p-4">
                <div class="input-group mb-3"> <input type="text" class="form-control" placeholder="Search anything!">
                    <div class="input-group-append">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                @foreach($books as $book)
                <div class="d-flex flex-row justify-content-between mb-3">
                    <div class="d-flex flex-column p-3">
                        <p class="mb-1">{{$book->title}}</p> <small class="text-muted">{{$book->limit_date}} days remaining</small>
                    </div>
                    <div class="price pt-3 pl-3"> <span class="mb-2">{{($book->status) ? 'Fixed' : 'Hourly'}}</span>
                        <h5><span>&dollar;</span>{{$book->price}}</h5>
                    </div>
                </div>
                @endforeach
                {!! $books->links() !!}
            </div>
        </div>
    </form>
</body>
<footer class="footer">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a>
    </div>
</footer>
</html>
