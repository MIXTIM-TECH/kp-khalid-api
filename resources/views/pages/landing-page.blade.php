@extends('root')

@section('content')
    {{-- header --}}
    @include('components.header')

    {{-- content --}}
    <div class="page-content">
        <section class="row top-content mt-5" id="beranda">
            <div class="col-12">
                <div class="row">
                    <div class="col-8 pt-4">
                        <h4 class="fs-2">Ajukan Surat, Hanya Dengan Sentuhan Jari dengan Polandu JK</h4>
                        <p>Polandu JK (Pos Pelayanan Terpadu Jembatan Kecil) adalah sebuah website untuk mempermudah
                            masyarakat Kelurahan Jembatan Kecil dalam pengajuan surat-surat secara daring seperti surat
                            keterangan tidak mampu, surat pengantar perkawinan, surat keterangan usaha dan surat lainnya.
                        </p>
                        <div class="d-flex">
                            <button class="btn btn-primary" type="submit">Ajukan Sekarang</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card p-5">
                            <div class="bg-image p-5" style="">
                                Foto Aplikasi
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="middle-content mt-5" id="tentang-kami">
            <div class="row">
                <div class="header col-12 d-flex justify-content-center">
                    <h2 class="section-title">Tentang Polandu JK</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="content col-10 text-center mx-auto">
                    <p>Polandu JK adalah website untuk masyarakat Kelurahan Jembatan Kecil yang memungkinkan pengajuan
                        surat-surat secara daring, seperti surat keterangan tidak mampu dan surat pengantar perkawinan.
                        Dengan Polandu JK, pengguna dapat mengurus surat secara online dan mempercepat proses
                        pengambilannya. Tujuannya adalah mempermudah akses layanan administrasi publik dan meningkatkan
                        efisiensi pelayanan.</p>
                </div>
            </div>
            <div class="row text-white">
                <div class="col-md-4 col-sm-12">
                    <div class="card bg-primary">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <i class="fa-regular fa-file-plus">Ikon</i>
                                <p class="card-text">
                                    Kemudahan Pengajuan Surat Secara Daring
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card bg-primary">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <i class="fa-regular fa-file-plus">Ikon</i>
                                <p class="card-text">
                                    Kemudahan Pengajuan Surat Secara Daring
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card bg-primary">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <i class="fa-regular fa-file-plus">Ikon</i>
                                <p class="card-text">
                                    Kemudahan Pengajuan Surat Secara Daring
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="middle-content maps mt-5" id="hubungi-kami">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <h2 class="card-title text-center mb-5">Hubungi Kami</h2>
                        <div class="col-md-6 col-sm-12">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15923.969664538357!2d102.27807468398903!3d-3.8117180282139285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e36b070b1f9cd3d%3A0xb9826b5d76f31f82!2sJemb.%20Kecil%2C%20Kec.%20Singaran%20Pati%2C%20Kota%20Bengkulu%2C%20Bengkulu!5e0!3m2!1sid!2sid!4v1684901331283!5m2!1sid!2sid"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <form class="form" method="post">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="email" class="sr-only">Email</label>
                                        <input type="email" id="email" class="form-control" placeholder="Email"
                                            name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama" class="sr-only">Nama Lengkap</label>
                                        <input type="text" id="nama" class="form-control" placeholder="Nama Lengkap"
                                            name="name">
                                    </div>
                                    <div class="form-group form-label-group">
                                        <label for="label-textarea">Pesan</label>
                                        <textarea class="form-control" id="label-textarea" rows="3" placeholder="Pesan"></textarea>

                                    </div>
                                </div>
                                <div class="form-actions d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1">Kirim Email</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- form login --}}
    @include('pages.components.login-form')

    {{-- form register --}}
    @include('pages.components.register-form')

    {{-- footer --}}
    @include('components.footer')
@endsection
