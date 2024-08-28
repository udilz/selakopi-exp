@extends('layouts.tables.meja')

@section('title')
    Meja 1
@endsection


@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark" id="home-section">
        <div class="container">
            <p class="navbar-brand" href="index.html">Selakopi Exp</p>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#probootstrap-nav"
                aria-controls="probootstrap-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="probootstrap-nav">
                @if (isset($tables))
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a href="index.html" class="nav-link">Home</a></li>
                        <li class="nav-item active"><a onclick="scrollToMenu()" class="nav-link"
                                style="cursor: pointer;">Menu</a>
                        </li>
                        <li class="nav-item active"><a href="{{ route('pelanggan.status_orderan', $tables->no_meja) }}"
                                onclick="select(this)" class="nav-link">List Order</a></li>
                        <li class="nav-item active"><a onclick="scrollToContact()" style="cursor: pointer"
                                class="nav-link">Contact</a></li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <section class="probootstrap-cover overlay">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center probootstrap-vh-100">
                <div class="col-md-8">
                    <h1 class="probootstrap-heading">Fun. Fast. Tasty. Delicious.</h1>
                    <img class="navbar-brand-img" src="{{ asset('frontend/images/dashboard/coffe.png') }}" alt="">
                    <p style="margin-top: 20px; padding: 10px; "><a style="max-width: 30%; padding: 18px"
                            onclick="scrollToMenu()" class="btn btn-primary rounded">Our Menu</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('content')
    <form id="orderMakanan" action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        @if (isset($foods))
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 id="menu-section" class="title text-center">

                        Our Menu
                    </h4>
                </div>
            </div>

            <div class="row" style="margin-bottom: 500px">
                {{-- Start Loop Category --}}
                @foreach ($categories as $category)
                    <div class="col-md-12 mb-3">
                        <div>
                            <div>
                                <h5>
                                    <a class="btn btn-dark btn-block rounded-pill " data-toggle="collapse"
                                        href="#multiCollapseExample1{{ $category->slug }}" role="button"
                                        aria-expanded="false" aria-controls="multiCollapseExample1{{ $category->slug }}">

                                        @if ($category->name == 'Makanan')
                                            <i class="fas fa-utensils"></i>
                                        @elseif($category->name == 'Minuman')
                                            <i class="fas fa-cocktail"></i>
                                        @else
                                            <i class="fas fa-drumstick-bite"></i>
                                        @endif
                                        {{ $category->name }}
                                    </a>
                                </h5>
                            </div>
                            <div class="collapse multi-collapse" id="multiCollapseExample1{{ $category->slug }}">
                                <div class="card-body">
                                    <div class="row">
                                        {{-- Start Loop Food --}}
                                        @forelse ($foods as $food)
                                            @if ($food->categories->name == $category->name && $food->minimal_stock > 0)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card">
                                                        <img src="{{ url('storage/makanan-dan-minuman/' . $food->photo) }}"
                                                            class="card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <h5 class="card-title">{{ $food->name }}</h5>
                                                            <p class="card-text">Rp. {{ formatRupiah($food->harga_beli) }}
                                                            </p>
                                                            <p class="card-text">Stock : {{ $food->minimal_stock }}</p>
                                                            <input type="hidden" name="foods[]"
                                                                value="{{ $food->id }}">

                                                            <input type="number" name="qty[]" class="form-control"
                                                                min="0" placeholder="Qty">

                                                            <select hidden name="status" class="form-control">
                                                                <option selected value="0">Menunggu Konfirmasi</option>
                                                            </select>
                                                            <input type="hidden" name="no_meja"
                                                                value="{{ $tables->no_meja }}">
                                                            <input type="hidden" name="tables[]"
                                                                value="{{ $tables->no_meja }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                            <div class="col-md-12">Produk Tidak Tersedia</div>
                                        @endforelse
                                        {{-- End Loop Food --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- End Loop Category --}}
            </div>
        @endif
    @endsection

    @section('tabsMenu')
    <div class="fixed-bottom mb-4 text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <span class="badge badge-danger name_error"></span>
                    <div class="input-group">
                        <input autofocus type="text" class="form-control" name="name" placeholder="Isi Nama Pemesan">
                        <div class="input-group-append">
                            @if (isset($tables))
                            <button style="" type="submit" class="button-pesan btn btn-danger btn-sm">
                                <span class="fas fa-cart-arrow-down"></span>
                                Pesan
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('footer')
    <footer class="footer-section  probootstrap-footer bg-dark">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md mb-4">
                            <h2 id="contact-section" class="probootstrap-heading probootstrap-footer-logo"><a
                                    href="https://www.instagram.com/sela_experience/">Selakopi EXP</a>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="probootstrap-footer-widget mb-4">
                        <ul class="probootstrap-footer-social list-unstyled float-md-right float-lft">
                            <li><a href="https://www.instagram.com/sela_experience/"><img
                                        src="{{ asset('frontend/images/footer/instagram.png') }}"
                                        style="width: 60px; height: 60px;" alt=""></a></li>
                            <li><a href="https://www.facebook.com/p/Sela-Kopi-100069743885017/"><img
                                        src="{{ asset('frontend/images/footer/facebook.png') }}"
                                        style="width: 60px; height: 60px;" alt=""></a></li>
                            <li><a href="https://www.tiktok.com/@sela_kopi"><img
                                        src="{{ asset('frontend/images/footer/tiktok.png') }}"
                                        style="width: 60px; height: 60px;" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md text-left">
                    <ul class="list-unstyled footer-small-nav">
                        <li><a onclick="scrollToHome()" style="cursor: pointer;">Home</a></li>
                        <li><a onclick="scrollToMenu()" style="cursor: pointer;">Menu</a></li>
                        <li><a onclick="scrollToContact()" style="cursor: pointer;">Contact</a></li>

                    </ul>
                </div>
                <div class="col-md text-md-right text-left">
                    <p>&copy; Selakopi EXP 2024. All Rights Reserved. <br> </p>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('footer-scripts')
    @include('frontend.order.scripts')
@endsection
