# Yapay Zeka Destekli WordPress Otomatik Yorum

Alternatif İndirme Link: [TIKLA İNDİR](https://s6.dosya.tc/server22/y8ldxc/meyil-rastgele-yorum.zip.html).

*WordPress sitenizi yapay zeka destekli veya manuel yorumlarla canlandırın!*

**Yapay Zeka Destekli WordPress Otomatik Yorum**, WordPress sitelerindeki yazılara manuel yorum eklemenizi veya Google’ın Gemini API’sini kullanarak doğal ve gerçekçi otomatik yorumlar oluşturmanızı sağlayan ücretsiz bir eklentidir. Rastgele ad, soyad, IP adresi, e-posta ve web sitesi bilgileriyle yorumlarınızı organik hale getirir, böylece siteniz daha aktif ve çekici görünür. SEO’yu güçlendirmek, yorum sistemini test etmek veya etkileşimi artırmak için mükemmel bir çözüm! 🚀

## Özellikler

- **Manuel Yorum Ekleme**: Kendi yorumlarınızı seçtiğiniz yazılara kolayca ekleyin.
- **Yapay Zeka Destekli Otomatik Yorumlar**: Gemini API ile yazıya uygun, benzersiz yorumlar üretin (bir seferde en fazla 3 yorum).
- **Rastgele Veri Kullanımı**: Ad, soyad, IP, e-posta ve web sitesi bilgileri otomatik olarak atanır, yorumlar gerçekçi görünür.
- **Kullanıcı Dostu Arayüz**: Select2 ile kolay yazı seçimi ve düzenli bir yönetim paneli.
- **Güvenli Tasarım**: Nonce doğrulaması, veri sanitizasyonu ve `.htaccess` ile dosya koruması.
- **SEO Avantajı**: Sitenizin aktif ve ilgi çekici görünmesini sağlayarak arama motoru sıralamalarını destekler.
- **Tamamen Ücretsiz**: Hiçbir ücret veya premium sürüm olmadan tüm özelliklere erişim!

## Kurulum

Eklentiyi WordPress sitenize kurmak için aşağıdaki adımları izleyin:

1. **Eklentiyi İndirin**:

   - Bu depoyu klonlayın: `git clone https://github.com/hetrx/WordPress-Otomatik-Yorum.git`
   - Veya Releases sayfasından ZIP dosyasını indirin.

2. **WordPress’e Yükleyin**:

   - WordPress yönetim panelinize gidin: `Eklentiler > Yeni Ekle > Eklenti Yükle`.
   - ZIP dosyasını yükleyin veya eklenti klasörünü `/wp-content/plugins/` dizinine kopyalayın.
   - Eklentiler menüsünden eklentiyi etkinleştirin.

3. **Veri Dosyalarını Kontrol Edin**:

   - Eklenti etkinleştirildiğinde, aşağıdaki dosyalar eklenti dizininde otomatik olarak oluşturulur:
     - `ad.txt` (isimler)
     - `soyad.txt` (soyadlar)
     - `ip.txt` (IP adresleri)
     - `email.txt` (e-posta adresleri)
     - `site.txt` (web sitesi URL’leri)
   - Bu dosyalara kendi verilerinizi ekleyerek yorumları özelleştirebilirsiniz.

4. **Opsiyonel: Gemini API Ayarları**:

   - Otomatik yorum özelliği için [Google AI Studio](https://ai.google.dev) üzerinden bir Gemini API anahtarı alın.
   - WordPress yönetim panelinde `Rastgele Yorum` menüsüne gidin ve API anahtarınızı kaydedin.

Detaylı bir rehber için blog yazımıza göz atın: [Yapay Zeka Destekli WordPress Otomatik Yorum Eklentisi](https://meyil.net/yapay-zeka-destekli-wordpress-otomatik-yorum-eklentisi).

## Kullanım

Eklenti etkinleştirildiğinde, WordPress yönetim panelinize **Rastgele Yorum** adında bir menü ekler. İşte kullanım adımları:

### Manuel Yorum Ekleme

1. Yönetim panelinde `Rastgele Yorum` menüsüne gidin.
2. Açılır menüden yorum eklemek istediğiniz yazıyı seçin (Select2 ile kolay arama).
3. Yorum içeriğinizi yazın.
4. İsteğe bağlı olarak ad, soyad, IP, e-posta ve web sitesi bilgilerini girin. Boş bırakırsanız rastgele veriler kullanılır.
5. “Web sitesi ekleme” kutusunu işaretleyerek web sitesi bilgisini hariç tutabilir veya “Yorumu Direkt Yayınla” seçeneğiyle yorumu onay beklemeden yayınlayabilirsiniz.
6. **Yorum Ekle** butonuna tıklayın.

### Yapay Zeka Destekli Otomatik Yorumlar

1. Gemini API anahtarınızın kaydedildiğinden emin olun.
2. `Rastgele Yorum` menüsünde bir yazı seçin.
3. Bir prompt girin (örneğin, “Bu yazıya olumlu bir yorum yaz”).
4. Yorum sayısını (1–3) seçin.
5. “Yorumları Direkt Yayınla” seçeneğini işaretleyerek yorumları hemen yayınlayabilirsiniz.
6. **Otomatik Yorum Ekle** butonuna tıklayın; eklenti, AI tarafından üretilen yorumları rastgele verilerle ekler.

### Örnek Prompt ve Çıktı

**Prompt**: “Bu yazıya olumlu bir yorum yaz”\
**Çıktı**:

> “Bu yazı harika! Verdiğiniz ipuçları çok faydalı, hemen deneyeceğim. Teşekkürler!”\
> **– Ahmet Yılmaz, ahmetyilmaz1982@gmail.com**

## Gereksinimler

- **WordPress**: Sürüm 5.0 veya üzeri
- **PHP**: Sürüm 7.4 veya üzeri
- **Gemini API Anahtarı**: Otomatik yorum özelliği için gerekli (manuel yorumlar için opsiyonel)
- **Select2 Kütüphanesi**: Eklenti tarafından otomatik yüklenir
- **cURL**: API istekleri için sunucuda etkin olmalı

## Güvenlik

- **Nonce Doğrulaması**: CSRF saldırılarına karşı koruma.
- **Veri Sanitizasyonu**: Kullanıcı girdileri XSS veya enjeksiyon saldırılarına karşı temizlenir.
- **Dosya Koruması**: Veri dosyaları `.htaccess` ile korunur (`Deny from all`).
- **Erişim Kontrolü**: Yalnızca `manage_options` veya `edit_others_posts` yetkisine sahip kullanıcılar eklentiyi kullanabilir.

## Sıkça Sorulan Sorular (SSS)

### Eklenti gerçekten ücretsiz mi?

Evet, **Yapay Zeka Destekli WordPress Otomatik Yorum** tamamen ücretsizdir. Premium sürüm veya gizli ücret yoktur.

### Gemini API anahtarı zorunlu mu?

Hayır, yalnızca otomatik yorum özelliği için gereklidir. Manuel yorumlar API olmadan çalışır.

### Yorumlar gerçekçi görünüyor mu?

Evet! Rastgele ad, soyad, IP, e-posta ve web sitesi bilgileriyle yorumlar organik bir görünüm kazanır.

### SEO’ya nasıl katkı sağlar?

Yorumlar, yazılarınızın aktif ve ilgi çekici görünmesini sağlar, bu da arama motoru sıralamalarını olumlu etkiler.

### Veri dosyalarını özelleştirebilir miyim?

Evet, `ad.txt`, `soyad.txt`, `ip.txt`, `email.txt` ve `site.txt` dosyalarına kendi verilerinizi ekleyebilirsiniz.

## Katkıda Bulunma

Eklentiyi daha iyi hale getirmek için katkılarınızı bekliyoruz! İşte nasıl katkıda bulunacağınız:

1. Depoyu fork edin.
2. Yeni bir dal oluşturun: `git checkout -b ozellik/yeni-ozellik-adi`.
3. Değişikliklerinizi yapın ve commit edin: `git commit -m "Yeni özellik eklendi"`.
4. Dalınızı push edin: `git push origin ozellik/yeni-ozellik-adi`.
5. Bir Pull Request açın.

## Lisans

Bu eklenti [GPLv2](https://www.gnu.org/licenses/gpl-2.0.html) veya sonraki sürümler altında lisanslanmıştır. Lisans şartlarına uygun olarak kullanabilir, değiştirebilir ve dağıtabilirsiniz.

## Destek

- **Sorun Bildirimi**: Hata raporları veya özellik önerileri için meyil.net üzerinden iletişime geçebilirsiniz.
- **Dokümantasyon**: Blog yazımızda detaylı rehberi okuyun: [Yapay Zeka Destekli WordPress Otomatik Yorum Eklentisi](https://meyil.net/yapay-zeka-destekli-wordpress-otomatik-yorum-eklentisi).

## Teşekkür

Eklenti, hetrx (mey1L) tarafından geliştirilmiştir. WordPress topluluğuna ve Google’ın Gemini API’sine bu eklentiyi mümkün kıldığı için teşekkürler!

---

🌟 Eklentiyi beğendiyseniz **depoyu yıldızlamayı** unutmayın!\
📬 **Geri bildirimleriniz** benim için önemli—eklentiyi nasıl kullandığınızı paylaşın!
