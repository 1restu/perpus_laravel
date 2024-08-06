@extends('layouts.index')

@section('title', 'Home')

@section('isihalaman')
    <div class="container-fluid">
        <!-- Jendela Melayang -->
        <div class="jendela-melayang position-relative text-center">
            <img src="{{ asset('assets/images/perpus1.jpg') }}" alt="Perpustakaan" class="w-100 rounded shadow">
            <h2 class="position-absolute top-50 start-50 translate-middle text-white display-4">Selamat datang di Perpustakaan SMK 9</h2>
        </div>

        <!-- Paragraf Penjelasan -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                <div class="paragraph-container p-4 rounded shadow-sm bg-light">
                    <h3 class="text-primary">Apa itu Perpustakaan SMK 9?</h3>
                    <p>Perpustakaan SMK 9 adalah pusat sumber daya yang menyediakan berbagai macam buku dan materi untuk mendukung kegiatan belajar mengajar. Kami berkomitmen untuk memfasilitasi siswa dengan bahan bacaan yang berkualitas dan ruang yang nyaman untuk membaca dan belajar.</p>
                </div>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-8">
                <div class="testimonial p-4 rounded shadow-sm bg-light">
                    <h3 class="text-primary">Apa kata mereka?</h3>
                    <p class="fst-italic text-muted">"Perpustakaan SMK 9 sangat membantu dalam mencari referensi dan bahan bacaan. Ruangannya nyaman dan koleksi bukunya lengkap."</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="row mt-4 mb-4">
            <div class="col text-center">
                <a href="/buku" class="cta-button btn btn-primary btn-lg">Jelajahi Koleksi Kami</a>
            </div>
        </div>
    </div>
@endsection
