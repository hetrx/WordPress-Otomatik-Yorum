# WordPress-Otomatik-Yorum
WordPress sitenizi yapay zeka destekli veya manuel yorumlarla canlandırın!
Yapay Zeka Destekli WordPress Otomatik Yorum, WordPress sitelerindeki yazılara manuel yorum eklemenizi veya Google’ın Gemini API’sini kullanarak doğal ve gerçekçi otomatik yorumlar oluşturmanızı sağlayan ücretsiz bir eklentidir. Rastgele ad, soyad, IP adresi, e-posta ve web sitesi bilgileriyle yorumlarınızı organik hale getirir, böylece siteniz daha aktif ve çekici görünür. SEO’yu güçlendirmek, yorum sistemini test etmek veya etkileşimi artırmak için mükemmel bir çözüm! 🚀
Özellikler

Manuel Yorum Ekleme: Kendi yorumlarınızı seçtiğiniz yazılara kolayca ekleyin.
Yapay Zeka Destekli Otomatik Yorumlar: Gemini API ile yazıya uygun, benzersiz yorumlar üretin (bir seferde en fazla 3 yorum).
Rastgele Veri Kullanımı: Ad, soyad, IP, e-posta ve web sitesi bilgileri otomatik olarak atanır, yorumlar gerçekçi görünür.
Kullanıcı Dostu Arayüz: Select2 ile kolay yazı seçimi ve düzenli bir yönetim paneli.
Güvenli Tasarım: Nonce doğrulaması, veri sanitizasyonu ve .htaccess ile dosya koruması.
SEO Avantajı: Sitenizin aktif ve ilgi çekici görünmesini sağlayarak arama motoru sıralamalarını destekler.
Tamamen Ücretsiz: Hiçbir ücret veya premium sürüm olmadan tüm özelliklere erişim!

Kurulum
Eklentiyi WordPress sitenize kurmak için aşağıdaki adımları izleyin:

Eklentiyi İndirin:

Bu depoyu klonlayın: git clone https://github.com/kullanici-adiniz/yapay-zeka-destekli-wp-otomatik-yorum.git
Veya Releases sayfasından ZIP dosyasını indirin.


WordPress’e Yükleyin:

WordPress yönetim panelinize gidin: Eklentiler > Yeni Ekle > Eklenti Yükle.
ZIP dosyasını yükleyin veya eklenti klasörünü /wp-content/plugins/ dizinine kopyalayın.
Eklentiler menüsünden eklentiyi etkinleştirin.


Veri Dosyalarını Kontrol Edin:

Eklenti etkinleştirildiğinde, aşağıdaki dosyalar eklenti dizininde otomatik olarak oluşturulur:
ad.txt (isimler)
soyad.txt (soyadlar)
ip.txt (IP adresleri)
email.txt (e-posta adresleri)
site.txt (web sitesi URL’leri)


Bu dosyalara kendi verilerinizi ekleyerek yorumları özelleştirebilirsiniz.


Opsiyonel: Gemini API Ayarları:

Otomatik yorum özelliği için Google AI Studio’dan bir Gemini API anahtarı alın.
WordPress yönetim panelinde Rastgele Yorum menüsüne gidin ve API anahtarınızı kaydedin.



Detaylı bir rehber için blog yazımıza göz atın: Blog yazınızın linkini buraya ekleyin.
Kullanım
Eklenti etkinleştirildiğinde, WordPress yönetim panelinize Rastgele Yorum adında bir menü ekler. İşte kullanım adımları:
Manuel Yorum Ekleme

Yönetim panelinde Rastgele Yorum menüsüne gidin.
Açılır menüden yorum eklemek istediğiniz yazıyı seçin (Select2 ile kolay arama).
Yorum içeriğinizi yazın.
İsteğe bağlı olarak ad, soyad, IP, e-posta ve web sitesi bilgilerini girin. Boş bırakırsanız rastgele veriler kullanılır.
“Web sitesi ekleme” kutusunu işaretleyerek web sitesi bilgisini hariç tutabilir veya “Yorumu Direkt Yayınla” seçeneğiyle yorumu onay beklemeden yayınlayabilirsiniz.
Yorum Ekle butonuna tıklayın.

Yapay Zeka Destekli Otomatik Yorumlar

Gemini API anahtarınızın kaydedildiğinden emin olun.
Rastgele Yorum menüsünde bir yazı seçin.
Bir prompt girin (örneğin, “Bu yazıya olumlu bir yorum yaz”).
Yorum sayısını (1–3) seçin.
“Yorumları Direkt Yayınla” seçeneğini işaretleyerek yorumları hemen yayınlayabilirsiniz.
Otomatik Yorum Ekle butonuna tıklayın; eklenti, AI tarafından üretilen yorumları rastgele verilerle ekler.

Örnek Prompt ve Çıktı
Prompt: “Bu yazıya olumlu bir yorum yaz”Çıktı:

“Bu yazı harika! Verdiğiniz ipuçları çok faydalı, hemen deneyeceğim. Teşekkürler!” – Ahmet Yılmaz, ahmetyilmaz1982@gmail.com

Gereksinimler

WordPress: Sürüm 5.0 veya üzeri
PHP: Sürüm 7.4 veya üzeri
Gemini API Anahtarı: Otomatik yorum özelliği için gerekli (manuel yorumlar için opsiyonel)
Select2 Kütüphanesi: Eklenti tarafından otomatik yüklenir
cURL: API istekleri için sunucuda etkin olmalı

Güvenlik

Nonce Doğrulaması: CSRF saldırılarına karşı koruma.
Veri Sanitizasyonu: Kullanıcı girdileri XSS veya enjeksiyon saldırılarına karşı temizlenir.
Dosya Koruması: Veri dosyaları .htaccess ile korunur (Deny from all).
Erişim Kontrolü: Yalnızca manage_options veya edit_others_posts yetkisine sahip kullanıcılar eklentiyi kullanabilir.

Sıkça Sorulan Sorular (SSS)
Eklenti gerçekten ücretsiz mi?
Evet, Yapay Zeka Destekli WordPress Otomatik Yorum tamamen ücretsizdir. Premium sürüm veya gizli ücret yoktur.
Gemini API anahtarı zorunlu mu?
Hayır, yalnızca otomatik yorum özelliği için gereklidir. Manuel yorumlar API olmadan çalışır.
Yorumlar gerçekçi görünüyor mu?
Evet! Rastgele ad, soyad, IP, e-posta ve web sitesi bilgileriyle yorumlar organik bir görünüm kazanır.
SEO’ya nasıl katkı sağlar?
Yorumlar, yazılarınızın aktif ve ilgi çekici görünmesini sağlar, bu da arama motoru sıralamalarını olumlu etkiler.
Veri dosyalarını özelleştirebilir miyim?
Evet, ad.txt, soyad.txt, ip.txt, email.txt ve site.txt dosyalarına kendi verilerinizi ekleyebilirsiniz.
Katkıda Bulunma
Eklentiyi daha iyi hale getirmek için katkılarınızı bekliyoruz! İşte nasıl katkıda bulunacağınız:

Depoyu fork edin.
Yeni bir dal oluşturun: git checkout -b ozellik/yeni-ozellik-adi.
Değişikliklerinizi yapın ve commit edin: git commit -m "Yeni özellik eklendi".
Dalınızı push edin: git push origin ozellik/yeni-ozellik-adi.
Bir Pull Request açın.

Lütfen Davranış Kurallarımıza uyun ve değişikliklerinizi iyi belgeleyin.
Lisans
Bu eklenti GPLv2 veya sonraki sürümler altında lisanslanmıştır. Lisans şartlarına uygun olarak kullanabilir, değiştirebilir ve dağıtabilirsiniz.
Destek

Sorun Bildirimi: Hata raporları veya özellik önerileri için GitHub Issues sayfasını kullanın.
Dokümantasyon: Blog yazımızda detaylı rehberi okuyun: Blog yazınızın linkini buraya ekleyin.
Topluluk: Tartışmalara katılmak için forumumuza göz atın: Forum linkinizi buraya ekleyin.

Teşekkür
Eklenti, [Kullanıcı Adınız/İsminiz] tarafından geliştirilmiştir. WordPress topluluğuna ve Google’ın Gemini API’sine bu eklentiyi mümkün kıldığı için teşekkürler!

🌟 Eklentiyi beğendiyseniz depoyu yıldızlamayı unutmayın!📬 Geri bildirimleriniz bizim için önemli—eklentiyi nasıl kullandığınızı paylaşın!
