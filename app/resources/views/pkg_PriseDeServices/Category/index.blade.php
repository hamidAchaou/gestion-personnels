@extends('layouts.app')

@section('content')
    <div class="content-header">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('success') }}.
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ __('Avancement') }}</h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{-- route('personnels.create') --}}" class="btn btn-info">
                            <i class="fas fa-plus"></i> {{ __('Nouveau catégorie') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header col-md-12">
                            <div class="d-flex justify-content-between">
                                <div class="col-4">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        </div>
                                        <select class="form-select form-control" id="filterSelectProjrctValue" aria-label="Filter Select">
                                            <option value="Echell">Echell</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="p-0">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="table_search" id="table_search" class="form-control" placeholder="Recherche">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-striped text-nowrap">
                                <thead>
                                    <tr>
                                        <th>personnels</th>
                                        <th>Echell</th>
                                        <th>Echellen</th>
                                        <th>Grad</th>
                                        <th class="text-center">État</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ahmed Ali</td>
                                        <td>26</td>
                                        <td>6</td>
                                        <td>Cadre superieur</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{--- route('personnels.show', ['personnel' => 1]) --}}" class='btn btn-default btn-sm'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>mohamed miftah</td>
                                        <td>23</td>
                                        <td>5</td>
                                        <td>Cadre superieur</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{-- route('personnels.show', ['personnel' => 2]) --}}" class='btn btn-default btn-sm'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>oumaima lmadani</td>
                                        <td>19</td>
                                        <td>4</td>
                                        <td>Cadre principal</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{-- route('personnels.show', ['personnel' => 3]) --}}" class='btn btn-default btn-sm'>
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-between p-2">
                            <div class="col-6 align-self-end">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fa-solid fa-file-arrow-down"></i> IMPORTER
                                </button>
                                <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-default btn-sm mt-0 mx-2">
                                    <i class="fa-solid fa-file-export"></i> EXPORTER
                                </button>
                            </div>
                            <div class="col-6">
                                <ul class="pagination m-0 float-right">
                                    <li class="page-item"><a class="page-link text-secondary" href="#">«</a></li>
                                    <li class="page-item"><a class="page-link text-secondary active" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link text-secondary" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link text-secondary" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link text-secondary" href="#">»</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id='page' value="1">
    </section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchData(page, searchValue) {
            $.ajax({
                url: '/personnels/?page=' + page + '&searchValue=' + searchValue,
                success: function(data) {
                    var newData = $(data);
                    $('tbody').html(newData.find('tbody').html());
                    $('#card-footer').html(newData.find('#card-footer').html());
                    var paginationHtml = newData.find('.pagination').html();
                    if (paginationHtml) {
                        $('.pagination').html(paginationHtml);
                    } else {
                        $('.pagination').html('');
                    }
                }
            });
        }

        $('body').on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var searchValue = $('#table_search').val();
            fetchData(page, searchValue);
        });

        $('body').on('keyup', '#table_search', function() {
            var page = $('#page').val();
            var searchValue = $('#table_search').val();
            fetchData(page, searchValue);
        });
    });

    function submitForm() {
        document.getElementById("importForm").submit();
    }
</script>
@endsection
