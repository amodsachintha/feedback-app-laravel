@extends('layouts.app')
@section('content')
    <div class="container">
        @if(isset($months))
            <div class="row hidden-print" style="margin-bottom: 20px">
                <div class="col-md-2">
                    <form action="/set/year" class="form-inline">
                        <label for="year">Year: </label>
                        <select name="year" id="year" class="form-control" onchange='if(this.value != 0) { this.form.submit(); }'>
                            @for($i = 2016; $i <= intval(date('Y')); $i++)
                                @if($i == intval(session('summary_year')))
                                    <option value="{{$i}}" selected>{{$i}}</option>
                                @else
                                    <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                        </select>
                    </form>
                </div>
                <div class="col-md-10 hidden-print" align="left">
                    <div class="btn-group" role="group">
                        @foreach($months as $m)
                            @if(isset($month))
                                @if($loop->iteration == $month)
                                    <a href="/view/summary?month={{$loop->iteration}}&year={{session('summary_year')}}" type="button" class="btn btn-primary active">{{$m}}</a>
                                @else
                                    <a href="/view/summary?month={{$loop->iteration}}&year={{session('summary_year')}}" type="button" class="btn btn-primary">{{$m}}</a>
                                @endif
                            @else
                                <a href="/view/summary?month={{$loop->iteration}}&year={{session('summary_year')}}" type="button" class="btn btn-primary">{{$m}}</a>
                            @endif
                        @endforeach
                            <a href="/view/all?year={{session('summary_year')}}" type="button" class="btn btn-danger">{{session('summary_year')}}</a>
                    </div>
                </div>
            </div>
        @endif

        <div class="row" style="margin-bottom: 20px">
            <div class="col-md-10 col-md-offset-1" align="center">
                @if(isset($month))
                    <h3>{{date('Y F',strtotime(date(session('summary_year').'-'.$month)))}} ස‍ඳහා</h3>
                @else
                    <h3>{{date('Y',strtotime(date(session('summary_year').'-01-01')))}} වර්ෂය ස‍ඳහා</h3>
                @endif
            </div>
        </div>

        <div class="row" style="font-family: sans-serif">
            <div class="col-md-12" align="center">
                @if(isset($services))
                    @foreach($services as $service)
                        <div class="panel panel-default" style="-webkit-filter: drop-shadow(1px 2px 2px #c5c5c5); background-color: #fffffe">
                            <div class="panel-heading">
                                <strong>{{$service->service}}
                                    @if(isset($month))
                                        ({{date('Y M',strtotime(date('Y-'.$month)))}})
                                    @else
                                        {{"(".date('Y',strtotime(date('Y'))).")"}}
                                    @endif
                                </strong>
                            </div>
                            <div class="panel-body">
                                <table class="table table-condensed table-responsive table-bordered" style="text-align: center; color: black">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">ජා.හැ.අං</th>
                                        <th style="text-align: center">නම</th>
                                        <th style="text-align: center">දුරකථන අංකය</th>
                                        <th style="text-align: center">පළමු පැමිණීම</th>
                                        <th style="text-align: center">නවතම පැමිණීම</th>
                                        <th style="text-align: center">පැමිණි වාර</th>
                                        <th style="text-align: center">තත්ත්වය</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recs[$loop->iteration-1][$service->id] as $rec)
                                        @if($rec->n == 1)
                                            <tr class="success">
                                        @elseif($rec->n == 2)
                                            <tr class="warning">
                                        @else
                                            <tr class="danger">
                                                @endif
                                                <td><a href="/check/id?nic={{$rec->nic}}" class="hidden-print">{{$rec->nic}}</a>
                                                    <p class="visible-print">{{$rec->nic}}</p></td>
                                                <td>{{$rec->name}}</td>
                                                <td>{{$rec->mobile}}</td>
                                                <td>{{date('d M Y h:i A',strtotime($rec->date_time))}}</td>
                                                <td>{{date('d M Y h:i A',strtotime($rec->updated_at))}}</td>
                                                <td>{{$rec->n}}</td>
                                                <td>
                                                    @if($rec->resolved)
                                                        <span class="label label-success">විසඳන ලදි</span>
                                                    @else
                                                        <span class="label label-danger">විසඳා නැත</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        </div>


    </div>

@endsection