namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pustakawan Uji (Wajib sesuai modul: pustakawan@del.ac.id)
        User::updateOrCreate(
            ['email' => 'pustakawan@del.ac.id'],
            [
                'name' => 'Pustakawan Del',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Sampel Kategori
        $kategoriIT = Kategori::firstOrCreate(['nama_kategori' => 'Teknologi Informasi']);

        // 3. Sampel Buku (Wajib ada stok = 0 dan stok = 1 untuk uji ACID)
        $buku1 = Buku::updateOrCreate(
            ['isbn' => '978-602-001-1'],
            [
                'judul' => 'Pemrograman Web Lanjutan Laravel',
                'penulis' => 'Chandro Pardede',
                'stok' => 1,
                'kategori_id' => $kategoriIT->id,
            ]
        );

        $buku2 = Buku::updateOrCreate(
            ['isbn' => '978-602-002-2'],
            [
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Tim Dosen IT Del',
                'stok' => 0,
                'kategori_id' => $kategoriIT->id,
            ]
        );

        // 4. Sampel Peminjaman[cite: 7]
        Peminjaman::updateOrCreate(
            ['kode_pinjam' => 'PINJAM-2026-001'],
            [
                'buku_id' => $buku1->id,
                'nim_peminjam' => '12S24058',
                'nama_peminjam' => 'Airene Situmorang',
                'tanggal_pinjam' => Carbon::now()->subDays(2),
                'tanggal_jatuh_tempo' => Carbon::now()->addDays(5),
                'status' => 'dipinjam',
            ]
        );
    }
}