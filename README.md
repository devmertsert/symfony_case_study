# Symfony Case Study
## _Yıllık izin talep ve takip takvimi_

## Tanım
İşletmede çalışan personellerin yıllık izinlerinin takip edilebileceği bir modülün backend geliştirmesine ihtiyaç vardır

- Personellerin eklenip, editlenip ve silinebileceği bir endpointin hazırlanması gerekmektedir
- Personel tablosu için gerekli olmazsa olmaz sahalar ad, soyad, işe giriş tarihi, işten çıkış tarihi, sgk sicil no, tc kimlik no, sahalara ihtiyaç görürseniz yenilerini ekleyebilirsiniz
- Personellere ait yıllık izinlerinin eklenebildiği, silinebildiği ve değiştirilebildiği endpointler gerekmektedir
- Verilen iki tarih arasında, Personel ad ve soyadı (birleşik yazılsa da otomatik bulabilen), izinli olup olmama durumu gibi filtrelere göre izinli/izinsiz personelin listelenebileceği bir endpointin hazırlanması gerekmektedir.

## Kurulum

Projeyi çalıştırabilmek için aşağıdaki adımları uygulayınız. (.env dosyası bu projeye özel olarak ignore edilmemiştir)

```sh
cd proje_dizini
```
```sh
composer install
```
```sh
php bin/console doctrine:database:create
```
```sh
php bin/console make:migration
```
```sh
php bin/console doctrine:migrations:migrate
```
```sh
symfony server:start
```

Proje çalışır duruma geldi. Kullanılabilir endpointler aşağıda listelenmiştir

# Endpoints

####  Personel oluşturmak:

Body formatı:
```json
{
    "ad": string,
    "soyad": string,
    "ise_giris_tarihi": Date,
    "isten_cikis_tarihi": Date (isteğe bağlı alan),
    "sgk_sicil_no": string,
    "tc_kimlik_no": bigint
}
```

| Method |               Endpoint                |         Body        |        Query        |
|:------:|:-------------------------------------:|:-------------------:|:-------------------:|
|  POST  | http://localhost:8000/employee/create | yukarıda belirtildi | yukarıda belirtildi |

####  Personel güncellemek:

Body formatı:
```json
{
    "ad": string (isteğe bağlı alan),
    "soyad": string (isteğe bağlı alan),
    "ise_giris_tarihi": Date (isteğe bağlı alan),
    "isten_cikis_tarihi": Date (isteğe bağlı alan),
    "sgk_sicil_no": string (isteğe bağlı alan),
    "tc_kimlik_no": bigint (isteğe bağlı alan)
}
```

| Method |                      Endpoint                       |        Body         |
|:------:|:---------------------------------------------------:|:-------------------:|
|  POST  | http://localhost:8000/employee/{employee_id}/update | yukarıda belirtildi |

####  Personel silmek:

| Method |                      Endpoint                       |        Body         |
|:------:|:---------------------------------------------------:|:-------------------:|
|  POST  | http://localhost:8000/employee/{employee_id}/delete |                     |

####  Yıllık izin oluşturmak:

Body formatı:
```json
{
    "employee_id": bigint (personel_id),
    "izin_baslangic_tarihi": Date (Örnek: 2022-12-12),
    "izin_bitis_tarihi": Date (Örnek: 2022-12-12)
}
```

| Method |              Endpoint               |         Body        |        Query        |
|:------:|:-----------------------------------:|:-------------------:|:-------------------:|
|  POST  | http://localhost:8000/permit/create | yukarıda belirtildi | yukarıda belirtildi |

####  Yıllık izin güncellemek:

Body formatı:
```json
{
    "izin_baslangic_tarihi": Date (Örnek: 2022-12-12) (isteğe bağlı alan),
    "izin_bitis_tarihi": Date (Örnek: 2022-12-12) (isteğe bağlı alan)
}
```

| Method |                    Endpoint                     |        Body         |
|:------:|:-----------------------------------------------:|:-------------------:|
|  POST  | http://localhost:8000/permit/{permit_id}/update | yukarıda belirtildi |

####  Yıllık izin silmek:

| Method |                    Endpoint                     |        Body         |
|:------:|:-----------------------------------------------:|:-------------------:|
|  POST  | http://localhost:8000/permit/{permit_id}/delete |                     |

### Yıllık izin arama
Verilen iki tarih arasına denk gelen yıllık izinleri listeler. Varsa ad soyad bilgisine göre de filtreler

Query Parametreleri:
| fullname (isteğe bağlı alan) |           izin_baslangic_tarihi           |           izin_bitis_tarihi           |
|:----------------------------:|:-----------------------------------------:|:-------------------------------------:|
|           Ad Soyad           | İzin başlangıç tarihi (Örnek: 2022-12-12) | İzin bitiş tarihi (Örnek: 2022-12-12) |

| Method |              Endpoint               |        Query        |
|:------:|:-----------------------------------:|:-------------------:|
|  POST  | http://localhost:8000/permit/search | yukarıda belirtildi |

#### Örnek arama URL:
http://localhost:8000/permit/search?fullname=adsoyad&izin_baslangic_tarihi=2022-12-12&izin_bitis_tarihi=2022-12-20