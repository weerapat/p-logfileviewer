<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- App css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <style>
            .table { background-color: #fff; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Log file viewer</h1>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>No.</th>
                            <th class="text-center">Log message</th>
                        </thead>
                        <tbody>
                        @foreach ($logData as $log)
                            <tr>
                                <td class="text-center">1</td>
                                <td>{{ $log }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </body>
</html>
