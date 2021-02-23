<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Invoice Preview PDF</title>
</head>
<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h2 class="text-center">Payment Invoice</h2>
                    </div>
                    <div class="panel-body mt-3">
                        <p class="text-right">Date: {{date('F j, Y', strtotime($payment->date))}}</p>
                        <p>Payment To: <b>{{$payment->staff->name}}</b></p>
                        <p>Amount : <b>Rs. {{$payment->amount}}</b></p>
                        <p>Payment Type: @if ($payment->type == 'advance')
                                            <b>Advance</b>
                                        @elseif ($payment->type == 'regular')
                                            <b>Regular</b>
                                        @elseif ($payment->type == 'overdue')
                                            <b>Overdue</b>
                                        @endif
                        </p>


                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</body>
</html>
