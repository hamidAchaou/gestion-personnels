@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Historique des missions</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-xl-3">
                    <div class="card card-purple card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../assets/images/user.png"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">Mohamed Ali</h3>
                            <p class="text-muted text-center">143322</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Fonction</b> <a class="float-right text-purple">Developper</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right text-purple">+212798763543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Type</b> <a class="float-right text-purple">Directeur</a>
                                </li>
                            </ul>
                            <a href="/view/personnels/more-info.php" class="btn bg-purple btn-block"
                                style="margin-top: 2rem"><b>Plus
                                    d'informations</b></a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 col-xl-9">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-purple card-outline">
                                        <div class="card-header col-md-12">
                                            <div class="row justify-content-between">
                                                <div class="col-6">
                                                    <div class="d-flex justify-content-start">
                                                        <div class=" p-0">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-default">
                                                                        <i class="fa-solid fa-calendar"></i>
                                                                    </button>
                                                                </div>
                                                                <input type="text" name="daterange"
                                                                    value="07/03/2024 - 12/03/2024" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">

                                                        <div class=" p-0">
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" name="table_search"
                                                                    class="form-control" placeholder="Recherche">
                                                                <div class="input-group-append">
                                                                    <button type="submit" class="btn btn-default">
                                                                        <i class="fas fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @include('pkg_OrderDesMissions/showTable')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id='page' value="1">
                    </section>

                </div>

            </div>

        </div>
    </section>
@endsection
