1. Membuat Router CI
   - Buka file app/config/Routes.php
   - Tambahkan kode
     ![Screenshot (1546)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/907b5bb6-3603-46e3-b6d9-28ac90f0b9f8)
   - Cek hasil dengan menjalankan php spark routes
     ![Screenshot (1548)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/773bcc7d-d671-4087-a4e4-48a5f73ac0f3)
  
2. Membuat Controller
   - buat file baru di dalam folder app/Controllers dengan nama Page.php dan isikan kode
     ![Screenshot (1549)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/dccf86e3-8c50-4beb-ae51-ddfcf8e3aaf5)
    
3. uji coba
   ![Screenshot (1551)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/f96122dc-442b-4d4c-8db3-40a0c26810c8)
   ![Screenshot (1552)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/42cc49ac-e148-4770-b534-67935636e052)
   ![Screenshot (1553)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/391547aa-ce98-4c68-8b1c-9e5c5223d8d7)

4. Setting AutoRoute
   - Tambahkan kode dibawah ini atau dengan mengedit file Routing
     ![Screenshot (1554)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/cabddf57-cebd-4ac7-8628-e13174d7b21e)
     
5. Tambahkan method baru
   - Tambahkan method tos() pada Controller Page kemudian jalankan di localhost:8080/index.php/page/tos
     ![Screenshot (1555)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/505849c3-f54a-40b9-aed9-f52fca2838c5)
     ![Screenshot (1558)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/aa9d97b0-20b7-4a45-8ef9-d63ef0066e3f)

=> untuk bisa menjalankan setAutoRoute maka nilai yang tadinya false diubah ke true

TANTANGAN !!
Buatlah method baru di page dengan nama biodata kemudian coba isikan tentang biodata anda dan tampilkan pada layer dengan memanggil method tersebut dengan perintah di browser untuk memanggil halaman biodata.
![Screenshot (1559)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/db0553a1-7107-4dac-bdf9-e7a2acb496c8)
![Screenshot (1560)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/16dd9a04-7f9e-4984-81ad-715cff2543b1)
![Screenshot (1561)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/638f6cbe-cdd8-4493-a144-fec5124385a2)
![Screenshot (1562)](https://github.com/xoraozgu017/PemWeb2/assets/145304971/f6a5fc3d-a1ea-4480-a3fc-120a79cd9182)
