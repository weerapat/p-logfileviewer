<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Log File Viewer</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- App css -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <style>
            .table { background-color: #fff; }
            .table th { background-color: #2d2d2d; color: #fff }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Log file viewer</h1>
                </div>
            </div>

            <div class="row">
                <div>
                    <div class="col-md-8 col-sm-8">
                        <div class="form-group">
                            <input type="text" placeholder="/var/tmp/file.log" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <div class="btn btn-info btn-block">View</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <th>No.</th>
                            <th class="text-center">Log message</th>
                        </thead>
                        <tbody>
                        @foreach ($logData as $log)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
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
