<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#">Perpustakaan SMK 9</a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/buku">Data buku</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/siswa">Data siswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/peminjaman">Data peminjaman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/history">History perpus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link logout-link" href="/logout">Logout?</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Your content goes here -->

<!-- Tambahkan ini di akhir body sebelum tag penutup </body> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.navbar-nav .nav-link').on('click', function() {
            $('.navbar-nav .nav-link').removeClass('clicked');
            $(this).addClass('clicked');
        });
    });
</script>
