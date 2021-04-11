# Struktur Keluarga

Requirement:
- php 7.2
- composer

# Instalasi

```sh
$ git clone https://github.com/sigits12/family-tree.git
$ cd family-tree
family-tree$ composer install
family-tree$ mv .env.example .env
family-tree$ touch database/database.sqlite
family-tree$ php artisan key:generate
family-tree$ php artisan migrate
family-tree$ php artisan migrate:refresh --seed
family-tree$ php artisan serve
```

## API
| Method | Endpoint | Fungsi |
| ------ | ------ | ------ |
| GET | api/anggota | List seluruh anggota
| POST | api/anggota | Simpan anggota
| GET | api/anggota/{id} | Mendapatkan anggota berdasarkan id
| PUT | api/anggota/{id} | Merubah anggota berdasarkan id
| DELETE | api/anggota/{id} | Menghapus anggota berdasarkan id
