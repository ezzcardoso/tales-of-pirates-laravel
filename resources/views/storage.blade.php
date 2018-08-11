@extends('layouts.app')
@section('js')
    <script src="/js/storage.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
@endsection
@section('content')
    @auth
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">StorageBox</div>

                    <div class="card-body">


                        @if(isset($storages)>0)

                            <div class="table-responsive-sm">
                                <form id="form" method="post" action="">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Selecione</th>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>quantity</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($storages as $storage)

                                            <tr>
                                                <td><input class="storage" type="radio" id="storage" name="storage"
                                                           value="{{$storage->storage_id}}"></td>
                                                <td>
                                                    <img src="{{env('APP_URL') . '/img/icons/'.trim($storage->Icon).'.png'}}">
                                                </td>
                                                <td> {{$storage->ItemMall}}</td>
                                                <td> {{$storage->quantity}}</td>

                                            </tr>

                                        @endforeach


                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <hr>

                            @if(isset($charectes))
                                <div class="form-group">
                                    <label for="Character">Character:</label>
                                    <select class="form-control" id="character">
                                        <option value="">Selecione character</option>
                                        @foreach($charectes as $charecte)

                                            <option value="{{$charecte->cha_id}}">{{$charecte->cha_name}}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <button onclick="Assign(this)" type="button"
                                        class="btn btn-success float-right">Assign
                                </button>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection