@extends('layouts.app') @section('content') <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Basic Card</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#">Card</a>
                                </li>
                                <li class="breadcrumb-item active">Basic Card </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="grid"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="app-todo.html">
                                <i class="me-1" data-feather="check-square"></i>
                                <span class="align-middle">Todo</span>
                            </a>
                            <a class="dropdown-item" href="app-chat.html">
                                <i class="me-1" data-feather="message-square"></i>
                                <span class="align-middle">Chat</span>
                            </a>
                            <a class="dropdown-item" href="app-email.html">
                                <i class="me-1" data-feather="mail"></i>
                                <span class="align-middle">Email</span>
                            </a>
                            <a class="dropdown-item" href="app-calendar.html">
                                <i class="me-1" data-feather="calendar"></i>
                                <span class="align-middle">Calendar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Examples -->
            <section id="card-demo-example">
                <div class="row match-height">
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="../../../app-assets/images/slider/04.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text"> Some quick example text to build on the card title and make up the bulk of the card's content. </p>
                                <a href="#" class="btn btn-outline-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                            </div>
                            <img class="img-fluid" src="../../../app-assets/images/slider/03.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <p class="card-text">Bear claw sesame snaps gummies chocolate.</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Card title</h4>
                                <h6 class="card-subtitle text-muted">Support card subtitle</h6>
                                <img class="img-fluid my-2" src="../../../app-assets/images/slider/06.jpg" alt="Card image cap" />
                                <p class="card-text">Bear claw sesame snaps gummies chocolate.</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div> @endsection