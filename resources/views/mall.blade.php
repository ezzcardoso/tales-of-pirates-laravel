@extends('layouts.app')
@section('js')
    <script src="/js/mall.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
@endsection
@auth()
@section('content')
    @if(count($malls)>0)

        <div class="card">
            <div class="card-header">Item mall E-commerce</div>
            <div class="card-body">


                <div class="table-responsive-sm">
                    <div style="overflow-x:auto;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quota</th>
                                <th>quantity</th>
                                <th>category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($malls as $mall)
                                @if($mall->Quota > 0)
                                    <tr>
                                        <td><img src="{{env('APP_URL') . '/img/icons/'.trim($mall->Icon).'.png'}}"></td>
                                        <td> {{ $mall->ItemName }}</td>
                                        <td> {{ $mall->ItemDesc }}</td>
                                        <td> {{ $mall->ItemPrice }}</td>
                                        <td> {{ $mall->Quota }} </td>
                                        <td> {{ $mall->quantity }}</td>
                                        <td> {{ $mall->category }}</td>
                                        <td>
                                            <button onclick="buy('{{$mall->MallID}}',this)" type="button"
                                                    class="btn btn-outline-primary">Buy
                                            </button>
                                        </td>
                                    </tr>

                                @endif
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        {{ $malls->links() }}

    @endif
@endsection
@endauth
