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
                        <p class="text-center">{{$payment->monthyear}}</p>
                    </div>
                    <div class="panel-body mt-3">
                        <p class="text-right">Date: {{date('F j, Y', strtotime($payment->payment_date))}}</p>
                        <p>Payment To: <b>{{$payment->staff->name}}</b></p>
                        <p>Position: <b>{{$position->name}}</b></p>
                        <p>Total Working Days: <b>30 days</b></p>
                        <p>Salary Type: <b>
                            @php
                                if ($payment->salary_type == 'advance') {
                                    $salary_type = 'Advance';
                                }elseif($payment->salary_type == 'regular')
                                {
                                    $salary_type = 'Regular';
                                }
                            @endphp
                            {{$salary_type}}
                            </b></p>
                        <br>

                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Info</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Allocated Salary</td>
                                    <td>Rs. {{$staff->allocated_salary}}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Total Paid Leave
                                        @php
                                            $attended = 0;
                                            foreach($attendance as $attend)
                                            {
                                                $attended = $attended + $attend->paid_leave;
                                            }
                                            echo '('.$attended.' days)';
                                        @endphp
                                    </td>
                                    <td>-</td>
                                </tr> --}}
                                {{-- <tr>
                                    <td>Total Unpaid Leave
                                        @php
                                            $unattended = 0;
                                            foreach($attendance as $attend)
                                            {
                                                $unattended = $unattended + $attend->unpaid_leave;
                                            }
                                            echo '( Rs. '. round($multiplying_factor) . ' * ' .$unattended.' days )';
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            $unattended = 0;
                                            foreach($attendance as $attend)
                                            {
                                                $unattended = $unattended + $attend->unpaid_leave;
                                            }
                                            $deducting_amount = $unattended * round($multiplying_factor);
                                        @endphp
                                        <p>Rs. {{$deducting_amount}}</p>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td>Receiving Amount</td>
                                    <td>Rs. {{$payment->amount}}</td>
                                </tr>

                            </tbody>
                        </table>
                        <br>
                        <br>

                        <div class="row mt-5">
                            <div class="col-md-6 text-left">
                                <P>______________<br>
                                    Paid By
                                </P>
                            </div>
                            <div class="col-md-6 text-right">
                                <P>______________<br>
                                    Received By
                                </P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</body>
</html>
